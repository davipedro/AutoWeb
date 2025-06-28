<?php

namespace App\Models;

use App\Enums\SalePaymentMethodEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Sale extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'data_venda',
        'valor_total',
        'comissao',
        'metodo_pagamento',
        'vendedor_id',
        'cliente_id',
        'veiculo_id',
        'observacoes',
    ];

    protected $casts = [
        'metodo_pagamento' => SalePaymentMethodEnum::class,
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'vendedor_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'veiculo_id');
    }

    public static function verifyInfo()
    {

        $inactiveStatusId = Status::where('nome', 'inativo')->value('id');

        return [
            'cliente_id' => [
                'required',
                Rule::exists('clients', 'id')->whereNull('deleted_at'),
            ],
            'vendedor_id' => [
                'required',
                Rule::exists('sellers', 'id')->whereNull('deleted_at'),
            ],
            'veiculo_id' => [
                'required',
                Rule::exists('vehicles', 'id')
                    ->whereNull('deleted_at')
                    ->where('status_id', '!=', $inactiveStatusId),
            ],
            'data_venda'   => ['required', 'date'],
            'metodo_pagamento' => ['required', 'string'],
            'valor_total'  => ['required', 'string'],
            'comissao'     => ['required', 'string'],
            'observacoes'  => ['nullable', 'string'],
        ];
    }
}
