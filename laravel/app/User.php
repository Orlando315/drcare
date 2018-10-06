<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'role', 'nombre', 'tipo_cedula', 'cedula', 'departamento_id', 'cargo_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /* -- Todos los usuaios en el sistema: Activo o Inactivo --*/
    public static function allIn()
    {
      $users = User::where( 'status', 'Activo' )
                      ->orWhere( 'status', 'Inactivo' )
                      ->get();

      return $users;
    }

    /* -- Todos los usuaios fuera del sistema: Procesando o Rechazado --*/
    public static function allOut()
    {
      $users = User::where( 'status', 'Procesando' )
                      ->orWhere( 'status', 'Rechazado' )
                      ->get();

      return $users;
    }

    public static function usersSolicitudes()
    {
      $users = User::where( 'status', 'Procesando' )
                      ->get();

      return $users;
    }

    public function hasRole( $role ){
      if( $this->role == 'Admin' ){
        return true;
      }

      return $this->role == $role;
    }

    public function productos()
    {
      return $this->hasMany('App\Producto', 'user_id');
    }

    public function departamento()
    {
      return $this->belongsTo( 'App\Departamento', 'departamento_id' );
    }

    public function cargo()
    {
      return $this->belongsTo( 'App\Cargo', 'cargo_id' );
    }

    public function status()
    {
      switch ($this->status) {
        case 'Activo':
          $status = '<span class="label label-success">Activo</span>';
          break;
        case 'Inactivo':
          $status = '<span class="label label-default">Inactivo</span>';
          break;
        case 'Procesando':
          $status = '<span class="label label-warning">Procesando</span>';
          break;
        case 'Rechazado':
          $status = '<span class="label label-danger">Rechazado</span>';
          break;
        
        default:
          $status = '<span class="label label-danger">Error</span>';
          break;
      }

      return $status;
    }

    public function cedula()
    {
      return $this->tipo_cedula.' '.$this->cedula;
    }
}
