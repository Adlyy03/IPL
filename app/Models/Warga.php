<?php

namespace App\Models;

use Database\Factories\WargaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Warga extends Model
{
    /** @use HasFactory<WargaFactory> */
    use HasFactory;

    protected $table = 'wargas';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'blok_id',
        'nama_lengkap',
        'nik',
        'nomor_hp',
        'peran_keluarga',
        'status_warga',
        'is_aktif',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke data Blok.
     */
    public function blok(): BelongsTo
    {
        return $this->belongsTo(Blok::class, 'blok_id');
    }

    /**
     * Relasi ke data Iuran Warga.
     */
    public function iuranWargas(): HasMany
    {
        return $this->hasMany(IuranWarga::class, 'warga_id');
    }
}
