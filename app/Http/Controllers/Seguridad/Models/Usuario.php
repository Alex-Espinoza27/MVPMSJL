<?php

namespace App\Http\Controllers\Seguridad\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    protected $table = 'MDSJL.USUARIO';
    protected $primaryKey = 'USU_ID';
    public $timestamps = false;
    public $incrementing = true;

    public function getPermisos()
    {
        return DB::select('EXEC MDSJL.SP_OPCIONES ?, ?', [1, $this->ID_ROLES]);
    }
}
