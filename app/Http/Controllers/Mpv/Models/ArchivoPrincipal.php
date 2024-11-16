<?php

namespace App\Http\Controllers\Mpv\Models;
 
use Illuminate\Database\Eloquent\Model;

class ArchivoPrincipal extends Model
{
    protected $table = 'MDSJL.ARCHIVO_PRINCIPAL';
    protected $primaryKey = 'ARCHIPRIN_ID';
    public $timestamps = false;
    public $incrementing = true;
}
