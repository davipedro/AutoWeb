@extends('layouts.app')

@section('title', 'Gestão de Veículos')

@section('content')
    <div class="vehicles-header">
        <div>
            <h1>Gestão de Veículos</h1>
            <p class="subheading">Gerencie o estoque de veículos</p>
        </div>

        <div>
            <a href="{{ route('veiculos.add') }}" class="add-btn">+ Cadastrar Novo Veículo</a>
        </div>
    </div>

    <div class="filters">
        <div class="filter-options">
            <input type="text" id="model_search" placeholder="Buscar por modelo..." />
            <select id="brand_search">
                <option>Marca</option>
            </select>
            <select id="status_search">
                <option>Status</option>
            </select>
            <select id="year_search">
                <option>Ano</option>
            </select>
        </div>
    </div>

    <div class="vehicle-list">
        <h2>Lista de Veículos</h2>
        <p>Total: {{ $veiculosArray['count'] }} veículos cadastrados</p>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Marca/Modelo</th>
                <th>Ano</th>
                <th>KM</th>
                <th>Valor Custo</th>
                <th>Valor Venda</th>
                <th>Combustível</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <!-- Início do bloco de repetição -->
            @foreach($veiculosArray['itens'] as $veiculo)
                <tr>
                    <td>{{ $veiculo->id }}</td>
                    <td>{{ $veiculo->marca }} {{ $veiculo->modelo }}</td>
                    <td>{{ $veiculo->ano }}</td>
                    <td>{{ $veiculo->quilometragem }} Km</td>
                    <td class="price-cost">R$ {{ $veiculo->valor_custo }}</td>
                    <td class="price-sale">R$ {{ $veiculo->valor_venda }}</td>
                    <td>{{ $veiculo->tipo_combustivel }}</td>
                    <td>
                        <span class="status{{ $veiculo->status->nome }}">
                            @if($veiculo->status->nome == "disponivel")
                                <span class="status-disponivel">Disponível</span>
                            @endif
                            @if($veiculo->status->nome == "vendido")
                                <span class="status-vendido">Vendido</span>
                            @endif
                            @if($veiculo->status->nome == "indisponivel")
                                <span class="status-indisponivel">Indisponível</span>
                            @endif
                        </span>
                    </td>
                    <td>
                        <button type="button" class="details-btn">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="edit-btn">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="submit" class="delete-btn">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            <!-- Fim do bloco de repetição -->
            </tbody>
        </table>
    </div>
@endsection
