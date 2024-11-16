<?php

namespace App\Http\Controllers\Mpv\Models;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'MDSJL.SOLICITUD';
    protected $primaryKey = 'SOLI_ID';
    public $timestamps = false;
    public $incrementing = true;
}
