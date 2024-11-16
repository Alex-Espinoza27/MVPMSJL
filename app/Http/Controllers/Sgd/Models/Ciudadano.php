<?php

namespace App\Http\Controllers\Sgd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    protected $table = 'IDOSGD.TDTX_ANI_SIMIL';

    protected $primaryKey = 'NULEM';
    public $incrementing = false;
    public $timestamps = false;
}
