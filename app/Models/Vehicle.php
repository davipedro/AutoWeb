<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'marca',
        'modelo',
        'ano',
        'quilometragem',
        'tipo_combustivel',
        'valor_custo',
        'valor_venda',
        'chassi',
        'status_id',
        'observacoes',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
