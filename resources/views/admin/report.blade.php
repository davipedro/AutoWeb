@extends('layouts.app')

@section('title', 'Relatório Administrativo de Vendas')

@section('content')

    @php
        // Dados fictícios para facilitar testes e visualização
        $totalVendas = 25;
        $totalVendasVendedor = 10;
        $vendedorSelecionadoNome = 'Carlos Silva';
        $valorTotalVendas = 125000.75;
        $valorComissoesPagas = 8750.50;

        $vendas = collect([
            (object)[
                'id' => 'C001',
                'vendedor_nome' => 'Carlos Silva',
                'veiculo' => 'Honda Civic 2022',
                'valor_venda' => 85000,
                'comissao' => 8400,
                'data' => \Carbon\Carbon::createFromFormat('d/m/Y', '15/01/2023')
            ],
            (object)[
                'id' => 'C002',
                'vendedor_nome' => 'Ana Costa',
                'veiculo' => 'Toyota Corolla 2021',
                'valor_venda' => 75000,
                'comissao' => 5400,
                'data' => \Carbon\Carbon::createFromFormat('d/m/Y', '10/02/2023')
            ],
            (object)[
                'id' => 'C003',
                'vendedor_nome' => 'Pedro Santos',
                'veiculo' => 'Ford Focus 2020',
                'valor_venda' => 60000,
                'comissao' => 3400,
                'data' => \Carbon\Carbon::createFromFormat('d/m/Y', '28/02/2023')
            ],
        ]);
    @endphp

    <div class="relatorio-vendas">
        <h1 class="relatorio-vendas__titulo">Relatório Administrativo de Vendas</h1>
        <p class="relatorio-vendas__subtitulo">Analise suas vendas de forma detalhada e por vendedor</p>

        {{--Lembrar de colocar o action para fazer os filtros--}}
        <form method="GET" action="" class="relatorio-vendas__filtros" style="display:flex; gap:1rem; flex-wrap: wrap;">
            <div class="relatorio-vendas__filtros-group">
                <label>Data Inicial</label>
                <input type="date" name="data_inicial" class="relatorio-vendas__input" value="{{ request('data_inicial') }}">
            </div>
            <div class="relatorio-vendas__filtros-group">
                <label>Data Final</label>
                <input type="date" name="data_final" class="relatorio-vendas__input" value="{{ request('data_final') }}">
            </div>
            <div class="relatorio-vendas__filtros-group">
                <label>Vendedor</label>
                <select name="vendedor" class="relatorio-vendas__input">
                    <option value="">Todos</option>
                    @foreach ($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" {{ request('vendedor') == $vendedor->id ? 'selected' : '' }}>
                            {{ $vendedor->nome_completo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="relatorio-vendas__filtros-group relatorio-vendas__filtros-group--button" style="align-self: flex-end;">
                <button type="submit" class="filter-btn">
                    <i class="fa fa-filter"></i> Filtrar
                </button>
            </div>
        </form>

        <div class="relatorio-vendas__cards" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1.5rem;">
            <div class="relatorio-vendas__card border-left-blue" style="flex: 1 1 220px;">
                <p class="relatorio-vendas__card-label">Total de Vendas</p>
                <h2 class="relatorio-vendas__card-valor">{{ $totalVendas }}</h2>
                <p class="relatorio-vendas__card-sub">Vendas no período</p>
            </div>
            <div class="relatorio-vendas__card border-left-cyan" style="flex: 1 1 220px;">
                <p class="relatorio-vendas__card-label">Total de Vendas por Vendedor</p>
                <h2 class="relatorio-vendas__card-valor">{{ $totalVendasVendedor }}</h2>
                <p class="relatorio-vendas__card-sub">{{ $vendedorSelecionadoNome ?? 'Todos os vendedores' }}</p>
            </div>
            <div class="relatorio-vendas__card border-left-green" style="flex: 1 1 220px;">
                <p class="relatorio-vendas__card-label">Valor Total das Vendas</p>
                <h2 class="relatorio-vendas__card-valor">R$ {{ number_format($valorTotalVendas, 2, ',', '.') }}</h2>
                <p class="relatorio-vendas__card-sub">Valor total vendido no período</p>
            </div>
            <div class="relatorio-vendas__card border-left-orange" style="flex: 1 1 220px;">
                <p class="relatorio-vendas__card-label">Comissões Pagas</p>
                <h2 class="relatorio-vendas__card-valor">R$ {{ number_format($valorComissoesPagas, 2, ',', '.') }}</h2>
                <p class="relatorio-vendas__card-sub">Total pago em comissões</p>
            </div>
        </div>

        <div class="relatorio-vendas__tabela" style="margin-top: 2rem;">
            <h3 class="relatorio-vendas__tabela-titulo">Detalhamento das Vendas</h3>
            <p class="relatorio-vendas__tabela-subtitulo">Lista completa das vendas no período selecionado</p>

            <table class="relatorio-vendas__tabela-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Veículo</th>
                    <th>Valor de Venda</th>
                    <th>Comissão</th>
                    @if($vendedorSelecionadoNome === null || $vendedorSelecionadoNome === '')
                        <th>Vendedor</th>
                    @endif
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vendas as $venda)
                    <tr>
                        <td>{{ $venda->id }}</td>
                        <td>{{ $venda->vendedor_nome }}</td>
                        <td>{{ $venda->veiculo }}</td>
                        <td class="green">R$ {{ number_format($venda->valor_venda, 2, ',', '.') }}</td>
                        <td class="purple">R$ {{ number_format($venda->comissao, 2, ',', '.') }}</td>
                        @if($vendedorSelecionadoNome === null || $vendedorSelecionadoNome === '')
                            <td>{{ $venda->vendedor_nome }}</td>
                        @endif
                        <td>{{ $venda->data->format('d/m/Y') }}</td>
                        <td>
                            <button class="relatorio-vendas__acao-btn">
                                <img src="{{ asset('icons/edit.svg') }}" alt="Editar">
                            </button>
                        </td>
                    </tr>
                @endforeach
                @if($vendas->isEmpty())
                    <tr>
                        <td colspan="7" style="text-align:center;">Nenhuma venda encontrada para os filtros selecionados.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
