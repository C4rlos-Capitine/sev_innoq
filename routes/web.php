<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('norma', App\Http\Controllers\NormaController::class);
Route::resource('agentes', App\Http\Controllers\AgenteEconomicoController::class); 
Route::resource('documentos', App\Http\Controllers\DocumentoController::class);
Route::resource('precos', App\Http\Controllers\PrecoController::class);

Route::get('/loja', function () {
    $normas = \App\Models\Norma::with([
        'precos' => function($q) { $q->orderBy('created_at', 'desc')->limit(1); },
        //'documentos' => function($q) { $q->orderBy('created_at', 'desc'); },
    ])->orderBy('created_at', 'desc')->get();
    //return response()->json($normas);
    return view('loja', compact('normas'));
})->name('loja');

// download documento by table name and primary key
Route::get('documentos/download/{nome_tabela}/{chave}', [App\Http\Controllers\DocumentoController::class, 'download'])->name('documentos.download');
Route::get('documentos/download/id/{id}', [App\Http\Controllers\DocumentoController::class, 'downloadById'])->name('documentos.downloadById');
