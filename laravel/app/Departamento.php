<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $fillable = [ 'departamento' ];

    public function cargos()
    {
      return $this->hasMany( 'App\Cargo' );
    }

    public function usuarios()
    {
      return $this->hasMany( 'App\User')
                  ->where(function ($query) {
                      $query->where('status', 'Activo')
                            ->orWhere('status', 'Inactivo');
                  });
    }
}
