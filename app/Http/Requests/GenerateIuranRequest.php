<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateIuranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'jenis_iuran_id' => ['required', 'exists:jenis_iurans,id'],
            'periode' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'cakupan' => ['required', Rule::in(['semua', 'gang', 'blok'])],
            'gang_id' => ['nullable', 'required_if:cakupan,gang', 'exists:gangs,id'],
            'blok_id' => ['nullable', 'required_if:cakupan,blok', 'exists:bloks,id'],
            'hanya_kepala_keluarga' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'hanya_kepala_keluarga' => $this->boolean('hanya_kepala_keluarga', true),
        ]);
    }

    public function messages(): array
    {
        return [
            'jenis_iuran_id.required' => 'Jenis iuran wajib dipilih.',
            'jenis_iuran_id.exists' => 'Jenis iuran tidak valid.',
            'periode.required' => 'Periode tagihan wajib diisi.',
            'periode.regex' => 'Format periode harus YYYY-MM (contoh: 2026-09).',
            'nominal.required' => 'Nominal tagihan wajib diisi.',
            'cakupan.required' => 'Pilih cakupan warga yang ditagihkan.',
            'gang_id.required_if' => 'Pilih gang jika cakupan berdasarkan gang.',
            'blok_id.required_if' => 'Pilih blok jika cakupan berdasarkan blok.',
        ];
    }
}
