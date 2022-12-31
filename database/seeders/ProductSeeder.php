<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::factory()->count(50)->create();
        $categories = Category::factory()->count(50)->create();

        Product::factory()->count(1000)->has(ProductImage::factory()->count(1), 'product_images')->create()
        ->each(function($products) use($brands, $categories){
            $products->brands()->attach($brands->random(2));
            $products->categories()->attach($categories->random(2));
        });
    }
}
