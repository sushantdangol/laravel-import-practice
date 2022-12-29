<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function unit() {
        return $this->belongsTo(Unit::class);
    }

    public function productType() {
        return $this->belongsTo(ProductType::class);
    }

    public function productPrices() {
    	return $this->hasMany(ProductPrice::class);
    }
}
