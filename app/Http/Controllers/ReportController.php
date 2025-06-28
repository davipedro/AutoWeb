<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function adminReport(Request $request)
    {

        $vendedorId = $request->query('vendedor');
        $dataInicio = $request->query('data_venda_inicio');
        $dataFim = $request->query('data_venda_fim');

        $vendedores = SellerController::getSellers();
        $vendas = SaleController::getSales($dataInicio, $dataFim ,$vendedorId);
        $totalVendas = $vendas->total();
        $totalVendedores = SellerController::getNumberOfSellers();
        $totalVendasVendedor = Sale::whereNull('deleted_at')
            ->when($vendedorId, function ($query) use ($vendedorId) {
                return $query->where('vendedor_id', $vendedorId);
            })
            ->count();

        $valorTotalVendas = SaleRepository::getTotalValueOfAllSales();
        $valorComissoesPagas = SaleRepository::getTotalCommissionsPaid();
        $vendedorSelecionadoNome = null;

        return view('admin.report', compact(
            'vendedores', 'vendas', 'totalVendas', 'totalVendedores', 'totalVendasVendedor',
            'valorTotalVendas', 'valorComissoesPagas', 'vendedorSelecionadoNome',
        ));
    }

    public function sellerReport()
    {
        return view('seller.report');
    }
}
