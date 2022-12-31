<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['number', 'status', 'currency', 'total_price', 'shipping_cost', 'method', 'notes'];
}
