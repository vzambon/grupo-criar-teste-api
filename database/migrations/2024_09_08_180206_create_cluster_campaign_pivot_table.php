<?php

use Campaigns\Models\Campaign;
use Geolocations\Models\Cluster;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cluster_campaign_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cluster::class);
            $table->foreignIdFor(Campaign::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster_campaign_pivot');
    }
};
