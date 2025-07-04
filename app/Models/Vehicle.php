<?php

namespace App\Models;

use App\Enums\VehicleStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;


class Vehicle extends Model
{
    use SoftDeletes;

    use HasFactory;
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
        'status',
        'observacoes',
    ];

    protected $casts = [
        'status' => VehicleStatusEnum::class,
    ];

    public static function verifyInfo($id = null)
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
            'placa' => ['required', 'string', Rule::unique('vehicles')->ignore($id)],
            'chassi' => ['nullable', 'string', Rule::unique('vehicles')->ignore($id)],
            'status' => ['required', new Enum(VehicleStatusEnum::class)],
            'observacoes' => 'nullable|string',
        ];
    }
}
