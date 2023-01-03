<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'visibility'   => 'boolean',
        'availability' => 'date',
        'returnable'   => 'boolean',
        'shipped'      => 'boolean',
    ];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'cost_per_item',
        'sku',
        'barcode',
        'quantity',
        'security_stock',
        'visibility',
        'availability',
        'returnable',
        'shipped',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class,
            'product_brand');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,
            'product_category');
    }
}
