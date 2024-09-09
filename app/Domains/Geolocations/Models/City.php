<?php

namespace Geolocations\Models;

use App\Builders\MeiliBuilder;
use Database\Factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class City extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'id',
        'name',
        'is_active',
        'state_id',
    ];

    protected static $searchable = [
        'name',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return CityFactory::new();
    }

    public function newEloquentBuilder($query)
    {
        return new MeiliBuilder($query);
    }

    public static function getSearchable(): array
    {
        return self::$searchable;
    }

    /* ===== RELATIONSHIPS ===== */

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function cluster(): BelongsToMany
    {
        return $this->belongsToMany(Cluster::class, 'city_cluster_pivot')->using(CityCluster::class);
    }
}
