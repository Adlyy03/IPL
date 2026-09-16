<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlokRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $blokId = $this->route('blok')?->id ?? $this->route('blok');

        return [
            'gang_id' => ['required', 'exists:gangs,id'],
            'nama_blok' => ['required', 'string', 'max:50'],
            'nomor_rumah' => [
                'required',
                'string',
                'max:20',
                Rule::unique('bloks', 'nomor_rumah')
                    ->where('gang_id', $this->input('gang_id'))
                    ->where('nama_blok', $this->input('nama_blok'))
                    ->ignore($blokId),
            ],
            'keterangan' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }

    public function messages(): array
    {
        return [
            'gang_id.required' => 'Gang wajib dipilih.',
            'gang_id.exists' => 'Gang yang dipilih tidak valid.',
            'nama_blok.required' => 'Nama blok wajib diisi.',
            'nomor_rumah.required' => 'Nomor rumah wajib diisi.',
            'nomor_rumah.unique' => 'Kombinasi Gang, Blok, dan Nomor Rumah tersebut sudah ada.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }
}
