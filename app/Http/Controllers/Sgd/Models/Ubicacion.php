<?php

namespace App\Http\Controllers\Sgd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    #protected $connection = 'sql_sgd';
    protected $table = 'IDOSGD.IDTUBIAS';

    protected $primaryKey = 'UBDEP';
    public $incrementing = false;

    public $timestamps = false;
}
