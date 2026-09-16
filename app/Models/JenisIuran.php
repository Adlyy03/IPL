<?php

namespace App\Models;

use Database\Factories\JenisIuranFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisIuran extends Model
{
    /** @use HasFactory<JenisIuranFactory> */
    use HasFactory;

    protected $table = 'jenis_iurans';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_iuran',
        'nominal',
        'deskripsi',
        'is_aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'is_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke data Iuran Warga.
     */
    public function iuranWargas(): HasMany
    {
        return $this->hasMany(IuranWarga::class, 'jenis_iuran_id');
    }
}
