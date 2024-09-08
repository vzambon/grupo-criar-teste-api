<?php

namespace Geolocations\Models;

use Database\Factories\StateFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'acronym',
        'name',
        'is_active',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return StateFactory::new();
    }

    /* ===== RELATIONSHIPS ===== */

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
