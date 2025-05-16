<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alimento;

class AlimentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Alimento::query();

        // Filtro por categoria
        if ($request->has('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Filtro por validade próxima
        if ($request->has('validade_proxima')) {
            $query->where('validade', '<=', now()->addDays(7))
                  ->where('validade', '>=', now());
        }

        // Filtro por estoque baixo
        if ($request->has('estoque_baixo')) {
            $query->whereRaw('quantidade <= estoque_minimo');
        }

        $alimentos = $query->get();
        $categorias = Alimento::CATEGORIAS;

        return view('alimentos.index', compact('alimentos', 'categorias'));
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
            'categoria' => 'required|in:' . implode(',', array_keys(Alimento::CATEGORIAS)),
            'quantidade' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'validade' => 'nullable|date',
        ]);

        Alimento::create($request->all());

        return redirect()->route('alimentos.index')->with('sucesso', 'Alimento adicionado!');
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
            'categoria' => 'required|in:' . implode(',', array_keys(Alimento::CATEGORIAS)),
            'quantidade' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'validade' => 'nullable|date',
        ]);

        $alimento->update($request->all());

        return redirect()->route('alimentos.index')->with('sucesso', 'Alimento atualizado!');
    }

    public function destroy(Alimento $alimento)
    {
        $alimento->delete();

        return redirect()->route('alimentos.index')->with('sucesso', 'Alimento removido!');
    }
}
