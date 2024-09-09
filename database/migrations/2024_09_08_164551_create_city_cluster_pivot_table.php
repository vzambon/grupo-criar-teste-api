<?php

use Geolocations\Models\City;
use Geolocations\Models\Cluster;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city_cluster_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class);
            $table->foreignIdFor(Cluster::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city_cluster_pivot');
    }
};
