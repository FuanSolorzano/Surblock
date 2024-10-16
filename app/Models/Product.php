<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = ['name', 'code', 'description', 'stock', 'price'];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
