<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargos';
    protected $fillable = ['departamento_id', 'cargo'];

    public function departamento()
    {
      return $this->belongsTo( 'App\Departamento', 'departamento_id' );
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
