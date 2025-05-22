@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Adicionar Alimento</h1>

        <form action="{{ route('alimentos.store') }}" method="POST" class="mt-4">
            @csrf
            
            <div class="form-group mb-3">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    @foreach($categorias as $valor => $nome)
                        <option value="{{ $valor }}">{{ $nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" min="0" required>
            </div>

            <div class="form-group mb-3">
                <label for="estoque_minimo">Estoque Mínimo:</label>
                <input type="number" name="estoque_minimo" id="estoque_minimo" class="form-control" min="0" required>
            </div>

            <div class="form-group mb-3">
                <label for="validade">Data de Validade:</label>
                <input type="date" name="validade" id="validade" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('alimentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection 