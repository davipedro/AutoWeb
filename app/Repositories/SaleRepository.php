<?php

namespace App\Repositories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SaleRepository
{
    public static function create($data)
    {
        try {
            $venda = Sale::create($data);
            return $venda->id;
        } catch (\Exception $e) {
            \Log::error('Erro ao criar venda: ' . $e->getMessage());
            throw $e; // Re-throw para o controller tratar
        }
    }

    public static function update($id, array $data)
    {
        try {
            $venda = Sale::find($id);
            if ($venda) {
                return $venda->update($data);
            }
        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar venda: ' . $e->getMessage());
        }
        return false;
    }

    public static function delete($id)
    {
        $venda = Sale::find($id);
        if ($venda) {
            return $venda->delete();
        }
        return false;
    }

    public static function getFilteredSale(array $filters = [], $sellerId = null)
    {
        $query = DB::table('sales')
            ->select(
                'sales.*',
                'clients.nome_completo as cliente_nome',
                'vehicles.id as veiculo_id',
                'vehicles.placa as placa',
                'vehicles.cor as veiculo_cor',
                DB::raw("CONCAT(vehicles.marca, ' ', vehicles.modelo, ' - ', vehicles.ano) as veiculo_nome"),
                'users.name as vendedor_nome'
            )
            ->leftJoin('clients', 'sales.cliente_id', '=', 'clients.id')
            ->leftJoin('vehicles', 'sales.veiculo_id', '=', 'vehicles.id')
            ->leftJoin('sellers', 'sales.vendedor_id', '=', 'sellers.id')
            ->leftJoin('users', 'sellers.user_id', '=', 'users.id')
            ->whereNull('sales.deleted_at');

        if (!empty($sellerId)) {
            $query->where('sales.vendedor_id', '=', $sellerId);
        }

        // Filtros
        if (!empty($filters['nome_cliente'])) {
            $query->where(DB::raw('LOWER(clients.nome_completo)'), 'like', '%' . strtolower($filters['nome_cliente']) . '%');
        }

        if (!empty($filters['data_venda_inicio']) && !empty($filters['data_venda_fim'])) {
            $query->whereBetween('sales.data_venda', [
                Carbon::parse($filters['data_venda_inicio'])->startOfDay(),
                Carbon::parse($filters['data_venda_fim'])->endOfDay()
            ]);
        } elseif (!empty($filters['data_venda_inicio'])) {
            $query->whereDate('sales.data_venda', '>=', Carbon::parse($filters['data_venda_inicio'])->toDateString());
        } elseif (!empty($filters['data_venda_fim'])) {
            $query->whereDate('sales.data_venda', '<=', Carbon::parse($filters['data_venda_fim'])->toDateString());
        }

        return $query->orderBy('vendedor_nome', 'ASC')->paginate(10)->appends($filters);
    }

    public static function findById($id)
    {
        return Sale::with(['client', 'vehicle', 'seller'])
            ->where('id', $id)
            ->first();
    }

    public static function getTotalValueOfSales(): ?Sale
    {
        return Sale::select(
            DB::raw('SUM(valor_total) as total_vendas'),
        )
            ->whereNull('deleted_at')
            ->first();
    }


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
