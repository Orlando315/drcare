<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth as Auth;
use App\About;
use App\Representante;

class RepresentantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,
      [
        'cedula' => 'required|image',
      ]);

      $representante = new Representante;

      $directory = 'about';

      $representante->cedula = $request->file('cedula')->store($directory);
      $representante->user_id = Auth::user()->id;
      
      if( $representante->save() ){
        return redirect('about')->with([
          'flash_message' => 'Representante agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('about')->with([
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $about = About::findOrFail(1);

      return view('about.edit', ['about' => $about]);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $representante = Representante::findOrFail($id);

      if( $representante->delete() ){
        if(Storage::exists($representante->cedula)){
          Storage::delete($representante->cedula);
        }

        return redirect('about')->with([
          'flash_class'   => 'alert-success',
          'flash_message' => 'Representante eliminado con exito.'
        ]);
      }else{
        return redirect('about')->with([
          'flash_class'     => 'alert-danger',
          'flash_message'   => 'Ha ocurrido un error.',
          'flash_important' => true
        ]);
      }
    }

    public function getFile($representante)
    {
      $representante = Representante::findOrFail($representante);

      return Storage::download( $representante->cedula );
    }}
