<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoCategoria extends Model
{
  protected $table = 'productos_categorias';

  protected $fillable = ['user_id', 'categoria'];

  public function productos()
  {
    return $this->hasMany('App\Producto', 'productos_categorias_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User','id');
  }
}
