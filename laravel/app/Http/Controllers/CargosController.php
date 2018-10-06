<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Cargo;

class CargosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $cargos = Cargo::all();

      return view( 'cargos.index', ['cargos' => $cargos] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $departamentos = Departamento::all();

      return view( 'cargos.create', ['departamentos' => $departamentos] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate( $request, [
        'departamento_id' => 'required',
        'cargo' => 'required',
      ] );

      $cargo = new Cargo;

      $cargo->fill( $request->all() );

      if( $cargo->save() ){
        return redirect('cargos')->with([
          'flash_message' => 'Cargo agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('cargos')->with([
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
      $cargo = Cargo::findOrFail( $id );

      return view( 'cargos.view', ['cargo' => $cargo] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $cargo = Cargo::findOrFail( $id );
      $departamentos = Departamento::all();

      return view( 'cargos.edit', ['cargo' => $cargo, 'departamentos' => $departamentos] );
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
      $cargo = Cargo::findOrFail( $id );

      $this->validate( $request, [
        'departamento_id' => 'required',
        'cargo' => 'required',
      ] );

      $cargo->fill( $request->all() );

      if( $cargo->save() ){
        return redirect('cargos')->with([
          'flash_message' => 'Cargo modificado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('cargos')->with([
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
      $cargo = Cargo::findOrFail( $id );

      if( $cargo->usuarios()->count() > 0 ){
        
        return redirect('cargos')->with([
          'flash_message' => '¡Error - Este Cargo tiene Usuarios agregados!',
          'flash_class' => 'alert-danger',
          'flash_important' => true,
          ]);

      }else{

        if( $cargo->delete() ){

          return redirect('cargos')->with([
            'flash_message' => 'Cargo eliminado correctamente.',
            'flash_class' => 'alert-success',
            ]);

        }else{

          return redirect('cargos')->with([
            'flash_message' => 'Ha ocurrido un error.',
            'flash_class' => 'alert-danger',
            'flash_important' => true,
            ]);

        }
      }
    }
}
