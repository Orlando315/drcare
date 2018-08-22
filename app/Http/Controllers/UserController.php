<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Departamento;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$users = User::allIn();
      $notUsers = User::allOut();

    	return view('users.index', ['users' => $users, 'notUsersAll' => $notUsers ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $departamentos = Departamento::all();

      return view('users.create', [ 'departamentos' => $departamentos ]);
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
        'role' => 'required',
        'status' => 'required',
        'nombre' => 'required',
        'tipo_cedula' => 'required',
        'cedula' =>'required|min:6|max:10|unique:users',
        'departamento_id' => 'required',
        'cargo_id' => 'required',
        'password' => 'required',
        'password_confirmation' => 'same:password',
      ]);

      $user = new User;

      $user->fill($request->all());
      $user->password = bcrypt($request->input('password'));

      if($user->save()){
        return redirect('users')->with([
          'flash_message' => 'Usuario agregado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('users')->with([
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
      $user = user::findOrFail($id);

      return view('users.view', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $user = user::findOrFail($id);

      $departamentos = Departamento::all();

      return view('users.edit', ['user' => $user, 'departamentos' => $departamentos]);
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
      $user = User::findOrFail($id);

      $this->validate($request, [
        'role' => 'required',
        'status' => 'required',
        'nombre' => 'required',
        'tipo_cedula' => 'required',
        'cedula' =>'required|max:10|unique:users,cedula,'.$user->id.',id',
        'departamento_id' => 'required',
        'cargo_id' => 'required',
      ]);

      $user->fill($request->all());

      if($user->save()){
        return redirect('users')->with([
          'flash_message' => 'Usuario modificado correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('users')->with([
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
    	$user = User::findOrFail($id);

    	if($user->delete()){
    		return redirect('users')->with([
    			'flash_class'   => 'alert-success',
    			'flash_message' => 'Usuario eliminado con exito.'
    		]);
    	}else{
    		return redirect('users')->with([
    			'flash_class'     => 'alert-danger',
    			'flash_message'   => 'Ha ocurrido un error.',
    			'flash_important' => true
    		]);
    	}
    }

    public function perfil(){
    	$user = Auth::user();

    	return view('users.perfil',['user'=>$user]);
    }

    public function perfil_edit(){
      $user = Auth::user();

      return view('users.perfil_edit',['user'=>$user]);
    }

    public function update_perfil(Request $request)
    {
    	$user = User::find(Auth::user()->id);

      $this->validate($request, [
        'nombre' => 'required',
        'tipo_cedula' => 'required',
        'cedula' =>'required|max:10|unique:users,cedula,'.$user->id.',id',
      ]);

    	$user->fill($request->all());

      if($request->input('checkbox') === 'Yes'){
      	$this->validate($request,[
          'password' => 'required|min:6|confirmed',
    		]);
  			$user->password = bcrypt($request->input('password'));
      }

    	if($user->save()){
        return redirect('perfil')->with([
          'flash_message' => 'Cambios guardados correctamente.',
          'flash_class' => 'alert-success'
          ]);
    	}else{
        return redirect('perfil')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
        	]);
    	}
    }

    public function changePassword( $id, Request $request)
    {
      $user = User::findOrFail($id);

      $user->password = bcrypt($request->input('password'));

      if($user->save()){
        return redirect('users/' . $user->id )->with([
          'flash_message' => 'La contraseña ha sido cambiada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('users/' . $user->id )->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    public function changeStatus( $id, Request $request)
    {
      $user = User::findOrFail($id);

      $user->status = $request->input( 'status' );

      if($user->save()){
        return redirect('users/' . $user->id )->with([
          'flash_message' => 'El Status ha sido cambiada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('users/' . $user->id )->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger',
          'flash_important' => true
          ]);
      }
    }

    public function registroPublico()
    {
      $departamentos = Departamento::all();

      return view( 'users.public_create', ['departamentos' => $departamentos] );
    }

    public function storePublico(Request $request)
    {
      $this->validate($request, [
        'nombre' => 'required',
        'tipo_cedula' => 'required',
        'cedula' =>'required|min:6|max:10|unique:users',
        'departamento_id' => 'required',
        'cargo_id' => 'required',
        'password' => 'required|confirmed',
      ]);

      $user = new User;

      $user->fill($request->all());
      $user->password = bcrypt($request->input('password'));
      $user->status = 'Procesando';
      $user->role = 'Usuario';

      if($user->save()){
        return redirect('/')->with([
          'flash_message' => 'Solicitud de registro enviada correctamente.',
          'flash_class' => 'alert-success'
          ]);
      }else{
        return redirect('/registro')->with([
          'flash_message' => 'Ha ocurrido un error.',
          'flash_class' => 'alert-danger'
          ]);
      }
    }
}
