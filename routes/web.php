<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*---------- RUTAS DE LOGIN ----------------*/
Route::get( '/' , function () {
  return view( 'login' );
})->name( 'login' );

Route::post( 'auth', 'LoginController@login' )->name( 'auth' );
Route::match( ['get', 'post'], '/logout', 'LoginController@logout' )->name( 'logout' );

Route::post( '/departamentos/get', 'DepartamentosController@getCargos' )->name( 'get_departamento' );

Route::get('/registro', 'UserController@registroPublico')->name( 'registro_publico' );
Route::post('/registro', 'UserController@StorePublico')->name( 'store_publico' );

Route::group( [ 'middleware' => ['auth', 'access.status'] ], function () {

  /* --- Dashboard --- */
  Route::get( 'dashboard', 'LoginController@index' )->name( 'dashboard' );

  /* --- Solo usuarios Admin u Opertivo --- */
  Route::group( ['middleware' => 'access.role:Admin'], function (){

    /* --- Departamentos --- */
    Route::resource( '/departamentos', 'DepartamentosController' );

    /* --- Cargos --- */
    Route::resource( '/cargos', 'CargosController' );

    /* --- Usuarios ---*/
    Route::patch( '/users/password/{id}', 'UserController@changePassword' )->name( 'users.change_password' );
    Route::patch( '/users/status/{id}', 'UserController@changeStatus' )->name( 'users.change_status' );
    Route::resource( '/users','UserController' );
  });

  /* --- Perfil --- */
  Route::get( '/perfil', 'UserController@perfil' )->name( 'perfil' );
  Route::get( '/perfil/edit', 'UserController@perfil_edit' )->name( 'perfil_edit' );
  Route::patch( '/perfil', 'UserController@update_perfil' )->name( 'update_perfil' );
});
