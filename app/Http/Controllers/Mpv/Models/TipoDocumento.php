<?php

namespace App\Http\Controllers\Mpv\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'MDSJL.TIPO_DOCUMENTO';
    protected $primaryKey = 'TIPDOC_ID';
    public $timestamps = false;
    // public $incrementing = true;
}
