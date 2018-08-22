<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth as Auth;
use App\ProductoArte as Arte;
use App\Producto;

class ProductosArtesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
      $producto =  Producto::findOrFail( $id );

      $this->validate($request, [
        'file' => 'required|file|mimetypes:image/jpeg,image/png,application/postscript,application/pdf',
      ]);

      $arte = new Arte;

      if( $request->file->getClientMimeType() === 'application/postscript' ){
        $arte->mime = 'application/postscript';
        $ext = '.ai';
      }else{
        $arte->mime = $request->file->getMimeType();
        $ext = '.' . $request->file->guessExtension();
      }

      $arte->user_id = Auth::user()->id;

      if( $producto->artes()->save($arte) ){

        $directory = 'producto' . $producto->id;
        $arte->nombre = $this->cleanOriginalName( $request->file->getClientOriginalName() );

        $name = $this->createName($request->file->getClientOriginalName(), $ext);
        $arte->path =  $request->file('file')->storeAs( $directory, $name );

        $producto->artes()->save($arte);

        $response = ['response' => true, 'file' => $arte, 'download' => $arte->getDownloadLink()];
      }else{
        $response = ['response' => false];
      }

      return $response;
    }

    protected function cleanOriginalName( $originalName )
    {
      $search = [' ', '_'];

      return str_replace( $search, ' ', current( explode('.', $originalName) ));
    }

    protected function createName($originalName, $ext)
    {
      return str_replace(' ', '_', current( explode('.', $originalName) ) . '_' . substr( md5( microtime() ), 0, 10) . $ext );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $file = Arte::findOrFail($id);

      if( $test = $file->delete() ){
        Storage::delete( $file->path );

        $response = ['response' => true, 'id' => $file->id];
      }else{
        $response = ['response' => false];
      }

      return $response;
    }

    public function getFile($id)
    {
      $file = Arte::findOrFail( $id );

      return Storage::download( $file->path );
    }
}
