<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\About;
use App\Representante;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $about = About::findOrFail(1);
      $representantes = Representante::all();

      return view('about.index', ['about' => $about, 'representantes' => $representantes]);
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
    public function store(Request $request)
    {
        //
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
      $about = About::findOrFail(1);

      $this->validate($request, [
        'email' => 'required|email',
        'rif' => 'nullable|file|mimes:pdf',
        'rif_expiracion' => 'nullable|required_with:rif|date_format:d-m-Y',
        'registro_mercantil' => 'nullable|file|mimes:pdf',
        'registro_mercantil_expiracion' => 'nullable|required_with:registro_mercantil|date_format:d-m-Y',
        'patente_industria' => 'nullable|file|mimes:pdf',
        'patente_industria_expiracion' => 'nullable|required_with:patente_industria|date_format:d-m-Y',
        'racda' => 'nullable|file|mimes:pdf',
        'racda_expiracion' => 'nullable|required_with:racda|date_format:d-m-Y',
        'solvencia_ss' => 'nullable|file|mimes:pdf',
        'solvencia_ss_expiracion' => 'nullable|required_with:solvencia_ss|date_format:d-m-Y',
        'solvencia_ince' => 'nullable|file|mimes:pdf',
        'solvencia_ince_expiracion' => 'nullable|required_with:solvencia_ince|date_format:d-m-Y',
      ]);

      $about->fill($request->all());

      $directory = 'about';

      if(!Storage::exists($directory)){
        Storage::makeDirectory($directory);
      }

      if($request->hasFile('rif')){
        if(Storage::exists($about->rif)){
          Storage::delete($about->rif);
        }
        $about->rif = $request->file('rif')->store($directory);
      }

      if($request->hasFile('registro_mercantil')){
        if(Storage::exists($about->registro_mercantil)){
          Storage::delete($about->registro_mercantil);
        }
        $about->registro_mercantil = $request->file('registro_mercantil')->store($directory);
      }

      if($request->hasFile('patente_industria')){
        if(Storage::exists($about->patente_industria)){
          Storage::delete($about->patente_industria);
        }
        $about->patente_industria = $request->file('patente_industria')->store($directory);
      }

      if($request->hasFile('racda')){
        if(Storage::exists($about->racda)){
          Storage::delete($about->racda);
        }
        $about->racda = $request->file('racda')->store($directory);
      }
      
      if($request->hasFile('solvencia_ss')){
        if(Storage::exists($about->solvencia_ss)){
          Storage::delete($about->solvencia_ss);
        }
        $about->solvencia_ss = $request->file('solvencia_ss')->store($directory);
      }
      
      if($request->hasFile('solvencia_ince')){
        if(Storage::exists($about->solvencia_ince)){
          Storage::delete($about->solvencia_ince);
        }
        $about->solvencia_ince = $request->file('solvencia_ince')->store($directory);
      }
      
      if( $about->save() ){
        return redirect('about')->with([
          'flash_message' => 'Información actualizada correctamente.',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getFile($file)
    {
      $about = About::findOrFail(1);

      return Storage::download( $about->{$file} );
    }}
