<?php

use Campaigns\Models\Campaign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Products\Models\Product;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_product_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Campaign::class);
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_product_pivot');
    }
};
