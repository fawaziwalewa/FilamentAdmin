<?php

namespace Tests\Feature;

use App\Filament\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Filament\Pages\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;
use Str;

uses(RefreshDatabase::class);

test('check if admin exist if not create new and check access to admin page', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get('/admin');
    $response->assertStatus(200);
});

test('admin user can view product resource pages', function () {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)->get(ProductResource::getUrl('index'))->assertStatus(200);

    $this->actingAs($user)->get(ProductResource::getUrl('create'))->assertStatus(200);
});

test('admin user can create product', function () {
    $user = User::factory()->admin()->create();

    $brands     = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $name = fake()->unique()->name();

    $this->actingAs($user)->
    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
            'name'             => $name,
            'slug'             => Str::slug($name),
            'description'      => fake()->paragraph(),
            'visibility'       => rand(0,1),
            'availability'     => now(),
            'price'            => fake()->numberBetween(100,2000),
            'compare_at_price' => fake()->numberBetween(100,2000),
            'cost_per_item'    => fake()->numberBetween(100,2000),
            'sku'              => fake()->unique()->numberBetween(10000,15000),
            'barcode'          => fake()->unique()->numberBetween(10000,15000),
            'quantity'         => rand(1,10),
            'security_stock'   => rand(100,1000),
            'returnable'       => rand(0,1),
            'shipped'          => rand(0,1),
            'categories'       => $categories[0]->id,
            'brands'           => $brands[0]->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Product::class, [
        'name' => $name,
        'slug' => Str::slug($name),
    ]);
});

test('admin user can edit product', function () {
    $brands     = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $product = Product::factory()->count(1)->has(ProductImage::factory()->count(1), 'product_images')->create()
        ->each(function ($products) use ($brands, $categories) {
            $products->brands()->attach($brands->random(2));
            $products->categories()->attach($categories->random(2));
        });

    livewire(ProductResource\Pages\EditProduct::class, [
        'record' => $product[0]->getKey(),
    ])->assertFormSet([
        'id' => $product[0]->getKey(),
    ]);
});

test('admin user can delete product', function () {
    $brands     = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $product = Product::factory()->count(1)->has(ProductImage::factory()->count(1), 'product_images')->create()
        ->each(function ($products) use ($brands, $categories) {
            $products->brands()->attach($brands->random(2));
            $products->categories()->attach($categories->random(2));
        });

    livewire(ProductResource\Pages\EditProduct::class, [
        'record' => $product[0]->getKey(),
    ])->callPageAction(DeleteAction::class);

    $this->assertModelMissing($product[0]);
});
