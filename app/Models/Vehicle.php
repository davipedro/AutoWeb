<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vehicle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'marca',
        'modelo',
        'cor',
        'ano',
        'quilometragem',
        'tipo_combustivel',
        'transmissao',
        'valor_custo',
        'valor_venda',
        'chassi',
        'placa',
        'status_id',
        'observacoes',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
