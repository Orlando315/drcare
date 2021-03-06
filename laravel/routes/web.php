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

/* --- Solo usuarios autenticados --- */
Route::group( [ 'middleware' => ['auth', 'access.status'] ], function () {

  /* --- Dashboard --- */
  Route::get( 'dashboard', 'LoginController@index' )->name( 'dashboard' );

  /* --- Representantes --- */
  Route::get( 'representantes/download/{id}', 'RepresentantesController@getFile' )->name('representantes.getFile');

  /* --- About --- */
  Route::resource( '/about', 'AboutController' )->only([
    'index',
  ]);
  Route::get( 'about/download/{file}', 'AboutController@getFile' )->name('about.getFile');

  /* --- Carpetas --- */
  Route::get( '/productos/carpeta/{id}', 'ProductosCarpetasController@show' )->name('carpetas.show');

  /* --- Decargar archivos de los productos */
  Route::get( 'productos/{producto}/download/{file}', 'ProductosController@getFile' )->name('get_file');
  Route::get( 'artes/{id}/download', 'ProductosArtesController@getFile' )->name('get_arte_file');

  Route::get('/producto/{id}', 'ProductosController@show')->name('show');

  /* --- Perfil --- */
  Route::get( '/perfil', 'UserController@perfil' )->name( 'perfil' );
  Route::get( '/perfil/edit', 'UserController@perfil_edit' )->name( 'perfil_edit' );
  Route::patch( '/perfil', 'UserController@update_perfil' )->name( 'update_perfil' );

  /* --- Solo usuarios Admin u Operativo --- */
  Route::group( ['middleware' => 'access.role:Operativo'], function (){

    /* --- Producto Artes --- */
    Route::get( '/artes', 'ProductosArtesController@index')->name('artes.index');

    /* --- Productos --- */
    Route::resource( '/productos', 'ProductosController' )->only([
      'index',
      'create',
      'store',
      'show',
      'getFile'
    ]);

    /* --- Categorias de los productos --- */
    Route::resource( '/categorias', 'ProductosCategoriasController' );

  });

  /* --- Solo usuarios Admin --- */  
  Route::group( ['middleware' => 'access.role:Admin'], function (){
    
    /* --- Carpetas --- */
    Route::get('/carpetas/create/{producto}', 'ProductosCarpetasController@create')->name('carpetas.create');
    Route::resource( '/carpetas', 'ProductosCarpetasController' )->only([
      'store',
      'edit',
      'update',
      'destroy'
    ]);

    /* --- Representantes --- */
    Route::resource( '/representantes', 'RepresentantesController' )->only([
      'index',
      'create',
      'store',
      'destroy'
    ]);
    
    /* --- About --- */
    Route::resource( '/about', 'AboutController' )->only([
      'edit',
      'update'
    ]);


    /* --- Producto Artes --- */
    Route::post( '/artes/{id}/upload', 'ProductosArtesController@store' )->name('artes.store');
    Route::delete( '/artes/{id}', 'ProductosArtesController@destroy')->name('artes.destroy');

    /* --- Productos --- */
    Route::resource( '/productos', 'ProductosController' )->only([
      'edit',
      'update',
      'destroy'
    ]);

    /* --- Departamentos --- */
    Route::resource( '/departamentos', 'DepartamentosController' );

    /* --- Cargos --- */
    Route::resource( '/cargos', 'CargosController' );

    /* --- Usuarios ---*/
    Route::patch( '/users/password/{id}', 'UserController@changePassword' )->name( 'users.change_password' );
    Route::patch( '/users/status/{id}', 'UserController@changeStatus' )->name( 'users.change_status' );
    Route::resource( '/users','UserController' );
  });

});
