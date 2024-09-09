<?php

namespace Campaigns\Models;

use Database\Factories\CampaignFactory;
use Geolocations\Models\Cluster;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Products\Models\Product;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_value',
        'discount_percentage',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $with = ['products'];

    protected $appends = ['price', 'final_price'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return CampaignFactory::new();
    }

    /* ===== ATRTIBUTES ===== */

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->products->pluck('price')->reduce(fn($carry, $item) => $carry+$item, 0)
        );
    }

    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => round(($this->price * (1 - $this->discount_percentage/100)) - $this->discount_value, 2)
        );
    }

    /* ===== RELATIONSHIPS ===== */

    public function clusters(): BelongsToMany
    {
        return $this->belongsToMany(Cluster::class, 'cluster_campaign_pivot')->withPivot(['is_active']);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'campaign_product_pivot');
    }
}
