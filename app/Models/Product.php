<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
   protected $fillable = ['name', 'code', 'description', 'stock', 'price', 'image'];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
