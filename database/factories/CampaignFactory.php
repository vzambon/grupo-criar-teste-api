<?php

namespace Database\Factories;

use Campaigns\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'discount_value' => $this->faker->randomFloat(2, 1, 20),
            'discount_percentage' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
