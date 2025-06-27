<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'data_venda',
        'valor_total',
        'comissao',
        'metodo_pagamento',
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
}
