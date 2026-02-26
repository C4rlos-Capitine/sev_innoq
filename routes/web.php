<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $normas = \App\Models\Norma::with([
        'precos' => function($q) { $q->orderBy('created_at', 'desc')->limit(1); },
        //'documentos' => function($q) { $q->orderBy('created_at', 'desc'); },
    ])->orderBy('created_at', 'desc')->get();
    $provincias = \App\Models\provincia::orderBy('nome_provincia')->get();
    $normasJs = $normas->map(function($n){
        return [
            'id' => $n->id_norma,
            'titulo' => $n->titulo,
            'codigo' => $n->codigo,
            'valor' => optional($n->precos->first())->valor ?? 0,
        ];
    });
    return view('loja', compact('normas','provincias','normasJs'));
});

Route::resource('agentes', App\Http\Controllers\AgenteEconomicoController::class);
Route::resource('documentos', App\Http\Controllers\DocumentoController::class);
Route::resource('item_pedido', App\Http\Controllers\ItemPedidoController::class);
Route::resource('referencia', App\Http\Controllers\ReferenciaController::class);
Route::resource('provincias', App\Http\Controllers\ProvinciaController::class);
    Route::resource('norma', App\Http\Controllers\NormaController::class);
// Authentication routes (simple controller)
Route::get('login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::resource('pedidos', App\Http\Controllers\PedidoController::class);
// Protected routes - acessíveis somente por utilizadores autenticados
Route::middleware('auth')->group(function () {

    Route::resource('precos', App\Http\Controllers\PrecoController::class);
  
    // User management (listar, registar/editar via modal)
    Route::resource('users', App\Http\Controllers\UserController::class);
});

Route::get('/loja', function () {
    $normas = \App\Models\Norma::with([
        'precos' => function($q) { $q->orderBy('created_at', 'desc')->limit(1); },
        //'documentos' => function($q) { $q->orderBy('created_at', 'desc'); },
    ])->orderBy('created_at', 'desc')->get();
    $provincias = \App\Models\provincia::orderBy('nome_provincia')->get();
    $normasJs = $normas->map(function($n){
        return [
            'id' => $n->id_norma,
            'titulo' => $n->titulo,
            'codigo' => $n->codigo,
            'valor' => optional($n->precos->first())->valor ?? 0,
        ];
    });
    return view('loja', compact('normas','provincias','normasJs'));
})->name('loja');

// download documento by table name and primary key
Route::get('documentos/download/{nome_tabela}/{chave}', [App\Http\Controllers\DocumentoController::class, 'download'])->name('documentos.download');
Route::get('documentos/download/id/{id}', [App\Http\Controllers\DocumentoController::class, 'downloadById'])->name('documentos.downloadById');

// Generate and display PDF invoice for pedido
Route::get('pedido/{id}/fatura', [App\Http\Controllers\PedidoController::class, 'gerarFatura'])->name('pedido.pdf');
Route::get('pedidos_consultar', [App\Http\Controllers\PedidoController::class, 'consultarPedidoByCodigo'])->name('pedidos.consultar');
Route::get('pedidos_consultar2', [App\Http\Controllers\PedidoController::class, 'showConsultarForm'])->name('pedidos.consultar.form');
Route::get('relatorio/pdf', [App\Http\Controllers\RelatorioController::class, 'gerarPDF'])->name('relatorio.pdf');
Route::get('relatorio/fatura/{id}', [App\Http\Controllers\RelatorioController::class, 'gerarFacturaPDF'])->name('relatorio.fatura.pdf');