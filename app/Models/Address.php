<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['street', 'zip', 'city', 'state', 'country'];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_addresses');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_addresses');
    }
}
