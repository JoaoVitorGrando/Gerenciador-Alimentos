@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2>Editar Alimento</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('alimentos.update', $alimento) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $alimento->nome) }}" required>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categorias as $valor => $nome)
                                    <option value="{{ $valor }}" {{ old('categoria', $alimento->categoria) == $valor ? 'selected' : '' }}>
                                        {{ $nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control @error('quantidade') is-invalid @enderror" id="quantidade" name="quantidade" value="{{ old('quantidade', $alimento->quantidade) }}" min="0" required>
                            @error('quantidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="estoque_minimo" class="form-label">Estoque Mínimo</label>
                            <input type="number" class="form-control @error('estoque_minimo') is-invalid @enderror" id="estoque_minimo" name="estoque_minimo" value="{{ old('estoque_minimo', $alimento->estoque_minimo) }}" min="0" required>
                            @error('estoque_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="validade" class="form-label">Data de Validade</label>
                            <input type="date" class="form-control @error('validade') is-invalid @enderror" id="validade" name="validade" value="{{ old('validade', $alimento->validade ? \Carbon\Carbon::parse($alimento->validade)->format('Y-m-d') : '') }}">
                            @error('validade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('alimentos.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 