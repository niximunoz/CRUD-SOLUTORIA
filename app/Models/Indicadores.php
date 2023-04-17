<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\database\Eloquent\Model;

class Indicadores extends Model
{
   protected $table = "indicadores";
   protected $fillable = [
        'id','nombreIndicador','codigoIndicador',
        'unidadMedidaIndicador','valorIndicdor',
        'fechaIndicador','tiempoIndicador',
        'origenIndicador'
   ];
   public $timestamps = false;
}
