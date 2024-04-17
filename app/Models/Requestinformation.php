<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requestinformation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requestinformations';

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
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'how_can_we_help_you', 'questions'];

    
}
