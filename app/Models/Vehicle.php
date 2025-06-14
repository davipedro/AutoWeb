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
        'chassi',
        'placa',
        'status_id',
        'observacoes',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public static function getVehicles()
    {
        $vehicles = DB::table('vehicles')
            ->join('status', 'vehicles.status_id', '=', 'status.id')
            ->select(
                'vehicles.*',
                DB::raw('status.nome as status_nome'),
                DB::raw('COUNT(*) OVER() as total_count')
            )
            ->whereNull('vehicles.deleted_at')
            ->get();


        return response()->json([
            'data' => $vehicles,
            'count' => $vehicles->first()->total_count ?? 0
        ]);
    }

    public static function deleteVehicle($id)
    {
        return Vehicle::destroy($id);
    }
}
