<?php

namespace App\Repositories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository
{
    /**
     * Retorna a contagem de Sales de um vendedor para um intervalo de datas específico.
     */
    public static function getSalesCountForSeller(int $sellerId, Carbon $startDate, Carbon $endDate): int
    {
        return Sale::where('vendedor_id', $sellerId)
            ->whereBetween('data_venda', [$startDate, $endDate])
            ->count();
    }

    /**
     * Retorna a soma do valor total vendido por um vendedor para um intervalo de datas específico.
     */
    public static function getTotalValueSoldForSeller(int $sellerId, Carbon $startDate, Carbon $endDate): float
    {
        return Sale::where('vendedor_id', $sellerId)
            ->whereBetween('data_venda', [$startDate, $endDate])
            ->sum('valor_total');
    }

    /**
     * Retorna a soma das comissões de um vendedor para um intervalo de datas específico.
     */
    public static function getAccumulatedCommissionsForSeller(int $sellerId, Carbon $startDate, Carbon $endDate): float
    {
        return Sale::where('vendedor_id', $sellerId)
            ->whereBetween('data_venda', [$startDate, $endDate])
            ->sum('comissao');
    }

    /**
     * Retorna as vendas paginadas de um vendedor para um intervalo de datas.
     *
     * @param int $sellerId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int $perPage
     */
    public static function getPaginatedSalesForSeller(int $sellerId, Carbon $startDate, Carbon $endDate, int $perPage = 5)
    {
        return Sale::with([
            'client' => function ($query) {
                $query->select('id', 'nome_completo');
            },
            'vehicle' => function ($query) {
                $query->select('id', 'modelo');
            }
        ])
            ->where('vendedor_id', $sellerId)
            ->whereBetween('data_venda', [$startDate, $endDate])
            ->latest('data_venda')
            ->select(['id', 'cliente_id', 'veiculo_id', 'valor_total', 'comissao', 'data_venda'])
            ->paginate($perPage)
            ->withQueryString();
    }
}
