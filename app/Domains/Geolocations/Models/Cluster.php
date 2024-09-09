<?php

namespace Geolocations\Models;

use Campaigns\Models\Campaign;
use Database\Factories\ClusterFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ClusterFactory::new();
    }

    /* ===== RELATIONSHIPS ===== */

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'city_cluster_pivot')->using(CityCluster::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class)->using();
    }
}
