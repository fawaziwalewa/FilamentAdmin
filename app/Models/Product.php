<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    

    protected $fillable = ['images', 'name', 'slug', 'description', 'visibility', 'availability', 'brands', 'categories', 'price', 'compare_at_price', 'cost_per_item', 'sku', 'barcode', 'quantity', 'security_stock', 'returnable', 'shipped'];
    
    protected $casts = [
        'images' => 'array',
        'brands' => 'array',
        'categories' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function product_images()
    {
        return $this->hasMany(productImage::class);
    }
}
