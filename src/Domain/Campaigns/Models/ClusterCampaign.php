<?php

namespace Campaigns\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClusterCampaign extends Pivot
{
    protected $table = 'cluster_campaign_pivot'; 

    public $incrementing = true;
}
