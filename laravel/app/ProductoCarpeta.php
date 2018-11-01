<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoCarpeta extends Model
{
  protected $table = 'productos_carpetas';

  protected $primaryKey = 'id';

  protected $fillable = ['producto_id', 'user_id', 'carpeta'];

  public function producto()
  {
    return $this->belongsTo('App\Producto','id');
  }

  public function artes()
  {
    return $this->hasMany('App\ProductoArte', 'productos_carpetas_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User','id');
  }
}
