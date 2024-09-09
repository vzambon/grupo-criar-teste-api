<?php

namespace Campaigns\Models;

use Geolocations\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Products\Models\Product;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_campaign_pivot');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->using(CampaignProduct::class);
    }
}
