<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Activity;
use App\Services\RegistrationService;
use DomainException;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    /**
     * Mendaftarkan peserta pada satu kegiatan.
     */
    public function store(
        StoreRegistrationRequest $request,
        Activity $activity,
        RegistrationService $service
    ): RedirectResponse {
        try {
            $service->register($activity, $request->validated());

            return back()->with('success', 'Pendaftaran berhasil.');
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
