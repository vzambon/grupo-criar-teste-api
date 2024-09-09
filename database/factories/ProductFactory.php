<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Products\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->text(),
        ];
    }
}
