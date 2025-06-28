<?php

namespace App\Models;

use App\Enums\DashboardPeriodEnum;
use App\Repositories\SaleRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Seller extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'sellers';
    protected $fillable = [
        'user_id',
        'telefone',
        'salario',
        'data_admissao',
        'cpf',
        'rg',
        'endereco',
        'complemento',
        'cidade',
        'estado',
        'cep',
        'comissao',
        'observacoes',
    ];

    public static function getCommissionPercentage($userId): float
    {
        $seller = self::where('user_id', $userId)->first();
        return $seller ? $seller->comissao : 0.0;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'seller_id');
    }

    /**
     * Orquestra a busca e formatação dos dados para o dashboard deste vendedor.
     *
     * @return array
     */
    /**
     * Orquestra a busca de dados do dashboard com base em um objeto Carbon.
     *
     * @param int    $userId O ID do usuário/vendedor.
     * @param Carbon $periodDate Um objeto Carbon que representa o período desejado (geralmente o início dele).
     * @return array
     */
    public static function getDashboardData(int $userId, string $period): array
    {
        $periodDate = DashboardPeriodEnum::getDateRange($period);

        [$startDate, $endDate] = $periodDate;

        $salesCount = SaleRepository::getSalesCountForSeller($userId, $startDate, $endDate);
        $totalSalesValue = SaleRepository::getTotalValueSoldForSeller($userId, $startDate, $endDate);
        $accumulatedCommissions = SaleRepository::getAccumulatedCommissionsForSeller($userId, $startDate, $endDate);

        $paginatedSales = SaleRepository::getPaginatedSalesForSeller($userId, $startDate, $endDate);

        return [
            'salesCount'             => $salesCount,
            'totalSalesValue'        => $totalSalesValue,
            'accumulatedCommissions' => $accumulatedCommissions,
            'sales'                  => $paginatedSales,
        ];
    }

    public static function verifyInfo($id = null, $userId = null)
    {
        $today = now()->format('Y-m-d');
        $minDate = now()->subYears(18)->format('Y-m-d');

        return [
            'user_id'           => 'required|exists:users,id',
            'telefone'          => 'required|string|max:20',
            'salario'           => 'nullable|numeric|min:0',
            'data_admissao'     => "required|date|before_or_equal:$today|after_or_equal:$minDate",
            'cpf'               => ['required', 'string', 'size:11', Rule::unique('sellers')->ignore($id)],
            'rg'                => 'nullable|string',
            'endereco'          => 'nullable|string|max:255',
            'complemento'       => 'nullable|string|max:100',
            'cidade'            => 'required|string|max:100',
            'estado'            => 'required|string|size:2',
            'cep'               => ['nullable', 'string', 'min:8'],
            'comissao'          => ['nullable', 'numeric', 'min:0'],
            'observacoes'       => 'nullable|string|max:1000',
        ];
    }

    public static function getDashboardData(int $userId, string $period): array
    {
        $periodDate = DashboardPeriodEnum::getDateRange($period);

        [$startDate, $endDate] = $periodDate;

        $salesCount = SaleRepository::getSalesCountForSeller($userId, $startDate, $endDate);
        $totalSalesValue = SaleRepository::getTotalValueSoldForSeller($userId, $startDate, $endDate);
        $accumulatedCommissions = SaleRepository::getAccumulatedCommissionsForSeller($userId, $startDate, $endDate);

        $paginatedSales = SaleRepository::getPaginatedSalesForSeller($userId, $startDate, $endDate);

        return [
            'salesCount'             => $salesCount,
            'totalSalesValue'        => $totalSalesValue,
            'accumulatedCommissions' => $accumulatedCommissions,
            'sales'                  => $paginatedSales,
        ];
    }
}
