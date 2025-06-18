<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


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
        'placa',
        'chassi',
        'status_id',
        'observacoes',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public static function verifyInfo()
    {
        return [
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'cor' => 'required|string',
            'ano' => 'required|integer',
            'quilometragem' => 'required|numeric',
            'tipo_combustivel' => 'required|string',
            'transmissao' => 'required|string',
            'valor_custo' => 'required|numeric',
            'valor_venda' => 'required|numeric',
            'placa' => 'required|string|unique:vehicles,placa',
            'chassi' => 'nullable|string|unique:vehicles,chassi',
            'status_id' => 'required|exists:status,id',
            'observacoes' => 'nullable|string',
        ];
    }
}
