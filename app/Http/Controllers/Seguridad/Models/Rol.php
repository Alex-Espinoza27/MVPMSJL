<?php

namespace App\Http\Controllers\Seguridad\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'MDSJL.ROL';
    protected $primaryKey = 'ROL_CODIGO';
    public $timestamps = false;
    public $incrementing = true;

}
