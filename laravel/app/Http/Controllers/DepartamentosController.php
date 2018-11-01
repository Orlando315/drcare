<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;

class DepartamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $departamentos = Departamento::all();

      return view( 'departamentos.index', [ 'departamentos' => $departamentos ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view( 'departamentos.create' );
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
        'departamento' => 'required',
      ] );

      $departamento = new Departamento;

      $departamento->fill( $request->all() );

      if( $departamento->save() ){
        return redirect('departamentos')->with([
          'flash_message' => 'Departamento agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('departamentos')->with([
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
      $departamento = Departamento::findOrFail( $id );

      return view( 'departamentos.view', ['departamento' => $departamento ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $departamento = Departamento::findOrFail( $id );

      return view( 'departamentos.edit', [ 'departamento' => $departamento ] );
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
      $departamento = Departamento::findOrFail( $id );

      $this->validate( $request, [
        'departamento' => 'required',
      ] );

      $departamento->fill( $request->all() );

      if( $departamento->save() ){
        return redirect('departamentos')->with([
          'flash_message' => 'Departamento modificado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('departamentos')->with([
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
      $departamento = Departamento::findOrFail( $id );

      if( $departamento->cargos()->count() > 0 ){
        
        return redirect('departamentos')->with([
          'flash_message' => '¡Error - este Departamento tiene Cargos agregados.',
          'flash_class' => 'alert-danger',
          'flash_important' => true,
          ]);

      }else{

        if( $departamento->delete() ){

          return redirect('departamentos')->with([
            'flash_message' => 'Departamento eliminado correctamente.',
            'flash_class' => 'alert-success',
            ]);

        }else{

          return redirect('departamentos')->with([
            'flash_message' => 'Ha ocurrido un error.',
            'flash_class' => 'alert-danger',
            'flash_important' => true,
            ]);

        }
      }
    }

    public function getCargos(Request $request)
    {
      $departamento = Departamento::find( $request->input( 'id' ) );

      $cargos = $departamento->cargos()->get();

      return response()->json($cargos);
    }
}
