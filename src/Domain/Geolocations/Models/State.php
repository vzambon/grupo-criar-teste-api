<?php

namespace Geolocations\Models;

use Database\Factories\StateFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Support\Builders\MeiliBuilder;

class State extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'acronym',
        'name',
        'is_active',
    ];

    protected static $searchable = [
        'acronym',
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return StateFactory::new();
    }

    public function newEloquentBuilder($query)
    {
        return new MeiliBuilder($query);
    }

    public static function getSearchable(): array
    {
        return self::$searchable ?? [];
    }

    /* ===== RELATIONSHIPS ===== */

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
