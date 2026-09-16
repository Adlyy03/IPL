<?php

namespace App\Models;

use Database\Factories\GangFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gang extends Model
{
    /** @use HasFactory<GangFactory> */
    use HasFactory;

    protected $table = 'gangs';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'nama_gang',
        'keterangan',
    ];

    /**
     * Relasi ke data Blok.
     */
    public function bloks(): HasMany
    {
        return $this->hasMany(Blok::class, 'gang_id');
    }
}
