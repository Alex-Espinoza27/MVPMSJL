<?php

namespace App\Http\Controllers\Sgd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaJuridica extends Model
{
    protected $table = 'IDOSGD.LG_PRO_PROVEEDOR';

    protected $primaryKey = 'CPRO_RUC';
    public $incrementing = false;

    public $timestamps = false;
}
