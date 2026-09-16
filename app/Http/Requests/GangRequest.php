<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $gangId = $this->route('gang')?->id ?? $this->route('gang');

        return [
            'nama_gang' => [
                'required',
                'string',
                'max:255',
                Rule::unique('gangs', 'nama_gang')->ignore($gangId),
            ],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_gang.required' => 'Nama gang wajib diisi.',
            'nama_gang.unique' => 'Nama gang sudah terdaftar.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
