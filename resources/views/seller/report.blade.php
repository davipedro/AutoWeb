@extends('layouts.app')

@section('title', 'Relatório de Vendas')

@section('content')
    <div class="relatorio-vendas">
        <h1 class="relatorio-vendas__titulo">Relatório de Vendas</h1>
        <p class="relatorio-vendas__subtitulo">Analise suas vendas de forma detalhada</p>

        <div class="relatorio-vendas__filtros">
            <div class="relatorio-vendas__filtros-group">
                <label>Data Inicial</label>
                <input type="date" class="relatorio-vendas__input" placeholder="dd/mm/aaaa">
            </div>
            <div class="relatorio-vendas__filtros-group">
                <label>Data Final</label>
                <input type="date" class="relatorio-vendas__input" placeholder="dd/mm/aaaa">
            </div>
            <div class="relatorio-vendas__filtros-group relatorio-vendas__filtros-group--button">
                <label>&nbsp;</label>
                <button type="submit" class="filter-btn">
                    <i class="fa fa-filter"></i> Filtrar
                </button>
            </div>
        </div>

        <div class="relatorio-vendas__cards">
            <div class="relatorio-vendas__card border-left-blue">
                <p class="relatorio-vendas__card-label">Total de Vendas</p>
                <h2 class="relatorio-vendas__card-valor">5</h2>
                <p class="relatorio-vendas__card-sub">Vendas no período</p>
            </div>
            <div class="relatorio-vendas__card border-left-cyan">
                <p class="relatorio-vendas__card-label">Total Vendido</p>
                <h2 class="relatorio-vendas__card-valor">R$ 369.450,37</h2>
                <p class="relatorio-vendas__card-sub">Valor total das vendas</p>
            </div>
            <div class="relatorio-vendas__card border-left-orange">
                <p class="relatorio-vendas__card-label">Total de Comissões</p>
                <h2 class="relatorio-vendas__card-valor">R$ 11.465,93</h2>
                <p class="relatorio-vendas__card-sub">Comissões recebidas</p>
            </div>
        </div>

        <div class="relatorio-vendas__tabela">
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
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach ([
                    ['Carlos Silva', 'R$ 85.000', 'R$8.400,00'],
                    ['Ana Costa', 'R$ 85.000', 'R$5.400,00'],
                    ['Pedro Santos', 'R$ 85.000', 'R$3.400,00'],
                    ['Maria Oliveira', 'R$ 85.000', 'R$1.400,00'],
                    ['João Pereira', 'R$ 85.000', 'R$4.400,00'],
                ] as $venda)
                    <tr>
                        <td>C001</td>
                        <td>{{ $venda[0] }}</td>
                        <td>Honda Civic 2022</td>
                        <td class="green">{{ $venda[1] }}</td>
                        <td class="purple">{{ $venda[2] }}</td>
                        <td>15/01/2023</td>
                        <td>
                            <button class="relatorio-vendas__acao-btn">
                                <img src="{{ asset('icons/edit.svg') }}" alt="Editar">
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
