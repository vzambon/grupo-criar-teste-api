<?php

namespace Database\Factories;

use Geolocations\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\State>
 */
class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'acronym' => $this->faker->unique()->stateAbbr(),
            'name' => $this->faker->unique()->state(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
