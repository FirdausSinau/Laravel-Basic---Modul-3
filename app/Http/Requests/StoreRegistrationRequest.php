<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi format input pendaftaran.
     */
    public function rules(): array
    {
        $activityId = $this->route('activity')?->id;

        return [
            'participant_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:150',
                // IC-03: unik hanya di dalam kegiatan ini, bukan di seluruh tabel.
                Rule::unique('registrations', 'email')->where('activity_id', $activityId),
            ],
        ];
    }
}
