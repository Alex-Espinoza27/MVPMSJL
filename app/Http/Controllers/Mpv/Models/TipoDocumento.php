<?php

namespace App\Http\Controllers\Mpv\Modals;
 
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'MDSJL.TIPO_DOCUMENTO';
    protected $primaryKey = 'TIPDOC_ID';
    public $timestamps = false;

}
