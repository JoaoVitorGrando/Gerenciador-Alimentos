@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gerenciamento de Alimentos</h1>
        <a href="{{ route('alimentos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Alimento
        </a>
    </div>

    @if(session('sucesso'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('sucesso') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Alertas -->
    <div class="row mb-4">
        @if($alimentosEstoqueBaixo->count() > 0)
            <div class="col-md-6 mb-3">
                <div class="alert alert-warning h-100">
                    <h5 class="alert-heading">
                        <i class="fas fa-exclamation-triangle"></i> Alimentos com Estoque Baixo
                    </h5>
                    <ul class="mb-0">
                        @foreach($alimentosEstoqueBaixo as $alimento)
                            <li>{{ $alimento->nome }} - Quantidade: {{ $alimento->quantidade }} (Mínimo: {{ $alimento->estoque_minimo }})</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if($alimentosValidadeProxima->count() > 0)
            <div class="col-md-6 mb-3">
                <div class="alert alert-danger h-100">
                    <h5 class="alert-heading">
                        <i class="fas fa-clock"></i> Alimentos com Validade Próxima
                    </h5>
                    <ul class="mb-0">
                        @foreach($alimentosValidadeProxima as $alimento)
                            <li>{{ $alimento->nome }} - Vence em: {{ \Carbon\Carbon::parse($alimento->validade)->format('d/m/Y') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm mb-4">
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('alimentos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Alimentos -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Quantidade</th>
                            <th>Estoque Mínimo</th>
                            <th>Validade</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alimentos as $alimento)
                            <tr>
                                <td>{{ $alimento->nome }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $categorias[$alimento->categoria] }}
                                    </span>
                                </td>
                                <td>
                                    {{ $alimento->quantidade }}
                                    @if($alimento->estoqueBaixo())
                                        <span class="badge bg-warning">
                                            <i class="fas fa-exclamation-triangle"></i> Baixo
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $alimento->estoque_minimo }}</td>
                                <td>
                                    @if($alimento->validade)
                                        {{ \Carbon\Carbon::parse($alimento->validade)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Sem validade</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($alimento->statusValidade())
                                        @case('vencido')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle"></i> Vencido
                                            </span>
                                            @break
                                        @case('proximo')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Próximo
                                            </span>
                                            @break
                                        @case('valido')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Válido
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-minus-circle"></i> Sem validade
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('alimentos.edit', $alimento) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('alimentos.destroy', $alimento) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este alimento?')" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge {
        font-size: 0.85em;
    }
    .table th {
        font-weight: 600;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .alert {
        border-radius: 0.5rem;
    }
    .card {
        border-radius: 0.5rem;
    }
</style>
@endpush
@endsection 