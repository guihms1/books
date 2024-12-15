<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('home');
})->name('home');

Route::resource('livros', 'App\Http\Controllers\LivroController');
Route::resource('assuntos', 'App\Http\Controllers\AssuntoController');
Route::resource('autores', 'App\Http\Controllers\AutorController');
Route::get('relatorio', 'App\Http\Controllers\AutorReportController@index')
    ->name('autor_report.index');
