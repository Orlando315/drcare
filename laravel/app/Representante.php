<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Representante extends Model
{
  protected $fillable = ['user_id', 'cedula'];

  public function generateThumb()
  {
    $url = asset( '/laravel/public/uploads/'.$this->cedula );
    $download = $this->getDownloadLink();

    if(Auth::user()->role === 'Admin'){
      $button = "<button type='button' title='Borrar archivo' data-file='{$this->id}' class='btn btn-flat btn-danger btn-remove-gallery' data-toggle='modal' data-target='#delFileModal' style='display:block;top:0;right:15px'>
                  <i class='fa fa-times'></i>
                </button>";
    }else{
      $button = "";
    }

    return "<div id='file-{$this->id}' class='col-md-6 col-xs-12'>
              {$button}
              <a href='{$download}' title='Descargar documento'>
                <img class='img-responsive' src='{$url}' alt='{$url}'>
              </a>
            </div>";
  }

  public function getDownloadLink()
  {
    return route( 'representantes.getFile', ['id' => $this->id] );
  }
}
