<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    public function product ()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
