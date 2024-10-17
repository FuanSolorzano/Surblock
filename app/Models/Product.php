<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
   protected $fillable = ['name', 'code', 'description', 'stock', 'price'];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
