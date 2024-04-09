<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatesTax extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states_taxes';

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
protected $fillable = ['name', 'code', 'tax'];


}
