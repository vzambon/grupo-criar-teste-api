<?php

namespace Geolocations\Models;

use Campaigns\Models\Campaign;
use Database\Factories\ClusterFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ClusterFactory::new();
    }

    /* ===== ATTRIBUTES ===== */

    public function activeCampaign(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->campaigns()->wherePivot('is_active', true)->first()
        );
    }

    /* ===== RELATIONSHIPS ===== */

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'city_cluster_pivot');
    }

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'cluster_campaign_pivot')->withPivot(['is_active']);
    }
}
