<?php

namespace Products\Models;

use Campaigns\Models\Campaign;
use Campaigns\Models\CampaignProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url'
    ];

    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class)->using(CampaignProduct::class);
    }
}
