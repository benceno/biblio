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




//Adeudos
Route::get('/adeudos', 'AdeudoController@indexpag')->name('adeudo.index');


Route::get('/', function(){
    return view('Carreras.carreras');
});

Route::resource('carreras', 'CarreraController', ['except' => 'create', 'edit', 'show']);

//Autores
Route::get('/autores', function () {
    return view('autores.index');
});

Route::resource('autors', 'AutoresController',['except' =>'show', 'create', 'edit']);
