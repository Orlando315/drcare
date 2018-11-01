<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Producto;
use App\ProductoCarpeta as Carpeta;
use Illuminate\Support\Facades\Auth;

class ProductosCarpetasController extends Controller
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
    public function create($id)
    {
      $producto = Producto::findOrFail($id);

      return view('carpetas.create', ['producto' => $producto->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'carpeta' => 'required|alpha_num',
        'producto_id' => 'required'
      ]);

      $carpeta = new Carpeta;

      $carpeta->fill($request->all());
      $carpeta->user_id = Auth::user()->id;

      if($carpeta->save()){

        $directory = 'producto' . $carpeta->producto_id .'/'. $carpeta->carpeta;

        if(!Storage::exists($directory)){
          Storage::makeDirectory($directory);
        }

        return redirect('productos/'.$request->producto_id)->with([
          'flash_message' => 'Carpeta agregada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('productos/'.$request->producto_id)->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $carpeta = Carpeta::findOrFail($id);
      $producto = Producto::findOrFail($carpeta->producto_id);

      return view('carpetas.view', ['carpeta' => $carpeta, 'producto' => $producto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $carpeta = Carpeta::findOrFail($id);

      return view('carpetas.edit', ['carpeta' => $carpeta]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $carpeta = Carpeta::findOrFail($id);

      $this->validate($request, [
        'carpeta' => 'required|alpha_num',
      ]);

      $old = $carpeta->carpeta;

      $carpeta->carpeta = $request->carpeta;

      if($carpeta->save()){

        $oldDirectory = 'producto' . $carpeta->producto_id .'/'. $old;
        $newDirectory = 'producto' . $carpeta->producto_id .'/'.$request->carpeta;

        if(Storage::exists($oldDirectory)){
          Storage::move($oldDirectory, $newDirectory);
        }else{
          Storage::makeDirectory($newDirectory);
        }

        return redirect('productos/carpeta/'.$carpeta->id)->with([
          'flash_message' => 'Carpeta modificada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('productos/carpeta/'.$carpeta->id)->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $carpeta = Carpeta::findOrFail($id);

      if($carpeta->delete()){
        $directory = 'producto' . $carpeta->producto_id .'/'.$carpeta->carpeta;

        if(Storage::exists($directory)){
          Storage::deleteDirectory($directory);
        }

        return redirect('productos/'.$carpeta->producto_id)->with([
          'flash_message' => 'Carpeta eliminada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('productos/'.$carpeta->producto_id)->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }
}
