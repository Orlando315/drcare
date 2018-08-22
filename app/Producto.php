<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
  protected $table = 'productos';
  protected $primaryKety = 'id';

  protected $fillable = [
    'productos_categorias_id',
    'nombre',
    'descripcion',
    'indicaciones',
    'cpe',
    'codigo_producto',
    'codigo_barra',
    'codigo_arancelario',
    'peso',
    'volumen',
    'subempaque',
    'empaque_master',
    'cantidad_paleta',
  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function artes()
  {
    return $this->hasMany('App\ProductoArte', 'producto_id');
  }

  public function categoria()
  {
    return $this->belongsTo('App\ProductoCategoria', 'productos_categorias_id');
  }

  public function getFile( $file )
  {
    return Storage::get( $file );
  }
}
