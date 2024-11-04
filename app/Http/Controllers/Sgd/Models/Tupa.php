<?php

namespace App\Http\Controllers\Sgd\Models;
use Illuminate\Database\Eloquent\Model;

class Tupa extends Model
{   
    #protected $connection = 'sql_sgd'; 
    protected $table = 'IDOSGD.TDTR_PROCESOS_EXP';

    // protected $primaryKey = 'UBDEP'; 
    public $incrementing = false;       
    public $timestamps = false;         

}
