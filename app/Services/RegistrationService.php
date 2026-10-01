<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use DomainException;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    /**
     * Mendaftarkan peserta pada satu kegiatan.
     *
     * Semua pemeriksaan aturan dilakukan sebelum menyentuh database,
     * sehingga proses penyimpanan hanya berisi operasi yang sudah pasti sah.
     */
    public function register(Activity $activity, array $data): Registration
    {
        // IC-01: hanya kegiatan Published yang boleh didaftari.
        if ($activity->status !== 'Published') {
            throw new DomainException('Hanya kegiatan berstatus Published yang dapat didaftari.');
        }

        // IC-02: pendaftaran ditutup setelah kegiatan dimulai.
        if ($activity->start_at !== null && $activity->start_at <= now()) {
            throw new DomainException('Kegiatan sudah dimulai, pendaftaran ditutup.');
        }

        // IC-04: kapasitas masih tersedia.
        if ($activity->capacity <= 0 || $activity->registrations()->count() >= $activity->capacity) {
            throw new DomainException('Kapasitas kegiatan sudah penuh, pendaftaran ditutup.');
        }

        // IC-05: Registration dan registered_count harus berhasil bersama.
        return DB::transaction(function () use ($activity, $data) {
            $registration = $activity->registrations()->create([
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => now(),
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}
