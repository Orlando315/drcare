<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth as Auth;
use App\Producto;
use App\ProductoCategoria as Categoria;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $productos  = Producto::all();
      $categorias = Categoria::all();

      return view('productos.index', ['productos' => $productos, 'categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $categorias = Categoria::all();

      return view('productos.create', ['categorias' => $categorias]);
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
        'productos_categorias_id' => 'required',
        'nombre' => 'required',
        'imagen' => 'required|image',
        'etiqueta' => 'required|image',
        'descripcion' => 'required',
        'indicaciones' => 'required',
        'cpe' => 'required|alpha_num',
        'codigo_producto' => 'required|alpha_num',
        'codigo_barra' => 'required|alpha_num',
        'codigo_arancelario' => 'required|alpha_num',
        'hoja_tecnica_seguridad' => 'required|file|mimes:pdf',
        'permiso_sanitario' => 'required|file|mimes:pdf',
        'peso' => 'required|numeric',
        'volumen' => 'required|numeric',
        'subempaque' => 'required',
        'empaque_master' => 'required',
        'declaracion_jurada'=> 'required|file|mimes:pdf',
      ]);

      $producto = new Producto;
      $producto->fill( $request->all() );
      $producto->user_id = Auth::user()->id;

      if( $producto->save() ){

        $directory = 'producto' . $producto->id;

        Storage::makeDirectory( $directory );

        $producto->imagen = $request->file('imagen')->store($directory);
        $producto->etiqueta = $request->file('etiqueta')->store($directory);
        $producto->hoja_tecnica_seguridad = $request->file('hoja_tecnica_seguridad')->store($directory);
        $producto->permiso_sanitario = $request->file('permiso_sanitario')->store($directory);
        $producto->declaracion_jurada = $request->file('declaracion_jurada')->store($directory);

        $producto->save();

        return redirect('productos/' . $producto->id )->with([
          'flash_message' => 'Producto agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);

      }else{
        return redirect('productos')->with([
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
      $producto = Producto::findOrFail( $id );

      return view('productos.view', ['producto' => $producto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $producto = Producto::findOrFail( $id );
      $categorias = Categoria::all();

      return view('productos.edit', ['producto' => $producto, 'categorias' => $categorias]);
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
      $producto = Producto::findOrFail( $id );

      $this->validate($request, [
        'productos_categorias_id' => 'required',
        'nombre' => 'required',
        'imagen' => 'nullable|image',
        'etiqueta' => 'nullable|image',
        'descripcion' => 'required',
        'indicaciones' => 'required',
        'cpe' => 'required|alpha_num',
        'codigo_producto' => 'required|alpha_num',
        'codigo_barra' => 'required|alpha_num',
        'codigo_arancelario' => 'required|alpha_num',
        'hoja_tecnica_seguridad' => 'nullable|file|mimes:pdf',
        'permiso_sanitario' => 'nullable|file|mimes:pdf',
        'peso' => 'required|numeric',
        'volumen' => 'required|numeric',
        'subempaque' => 'required',
        'empaque_master' => 'required',
        'declaracion_jurada'=> 'nullable|file|mimes:pdf',
      ]);

      $producto->fill( $request->all() );

      if( $producto->save() ){

        $directory = 'producto' . $producto->id;

        if( $request->hasFile( 'imagen' ) ){
          Storage::delete( $producto->imagen );
          $producto->imagen = $request->file('imagen')->store($directory);
        }

        if( $request->hasFile( 'etiqueta' ) ){
          Storage::delete( $producto->etiqueta );
          $producto->etiqueta = $request->file('etiqueta')->store($directory);
        }

        if( $request->hasFile( 'hoja_tecnica_seguridad' ) ){
          Storage::delete( $producto->hoja_tecnica_seguridad );
          $producto->hoja_tecnica_seguridad = $request->file('hoja_tecnica_seguridad')->store($directory);
        }

        if( $request->hasFile( 'permiso_sanitario' ) ){
          Storage::delete( $producto->permiso_sanitario );
          $producto->permiso_sanitario = $request->file('permiso_sanitario')->store($directory);
        }

        if( $request->hasFile( 'declaracion_jurada' ) ){
          Storage::delete( $producto->declaracion_jurada );
          $producto->declaracion_jurada = $request->file('declaracion_jurada')->store($directory);
        }

        $producto->save();

        return redirect('productos/' . $producto->id )->with([
          'flash_message' => 'Producto agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('productos')->with([
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
      $producto = Producto::findOrFail( $id );

      if( $producto->delete() ){

        Storage::deleteDirectory('producto' . $id );

        return redirect('productos')->with([
          'flash_class'   => 'alert-success',
          'flash_message' => 'Producto eliminado con exito.'
        ]);
      }else{
        return redirect('productos')->with([
          'flash_class'     => 'alert-danger',
          'flash_message'   => 'Ha ocurrido un error.',
          'flash_important' => true
        ]);
      }
    }

    public function getFile($producto, $file)
    {
      $producto = Producto::findOrFail( $producto );

      return Storage::download( $producto->{$file} );
    }
}
