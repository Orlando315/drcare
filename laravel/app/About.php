<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
  protected $table = 'about';
  
  public $timestamps = false;

  public $fillable = [
    'email',
    'rif',
    'rif_expiracion',
    'registro_mercantil',
    'registro_mercantil_expiracion',
    'patente_industria',
    'patente_industria_expiracion',
    'racda',
    'racda_expiracion',
    'solvencia_ss',
    'solvencia_ss_expiracion',
    'solvencia_ince',
    'solvencia_ince_expiracion',
  ];

  public function setRifExpiracionAttribute($date){
    $this->attributes['rif_expiracion'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getRifExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function setRegistroMercantilExpiracionAttribute($date){
    $this->attributes['registro_mercantil_expiracion'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getRegistroMercantilExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function setPatenteIndustriaExpiracionAttribute($date){
    $this->attributes['patente_industria_expiracion'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getPatenteIndustriaExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function setRacdaExpiracionAttribute($date){
    $this->attributes['racda_expiracion'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getRacdaExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function setSolvenciaSsExpiracionAttribute($date){
    $this->attributes['solvencia_ss_expiracion'] = date('Y-m-d', strtotime($date));
  }

  public function getSolvenciaSsExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function setSolvenciaInceExpiracionAttribute($date){
    $this->attributes['solvencia_ince_expiracion'] = date('Y-m-d', strtotime($date));
  }

  public function getSolvenciaInceExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }
}
