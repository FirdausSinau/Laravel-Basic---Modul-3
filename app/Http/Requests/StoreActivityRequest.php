<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib diubah menjadi true agar request diizinkan
    }

    public function rules(): array
    {
        return [
            // BR-01: Judul 5-100 karakter
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:50'],
            // BR-02: Tanggal wajib dan valid
            'activity_date' => ['required', 'date'],
            // BR-03: Status hanya Planned, Ongoing, atau Done
            'status' => ['required', Rule::in(['Planned', 'Ongoing', 'Done'])],
        ];
    }
}