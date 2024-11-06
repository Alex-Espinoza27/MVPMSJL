<?php

namespace App\Http\Controllers\Mpv\Models;
 
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    protected $table = 'MDSJL.ANEXO';
    protected $primaryKey = 'ANEX_ID';
    public $timestamps = false;
    public $incrementing = true;
}
