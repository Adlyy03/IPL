<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IuranWargaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'warga_id' => ['required', 'exists:wargas,id'],
            'jenis_iuran_id' => ['required', 'exists:jenis_iurans,id'],
            'periode' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'status_pembayaran' => ['required', Rule::in(['menunggu_pembayaran', 'lunas', 'batal'])],
            'tanggal_pembayaran' => ['nullable', 'date'],
            'catatan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'warga_id.required' => 'Warga wajib dipilih.',
            'warga_id.exists' => 'Warga tidak ditemukan.',
            'jenis_iuran_id.required' => 'Jenis iuran wajib dipilih.',
            'jenis_iuran_id.exists' => 'Jenis iuran tidak ditemukan.',
            'periode.required' => 'Periode wajib diisi.',
            'periode.regex' => 'Format periode harus YYYY-MM (contoh: 2026-09).',
            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'status_pembayaran.required' => 'Status pembayaran wajib dipilih.',
        ];
    }
}
