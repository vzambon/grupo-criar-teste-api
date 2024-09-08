<?php

namespace Geolocations\Models;

use Campaigns\Models\Campaign;
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

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class)->using(CityCluster::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class)->using();
    }
}
