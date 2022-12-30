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
        $name = fake()->name();

        return [
            'images' => array(fake()->imageUrl(640,480), fake()->imageUrl(640,480)),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'visibility' => rand(0,1),
            'availability' =>  now(),
            'categories' =>  rand(1,49),
            'price' =>  rand(100,2000),
            'compare_at_price' =>  rand(100,2000),
            'cost_per_item' =>  rand(100,2000),
            'sku' =>  rand(10000,15000),
            'barcode' =>  rand(10000,15000),
            'quantity' =>  rand(1,50),
            'security_stock' =>  rand(100,1000),
            'returnable' =>  rand(0,1),
            'shipped' =>  rand(0,1),
        ];
    }
}
