<?php

namespace App\Models;

use Database\Factories\IuranWargaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IuranWarga extends Model
{
    /** @use HasFactory<IuranWargaFactory> */
    use HasFactory;

    protected $table = 'iuran_wargas';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'warga_id',
        'jenis_iuran_id',
        'periode',
        'nominal',
        'status_pembayaran',
        'tanggal_pembayaran',
        'catatan',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'tanggal_pembayaran' => 'datetime',
        ];
    }

    /**
     * Relasi ke data Warga.
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    /**
     * Relasi ke data Jenis Iuran.
     */
    public function jenisIuran(): BelongsTo
    {
        return $this->belongsTo(JenisIuran::class, 'jenis_iuran_id');
    }
}
