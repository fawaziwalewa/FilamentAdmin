<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'website', 'visibility', 'description'];

    public function products(){
        return $this->belongsToMany(Product::class, 'product_brand', 'brand_id', 'product_id');
    }
    public function addresses(){
        return $this->belongsToMany(Address::class, 'brand_addresses');
    }
}
