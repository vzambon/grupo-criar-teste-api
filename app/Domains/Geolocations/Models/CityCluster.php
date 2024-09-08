<?php

namespace Geolocations\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CityCluster extends Pivot
{
    protected $table = 'city_cluster_pivot'; 

    public $incrementing = true;
}
