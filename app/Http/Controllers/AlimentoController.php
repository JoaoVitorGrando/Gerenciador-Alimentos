<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
    public function index()
    {
        $alimentos = Alimento::all();
        $alimentosEstoqueBaixo = Alimento::comEstoqueBaixo();
        $alimentosValidadeProxima = Alimento::comValidadeProxima();
        $categorias = Alimento::CATEGORIAS;
        
        return view('alimentos.index', compact('alimentos', 'alimentosEstoqueBaixo', 'alimentosValidadeProxima', 'categorias'));
    }

    public function create()
    {
        $categorias = Alimento::CATEGORIAS;
        
        return view('alimentos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'quantidade' => 'required|integer|min:0',
            'validade' => 'nullable|date',
            'categoria' => 'required|in:' . implode(',', array_keys(Alimento::CATEGORIAS)),
            'estoque_minimo' => 'required|integer|min:0'
        ]);

        Alimento::create($request->all());

        return redirect()->route('alimentos.index')
            ->with('sucesso', 'Alimento adicionado com sucesso!');
    }

    public function edit(Alimento $alimento)
    {
        $categorias = Alimento::CATEGORIAS;
        
        return view('alimentos.edit', compact('alimento', 'categorias'));
    }

    public function update(Request $request, Alimento $alimento)
    {
        $request->validate([
            'nome' => 'required',
            'quantidade' => 'required|integer|min:0',
            'validade' => 'nullable|date',
            'categoria' => 'required|in:' . implode(',', array_keys(Alimento::CATEGORIAS)),
            'estoque_minimo' => 'required|integer|min:0'
        ]);

        $alimento->update($request->all());

        return redirect()->route('alimentos.index')
            ->with('sucesso', 'Alimento atualizado com sucesso!');
    }

    public function destroy(Alimento $alimento)
    {
        $alimento->delete();

        return redirect()->route('alimentos.index')
            ->with('sucesso', 'Alimento removido com sucesso!');
    }
}
