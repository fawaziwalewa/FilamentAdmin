<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->unique()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'visibility' => rand(0,1),
            'availability' => now(),
            'price' => fake()->numberBetween(100,2000),
            'compare_at_price' => fake()->numberBetween(100,2000),
            'cost_per_item' => fake()->numberBetween(100,2000),
            'sku' => fake()->unique()->numberBetween(10000,15000),
            'barcode' => fake()->unique()->numberBetween(10000,15000),
            'quantity' => rand(1,10),
            'security_stock' => rand(100,1000),
            'returnable' => rand(0,1),
            'shipped' => rand(0,1),
        ];
    }
}
