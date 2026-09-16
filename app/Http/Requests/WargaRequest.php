<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $wargaId = $this->route('warga')?->id ?? $this->route('warga');

        return [
            'blok_id' => ['required', 'exists:bloks,id'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'nik' => [
                'nullable',
                'string',
                'size:16',
                Rule::unique('wargas', 'nik')->ignore($wargaId),
            ],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'peran_keluarga' => ['required', Rule::in(['kepala_keluarga', 'istri', 'anak', 'lainnya'])],
            'status_warga' => ['required', Rule::in(['tetap', 'kontrak', 'kost'])],
            'is_aktif' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_aktif' => $this->boolean('is_aktif', true),
        ]);
    }

    public function messages(): array
    {
        return [
            'blok_id.required' => 'Rumah / Blok wajib dipilih.',
            'blok_id.exists' => 'Data blok tidak valid.',
            'nama_lengkap.required' => 'Nama lengkap warga wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar pada data warga lain.',
            'peran_keluarga.required' => 'Peran dalam keluarga wajib dipilih.',
            'status_warga.required' => 'Status kependudukan wajib dipilih.',
        ];
    }
}
