<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;
use Exception;

class ActivityService
{
    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $this->ensureValidTransition($activity->status, $data['status']);

        $activity->update($data);

        return $activity;
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        // Matriks transisi BR-03A: hanya boleh maju atau tetap pada status yang sama
        $allowed = [
            'Planned' => ['Planned', 'Ongoing'],
            'Ongoing' => ['Ongoing', 'Done'],
            'Done' => ['Done'],
        ];

        if (! in_array($next, $allowed[$current] ?? [], true)) {
            throw new DomainException("Transisi status dari {$current} ke {$next} tidak diperbolehkan.");
        }
    }

    public function publish(Activity $activity): Activity
    {
        // 1. Guard Transisi: hanya status draft yang boleh dipublish
        if ($activity->status !== 'draft' && $activity->status !== 'Planned') {
            throw new Exception("Transisi ilegal: Hanya kegiatan berstatus draft yang dapat dipublish.");
        }

        // 2. Guard Kelengkapan Data (BR-05): cek kelengkapan kolom wajib
        if (empty($activity->title) || empty($activity->category_id)) {
            throw new Exception("Validasi bisnis gagal: Data kegiatan belum lengkap untuk dipublish.");
        }

        $activity->update([
            'status' => 'published',
        ]);

        return $activity;
    }

    public function complete(Activity $activity): Activity
    {
        // Guard Transisi: hanya status published yang boleh diselesaikan
        if ($activity->status !== 'published') {
            throw new Exception("Transisi ilegal: Hanya kegiatan berstatus published yang dapat diselesaikan.");
        }

        $activity->update([
            'status' => 'completed',
        ]);

        return $activity;
    }
}
