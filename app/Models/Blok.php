<?php

namespace App\Models;

use Database\Factories\BlokFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blok extends Model
{
    /** @use HasFactory<BlokFactory> */
    use HasFactory;

    protected $table = 'bloks';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'gang_id',
        'nama_blok',
        'nomor_rumah',
        'keterangan',
        'status',
    ];

    /**
     * Relasi ke data Gang.
     */
    public function gang(): BelongsTo
    {
        return $this->belongsTo(Gang::class, 'gang_id');
    }

    /**
     * Relasi ke data Warga.
     */
    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class, 'blok_id');
    }
}
