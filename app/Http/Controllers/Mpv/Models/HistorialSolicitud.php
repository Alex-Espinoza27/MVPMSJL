<?php

namespace App\Http\Controllers\Mpv\Models;

 
use Illuminate\Database\Eloquent\Model;

class HistorialSolicitud extends Model
{
    protected $table = 'MDSJL.HISTORIAL_SOLICITUD';
    protected $primaryKey = 'HIS_ID';
    public $timestamps = false;
    public $incrementing = true;
}
