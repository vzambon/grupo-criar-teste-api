<?php

namespace Campaigns\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CampaignProduct extends Pivot
{
    protected $table = 'campaign_product_pivot';

    public $incrementing = true;

    protected $fillable = [
        'discount_value',
        'discount_percentage',
        'final_price',
    ];
}
