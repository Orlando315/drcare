<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
  protected $table = 'productos';
  protected $primaryKey = 'id';

  protected $fillable = [
    'productos_categorias_id',
    'nombre',
    'descripcion',
    'indicaciones',
    'cpe',
    'cpe_expiracion',
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

  public function carpetas(){
    return $this->hasMany('App\ProductoCarpeta', 'producto_id');
  }

  public function getFile( $file )
  {
    return Storage::get( $file );
  }

  public function setCpeExpiracionAttribute($date){
    $this->attributes['cpe_expiracion'] = $date ? date('Y-m-d', strtotime($date)) : null;
  }

  public function getCpeExpiracionAttribute($date){
    return $date ? date('d-m-Y', strtotime($date)) : null;
  }

  public function codigo_barra(){
    $download = route('get_file', ['producto' => $this->id, 'file' => 'codigo_barra_imagen']);

    if($this->codigo_barra_imagen){
      return "<a href='{$download}' title='Descargar imagen'>{$this->codigo_barra}</a>";
    }

    return $this->codigo_barra;
  }
}
