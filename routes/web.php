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
//Ruta default
Route::get('/', function () {
    return redirect('login');
});
//Autores
Route::get('/autores', function () {
    return view('autores.index');
});
Route::resource('autors', 'AutoresController',['except' =>'show', 'create', 'edit']);
//Editoriales
Route::get('/editoriales', function () {
    return view('editoriales.index');
});
Route::resource('editorials', 'EditorialesController',['except' =>'show', 'create', 'edit']);
//DEWEY
Route::get('/dewey', function () {
    return view('dewey.index');
});
Route::get('cdewey/select/{id}', 'DeweyController@obtenerTopico')->name('obtenerTopico');
Route::resource('cdewey', 'DeweyController',['except' =>'create', 'edit', 'store', 'update', 'destroy']);
//Reportes
Route::get('/reportes',function (){
    return view('reportes.reportes');
});
Route::resource('reporte', 'ReportesController',['except' =>'show', 'create', 'edit']);
Route::get('reporte/carreras', 'ReportesController@getCarreras')->name('getCarreras');
Route::post('reporte/consultaprestamos','ReportesController@getReportes')->name('getReportes');
Route::post('reporte/consultaRegistrados', 'ReportesController@getRegistros')->name('getRegistros');
Route::get('reportes/imprimirreporte','ReportesController@imprimirReporte')->name('printreporte');
Route::get('reportes/imprimirreporteRegistros','ReportesController@imprimirReporteRegistros')->name('printreporteRegistros');
Route::get('reporte/consultaCatalogo', 'ReportesController@getCatalogo')->name('getCatalogo');
Route::get('reportes/imprimirreporteCatalogo','ReportesController@imprimirCatalogo')->name('printCatalogo');
//Libros
Route::resource('libros','LibrosController');
//Adeudos
Route::resource('adeudo', 'AdeudoController', ['except' => 'create', 'edit', 'show']);
Route::get('/adeudos', function (){
    return view('Adeudos.principal');
});
//Carreras
Route::resource('carreras', 'CarreraController', ['except' => 'create', 'edit', 'show']);
Route::get('/carrera', function(){
    return view('Carreras.carreras');
});
Route::get('/login', 'Auth\\LoginController@index')->name('login');
Route::get('/home', 'DashboardController@index')->name('home');
Route::post('/login', 'Auth\\LoginController@logIn');
//Usuarios
Route::get('/usuarios', 'UsersController@index')->name('usuarios');
Route::get('/prestatarios', 'UsersController@indexPrestatarios')->name('prestatarios');
Route::post('/usuarios/all', 'UsersController@getAll');
Route::post('/usuarios', 'UsersController@create');
Route::post('/usuarios/update', 'UsersController@update');
Route::post('/usuarios/remove', 'UsersController@delete');
