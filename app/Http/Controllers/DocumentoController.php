<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Download the latest document for a given table and primary key.
     */
    public function download(string $nome_tabela, $chave)
    {
        $documento = Documento::where('nome_tabela', $nome_tabela)
            ->where('chave_primaria', $chave)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $documento) {
            return redirect()->back()->with('error', 'Documento não encontrado.');
        }

        $path = $documento->path;

        if (! Storage::disk('public')->exists($path)) {
            return redirect()->back()->with('error', 'Ficheiro não encontrado no servidor.');
        }

        return Storage::disk('public')->download($path);
    }

    /**
     * Download a specific documento by its id_documento.
     */
    public function downloadById($id)
    {
        $documento = Documento::find($id);

        if (! $documento) {
            return redirect()->back()->with('error', 'Documento não encontrado.');
        }

        if (! Storage::disk('public')->exists($documento->path)) {
            return redirect()->back()->with('error', 'Ficheiro não encontrado no servidor.');
        }

        return Storage::disk('public')->download($documento->path);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
