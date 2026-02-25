<?php

namespace App\Http\Controllers;

use App\Models\Norma;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class NormaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $normas = Norma::with([
            'precos' => function($q) { $q->orderBy('created_at', 'desc')->limit(1); },
            'documentos' => function($q) { $q->orderBy('created_at', 'desc'); },
        ])->orderBy('created_at', 'desc')->get();

        Log::info('Normas fetched: '.count($normas));

        return view('norma.index', compact('normas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provincias = \App\Models\provincia::orderBy('nome_provincia')->get();
        return view('norma.create', compact('provincias'));
       // return view('norma.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:norma,codigo',
            'descricao' => 'required|string',
            'documento' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // create norma first
        $norma = Norma::create([
            'titulo' => $validated['titulo'],
            'codigo' => $validated['codigo'],
            'descricao' => $validated['descricao'],
        ]);

        // handle optional pdf upload
        if ($request->hasFile('documento')) {
            $file = $request->file('documento');
            $path = $file->store('documents', 'public');

            Documento::create([
                'path' => $path,
                'nome_tabela' => 'norma',
                'chave_primaria' => $norma->id_norma,
            ]);
        }

        return redirect()->route('norma.index')->with('success', 'Norma criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Norma $norma)
    {
        return view('norma.show', compact('norma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Norma $norma)
    {
        return view('norma.edit', compact('norma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Norma $norma)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:norma,codigo,' . $norma->id_norma . ',id_norma',
            'descricao' => 'required|string',
            'documento' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $norma->update([
            'titulo' => $validated['titulo'],
            'codigo' => $validated['codigo'],
            'descricao' => $validated['descricao'],
        ]);

        if ($request->hasFile('documento')) {
            $file = $request->file('documento');
            $path = $file->store('documents', 'public');

            // try to find existing documento for this norma
            $doc = Documento::where('nome_tabela', 'norma')
                ->where('chave_primaria', $norma->id_norma)
                ->first();

            if ($doc) {
                // delete old file if exists
                if (Storage::disk('public')->exists($doc->path)) {
                    Storage::disk('public')->delete($doc->path);
                }
                $doc->update(['path' => $path]);
            } else {
                Documento::create([
                    'path' => $path,
                    'nome_tabela' => 'norma',
                    'chave_primaria' => $norma->id_norma,
                ]);
            }
        }

        return redirect()->route('norma.index')->with('success', 'Norma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Norma $norma)
    {
        $norma->delete();
        return redirect()->route('norma.index')->with('success', 'Norma deletada com sucesso!');
    }
}
