<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrecoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $precos = \App\Models\Preco::all(); // Fetch all preços from the database
        $normas = \App\Models\Norma::all(); // Fetch all normas for the dropdown
        return view('preco.index', compact('precos', 'normas')); // Pass the data to the view
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
        $validatedData = $request->validate([
            'valor' => 'required|numeric',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'id_norma' => 'required|exists:norma,id_norma',
        ]);
        \App\Models\Preco::create($validatedData);
        return redirect()->route('precos.index')->with('success', 'Preço criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('preco.show', ['preco' => \App\Models\Preco::findOrFail($id)]);
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
        $preco = \App\Models\Preco::findOrFail($id);
        $preco->delete();
        return redirect()->route('precos.index')->with('success', 'Preço eliminado com sucesso!');
    }
}
