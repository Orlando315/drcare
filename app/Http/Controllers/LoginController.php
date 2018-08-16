<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
 			return view( 'dashboard' );
	 	}

	 public function login(Request $request)
	 {
	 		/*----------- LOGIN MANUAL , MODIFICABLE ----------*/
    	$this->validate( $request, [
    		'cedula' =>'required',
    		'password' => 'required',
    	]);

      if ( Auth::attempt( $request->only( [ 'cedula', 'password' ] ) ) ){
      	return redirect()->intended( 'dashboard' );
      }else{
      	return redirect()->route( 'login' )->withErrors( '¡Error, Revise sus credenciales!' );
      }
	 }

	 public function logout()
	 {
	 		/*---- funcion de salir/logout/cerrar sesion --*/
	 		Auth::logout();

	 		return redirect()->route( 'login' );
	 }
    
}
