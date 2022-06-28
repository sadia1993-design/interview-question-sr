<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function variant(){
        return $this->hasMany(Variant::class);
    }
}
