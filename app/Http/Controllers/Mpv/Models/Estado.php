<?php
namespace App\Http\Controllers\Mpv\Modals; 
use Illuminate\Database\Eloquent\Model;


class Estado extends Model
{
    protected $table = 'MDSJL.ESTADO';
    protected $primaryKey = 'ESTA_ID';
    public $timestamps = false;
    public $incrementing = true;
}
