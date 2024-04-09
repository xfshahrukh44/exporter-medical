<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

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
    protected $fillable = ['name', 'heading', 'detail', 'icon', 'image','tagline', 'is_featured'];
    
    public function subcategory()
    {
        return $this->hasMany('App\Models\SubCategory', 'category', 'id');
    }
    
    public function products()
    {
        return $this->hasMany('App\Product', 'category', 'id')->orderByRaw('RAND()')->take(8);
    }
    
    


}
