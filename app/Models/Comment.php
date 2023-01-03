<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'customer_id', 'product_id', 'approved', 'content'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
