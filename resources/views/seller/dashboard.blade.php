@extends('layouts.app')

@section('title', 'Dashboard do Vendedor')

@section('content')

    @php
        $meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];
    @endphp
    <div class="dashboard-vendedor">
        <h1 class="dashboard-vendedor__title">Dashboard do Vendedor</h1>
        <p class="dashboard-vendedor__subtitle">Acompanhe seu desempenho de vendas</p>

        <div class="dashboard-vendedor__filtro">
            <select class="dashboard-vendedor__filtro-select">
                <option>Selecione um mês</option>
                @foreach($meses as $mes)
                    <option value="{{ strtolower($mes) }}">
                        {{ $mes }}
                    </option>
                @endforeach
            </select>
            <select class="dashboard-vendedor__filtro-select">
                <option>Selecione um ano</option>
                @foreach($meses as $mes)
                    <option value="{{ strtolower($mes) }}">
                        {{ $mes }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="dashboard-vendedor__resumo-cards">
            <div class="dashboard-vendedor__card border-left-blue">
                <p class="dashboard-vendedor__card-titulo">VENDAS DO MÊS</p>
                <h2 class="dashboard-vendedor__card-valor">-</h2>
                <p class="dashboard-vendedor__card-sub">Em estoque</p>
            </div>
            <div class="dashboard-vendedor__card border-left-green">
                <p class="dashboard-vendedor__card-titulo">VEÍCULOS DISPONÍVEIS</p>
                <h2 class="dashboard-vendedor__card-valor">{{ $veiculosDisponiveis }}</h2>
                <p class="dashboard-vendedor__card-sub">Disponíveis para venda</p>
            </div>
            <div class="dashboard-vendedor__card border-left-orange">
                <p class="dashboard-vendedor__card-titulo">TOTAL DE VENDAS</p>
                <h2 class="dashboard-vendedor__card-valor">0</h2>
                <p class="dashboard-vendedor__card-sub">Contagem total</p>
            </div>
        </div>

        <div class="dashboard-vendedor__tabela-vendas">
            <h3 class="dashboard-vendedor__tabela-titulo">Últimas Vendas</h3>
            <p class="dashboard-vendedor__tabela-subtitulo">Histórico das suas vendas recentes</p>
            <table class="dashboard-vendedor__tabela">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Veículo</th>
                    <th>Valor de Venda</th>
                    <th>Comissão</th>
                    <th>Data</th>
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
