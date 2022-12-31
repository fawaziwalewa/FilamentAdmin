<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
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
            'name' => $name,
            'slug' => Str::slug($name),
            'website' => fake()->url(),
            'visibility' => rand(0,1),
            'description' => fake()->paragraph(),
        ];
    }
}
