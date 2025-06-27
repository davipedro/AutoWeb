@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 bg-gray-50 min-h-screen">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Dashboard do Vendedor</h1>
            <p class="text-gray-600">Acompanhe seu desempenho de vendas</p>
        </div>

        <form method="GET" action="{{ route('seller.dashboard') }}" class="mb-8">
            <div class="flex items-center space-x-3 bg-white p-4 rounded-lg shadow-sm border">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-500">
                    <path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path>
                </svg>

                <select name="period" class="w-48 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="current_month" @selected($currentPeriod == 'current_month')>Mês Atual</option>
                    <option value="last_month" @selected($currentPeriod == 'last_month')>Mês Passado</option>
                    <option value="last_quarter" @selected($currentPeriod == 'last_quarter')>Último Trimestre</option>
                    <option value="current_year" @selected($currentPeriod == 'current_year')>Ano Atual</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Filtrar
                </button>

                <a href="{{ route('seller.dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Limpar
                </a>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-600">Vendas Realizadas</p>
                <p class="text-3xl font-bold text-gray-800">{{ $salesCount ?? '0' }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-600">Valor Total Vendido</p>
                <p class="text-3xl font-bold text-gray-800">$ {{ number_format($totalSalesValue ?? 0, 2, '.', ',') }}</p>
            </div>
            <div class="bg-white p-5 rounded-lg shadow border-l-4 border-purple-500">
                <p class="text-sm font-medium text-gray-600">Comissões Acumuladas</p>
                <p class="text-3xl font-bold text-gray-800">$ {{ number_format($accumulatedCommissions ?? 0, 2, '.', ',') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Últimas Vendas</h2>
                <p class="text-sm text-gray-500 mt-1">Histórico das suas vendas recentes</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Cliente</th>
                        <th scope="col" class="px-6 py-3">Veículo</th>
                        <th scope="col" class="px-6 py-3">Valor da Venda</th>
                        <th scope="col" class="px-6 py-3">Comissão</th>
                        <th scope="col" class="px-6 py-3">Data</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sales ?? [] as $sale)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ str_pad($sale->id, 4, 0, STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">{{ $sale->client->nome_completo ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $sale->vehicle->modelo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium text-green-600">$ {{ number_format($sale->valor_total, 2, '.', ',') }}</td>
                            <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                        $ {{ number_format($sale->comissao, 2, '.', ',') }}
                                    </span>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($sale->date)->format('m/d/Y') }}</td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhuma venda encontrada.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-container">
            {{ $sales->links('partials.pagination') }}
        </div>

    </div>
@endsection
