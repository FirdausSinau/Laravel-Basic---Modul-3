<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;

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
}
