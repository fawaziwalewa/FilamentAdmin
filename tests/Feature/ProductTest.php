<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Str;
use Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;
use App\Models\Category;

use Filament\Pages\Actions\DeleteAction;
use App\Filament\Resources\ProductResource;

use function Pest\Livewire\livewire;

test('check if admin exist if not create new and check access to admin page', function () {
    $user = User::find(1);
    if (empty($user)) {
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('admin123@'),
        ]); // Create admin user
    }
    // Authenticate and check access to the admin shop page.
    $response = $this->actingAs($user)->get('/admin');
    $response->assertStatus(200);
});

test('admin user can show product', function () {
    $user = User::find(1);
    
    $products = Product::factory()->count(1)->create();

    $response = $this->actingAs($user)->get('/admin/shop/products');
    $response->assertStatus(200);
});

test('not admin user can not show product', function () {
    $user = User::factory()->create();
    // Can not show product page
    $response = $this->actingAs($user)->get('/admin/shop/products');
    $response->assertStatus(403);
});

test('admin user can show create product page', function(){
    $user = User::find(1);

    $this->actingAs($user)
        ->get(ProductResource::getUrl('create'))
        ->assertSuccessful();
});

test('not admin user cannot show create product page', function(){
    $user = User::factory()->create();
    
    $this->actingAs($user)
        ->get(ProductResource::getUrl('create'))
        ->assertStatus(403);
});

test('admin user can create product', function(){
    $user = User::find(1);

    $brands = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $name = fake()->unique()->name();
    
    $this->actingAs($user)->
    livewire(ProductResource\Pages\CreateProduct::class)
        ->fillForm([
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
            'categories' => $categories[0]->id,
            'brands' => $brands[0]->id,
        ])
        ->call('create')
        ->assertHasNoFormErrors();
 
    $this->assertDatabaseHas(Product::class, [
        'name' => $name,
        'slug' => Str::slug($name),
    ]);
});

test('admin user can edit product', function(){
    $brands = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $product = Product::factory()->count(1)->has(ProductImage::factory()->count(1), 'product_images')->create()
        ->each(function($products) use($brands, $categories){
            $products->brands()->attach($brands->random(2));
            $products->categories()->attach($categories->random(2));
        });
    
    livewire(ProductResource\Pages\EditProduct::class, [
            'record' => $product[0]->getKey(),
        ])->assertFormSet([
            'id' => $product[0]->getKey()
        ]);
});

test('admin user can delete product', function () {

    $brands = Brand::factory()->count(2)->create();
    $categories = Category::factory()->count(2)->create();

    $product = Product::factory()->count(1)->has(ProductImage::factory()->count(1), 'product_images')->create()
        ->each(function($products) use($brands, $categories){
            $products->brands()->attach($brands->random(2));
            $products->categories()->attach($categories->random(2));
        });
 
    livewire(ProductResource\Pages\EditProduct::class, [
        'record' => $product[0]->getKey(),
    ])
        ->callPageAction(DeleteAction::class);
 
    $this->assertModelMissing($product[0]);
});