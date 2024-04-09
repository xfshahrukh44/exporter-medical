<?php

namespace App;

use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */


    protected $table = 'products';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_title', 'description','price','subcategory', 'is_featured','item_number','category','list_price','weight','stock','vendor','length','width','height','stand_price', 'sku'];

    public function categorys()
    {
        return $this->belongsTo('App\Category', 'category', 'id');
    }

    public function attributes()
    {
        return $this->hasMany('App\ProductAttribute', 'product_id', 'id');
    }
    
    public function subcategorys()
    {
        return $this->belongsTo('App\Models\SubCategory', 'subcategory', 'id');
    }

    public function product_images ()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

}
