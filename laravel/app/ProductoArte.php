<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductoArte extends Model
{
  protected $table = 'productos_artes';

  protected $fillable  = ['producto_id', 'user_id', 'nombre', 'path', 'mime'];

  public function producto()
  {
    return $this->belongsTo('App\Producto', 'producto_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function generateThumb()
  {
    $image = $this->getImageByMime();
    $url = asset( $image );
    $download = $this->getDownloadLink();

    if(Auth::user()->role === 'Admin' || Auth::user()->role === 'Operativo'){
      $button = "<button type='button' title='Borrar archivo' data-file='{$this->id}' class='btn btn-flat btn-danger btn-remove-gallery' data-toggle='modal' data-target='#delFileModal'>
                  <i class='fa fa-times'></i>
                </button>";
    }else{
      $button = "";
    }

    return "<div id='file-{$this->id}' class='col-md-3 col-xs-12' style='margin-bottom: 5px'>
              <div class='gallery-item'>
                {$button}
                <a href='{$download}' title='Descargar documento'>
                  <img class='img-responsive' src='{$url}' alt='{$this->nombre}'>
                </a>
              </div>
              <p class='text-center'><small>{$this->nombre}</small></p>
            </div>";
  }

  public function getDownloadLink()
  {
    return route( 'get_arte_file', ['id' => $this->id] );
  }

  protected function getImageByMime()
  {
    switch ($this->mime) {
      case 'application/postscript':
        $url = 'images/illustrator_icon.png';
        break;

      case 'application/pdf':
        $url = 'images/pdf_icon.png';
        break;
      
      default:
        $url = 'storage/' . $this->path;
        break;
    }

    return asset( $url );
  }
}
