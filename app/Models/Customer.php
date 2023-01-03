<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'phone'];

    protected $dates = ['deleted_at', 'birthday'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_brand', 'brand_id', 'product_id');
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'customer_addresses');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'customer_payments');
    }
}
