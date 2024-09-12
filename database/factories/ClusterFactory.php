<?php

namespace Database\Factories;

use Campaigns\Models\Campaign;
use Geolocations\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ClusterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Cluster::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }

    public function hasCampaign($is_active = false)
    {
        return $this->afterCreating(function (Cluster $cluster) use($is_active) {
            $campaign = Campaign::factory()->create();
            $cluster->campaigns()->attach(
                $campaign->id,
                ['is_active' => $is_active]
            );
        });
    }
}
