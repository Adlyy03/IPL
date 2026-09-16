<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JenisIuranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $jenisIuranId = $this->route('jenis_iuran')?->id ?? $this->route('jenis_iuran');

        return [
            'nama_iuran' => [
                'required',
                'string',
                'max:100',
                Rule::unique('jenis_iurans', 'nama_iuran')->ignore($jenisIuranId),
            ],
            'nominal' => ['required', 'numeric', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
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
            'nama_iuran.required' => 'Nama jenis iuran wajib diisi.',
            'nama_iuran.unique' => 'Nama jenis iuran sudah ada.',
            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.min' => 'Nominal tidak boleh bernilai negatif.',
        ];
    }
}
