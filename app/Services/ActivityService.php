<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;
use Illuminate\Support\Facades\Storage;

class ActivityService
{
    public function create(array $data): Activity
    {
        // Status awal selalu Draft, tidak pernah diambil dari input request.
        $data['status'] = 'Draft';

        if ($poster = $data['poster'] ?? null) {
            $data['poster_path'] = $poster->store('posters', 'public');
        }
        unset($data['poster']);

        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        if (isset($data['status']) && $data['status'] !== $activity->status) {
            $this->ensureValidTransition($activity->status, $data['status']);
        }

        $posterLama = $activity->poster_path;

        if ($poster = $data['poster'] ?? null) {
            $data['poster_path'] = $poster->store('posters', 'public');
        }
        unset($data['poster']);

        $activity->update($data);

        // File lama baru dihapus setelah file baru berhasil tersimpan,
        // supaya kegagalan penyimpanan tidak menghilangkan poster lama.
        if (isset($data['poster_path']) && $posterLama) {
            Storage::disk('public')->delete($posterLama);
        }

        return $activity;
    }

    /**
     * Memeriksa apakah transisi status diizinkan (BR-06, BR-07).
     */
    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = [
            'Draft' => ['Draft', 'Published'],
            'Published' => ['Published', 'Completed'],
            'Completed' => ['Completed'],
        ];

        if (! in_array($next, $allowed[$current] ?? [], true)) {
            throw new DomainException("Transisi status dari {$current} ke {$next} tidak diperbolehkan.");
        }
    }

    public function publish(Activity $activity): Activity
    {
        // 1. Guard Transisi: hanya status Draft yang boleh dipublikasikan
        if ($activity->status !== 'Draft') {
            throw new DomainException('Transisi ilegal: Hanya kegiatan berstatus Draft yang dapat dipublikasikan.');
        }

        // 2. Guard Kelengkapan Data (BR-05): validasi kolom Task 1 & Task 2
        if (
            empty($activity->category_id) ||
            empty($activity->code) ||
            empty($activity->title) ||
            empty($activity->location) ||
            empty($activity->capacity) ||
            $activity->capacity <= 0 ||
            $activity->capacity > 500 ||
            empty($activity->start_at) ||
            empty($activity->end_at) ||
            $activity->end_at->lt($activity->start_at)
        ) {
            throw new DomainException('Validasi bisnis gagal: Data kegiatan belum lengkap (lokasi, kapasitas 1-500, atau rentang waktu belum valid).');
        }

        $activity->update([
            'status' => 'Published',
        ]);

        return $activity;
    }

    public function complete(Activity $activity): void
    {
        if ($activity->status !== 'Published') {
            throw new DomainException('Hanya kegiatan berstatus Published yang dapat diselesaikan.');
        }

        $activity->update(['status' => 'Completed']);
    }
}
