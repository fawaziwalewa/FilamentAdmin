<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Comment;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'email', 'phone', 'birthday', 'country', 'address_id', 'payment_id'];

    protected $dates = [ 'deleted_at' ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
