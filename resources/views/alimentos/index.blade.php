@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lista de Alimentos</h1>
        <a href="{{ route('alimentos.create') }}" class="btn btn-primary">Adicionar Novo Alimento</a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success">
            {{ session('sucesso') }}
        </div>
    @endif

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('alimentos.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select name="categoria" id="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $key => $value)
                            <option value="{{ $key }}" {{ request('categoria') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="validade_proxima" name="validade_proxima" value="1" {{ request('validade_proxima') ? 'checked' : '' }}>
                        <label class="form-check-label" for="validade_proxima">Validade Próxima (7 dias)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4">
                        <input type="checkbox" class="form-check-input" id="estoque_baixo" name="estoque_baixo" value="1" {{ request('estoque_baixo') ? 'checked' : '' }}>
                        <label class="form-check-label" for="estoque_baixo">Estoque Baixo</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('alimentos.index') }}" class="btn btn-secondary">Limpar Filtros</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Quantidade</th>
                    <th>Estoque Mínimo</th>
                    <th>Validade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alimentos as $alimento)
                    <tr class="{{ $alimento->estoqueBaixo() ? 'table-warning' : '' }} {{ $alimento->validadeProxima() ? 'table-danger' : '' }}">
                        <td>{{ $alimento->nome }}</td>
                        <td>{{ $categorias[$alimento->categoria] }}</td>
                        <td>
                            {{ $alimento->quantidade }}
                            @if($alimento->estoqueBaixo())
                                <span class="badge bg-warning">Estoque Baixo</span>
                            @endif
                        </td>
                        <td>{{ $alimento->estoque_minimo }}</td>
                        <td>
                            {{ $alimento->validade ? \Carbon\Carbon::parse($alimento->validade)->format('d/m/Y') : 'Sem validade' }}
                            @if($alimento->validadeProxima())
                                <span class="badge bg-danger">Vence em breve</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('alimentos.edit', $alimento) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('alimentos.destroy', $alimento) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este alimento?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection 