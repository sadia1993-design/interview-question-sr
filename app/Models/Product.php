<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function productVariants(){
        return $this->hasMany(ProductVariant::class);
    }

    public function ProductVariantPrices(){
        return $this->hasMany(ProductVariantPrice::class);
    }

    public function ProductImages(){
        return $this->hasMany(ProductImage::class);
    }

}
