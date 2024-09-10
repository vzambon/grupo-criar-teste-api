<?php

namespace Products\Models;

use Campaigns\Models\Campaign;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url',
    ];

    protected $hidden = ['image_url'];

    protected $appends = ['img_url'];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    /* ===== ATTRIBUTES ====== */

    public function imgUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => URL::signedRoute('private-storage', ['disk' => 'private', 'filePath' => $this->image_url], null, false)
        );
    }

    /* ===== RELATIONSHIPS ====== */

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'campaign_product_pivot');
    }
}
