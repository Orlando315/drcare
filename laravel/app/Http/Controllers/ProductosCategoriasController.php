<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductoCategoria as Categoria;
use Illuminate\Support\Facades\Auth as Auth;

class ProductosCategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return redirect('productos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('categorias.create');
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
        'categoria' => 'required'
      ]);

      $categoria = new Categoria;

      $categoria->fill($request->all());
      $categoria->user_id = Auth::user()->id;

      if($categoria->save()){
        return redirect('productos')->with([
          'flash_message' => 'Categoria agregado correctamente.',
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
      $categoria = Categoria::findOrFail( $id );

      return view('categorias.view', ['categoria' => $categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $categoria = Categoria::findOrFail( $id );

      return view('categorias.edit', ['categoria' => $categoria]);
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

      $categoria = Categoria::findOrFail( $id );

      $this->validate($request, [
        'categoria' => 'required'
      ]);

      $categoria->fill($request->all());

      if($categoria->save()){
        return redirect('productos')->with([
          'flash_message' => 'Categoria modificada correctamente.',
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
      $categoria = Categoria::findOrFail( $id );

      if( $categoria->productos()->count() > 0 ){
        
        return redirect('productos')->with([
          'flash_message' => '¡Error - Esta Categoria tiene Productos agregados!',
          'flash_class' => 'alert-danger',
          'flash_important' => true,
          ]);

      }else{

        if( $categoria->delete() ){
          return redirect('productos')->with([
            'flash_message' => 'Categoria eliminada correctamente.',
            'flash_class' => 'alert-success',
            ]);

        }else{
          return redirect('productos')->with([
            'flash_message' => 'Ha ocurrido un error.',
            'flash_class' => 'alert-danger',
            'flash_important' => true,
            ]);

        }
      }
    }
}
