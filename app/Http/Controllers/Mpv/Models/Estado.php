<?php

namespace App\Http\Controllers\Mpv\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'MDSJL.ESTADO';
    protected $primaryKey = 'ESTA_ID';
    public $timestamps = false;
    public $incrementing = true;
}
