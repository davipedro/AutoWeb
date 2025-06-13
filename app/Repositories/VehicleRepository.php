<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;

class VehicleRepository
{
    public function all()
    {
        return Vehicle::with('status')->get();
    }

    public function find($id)
    {
        return Vehicle::with('status')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Vehicle::create($data);
    }

    public function update($id, array $data)
    {
        $veiculo = $this->find($id);
        $veiculo->update($data);
        return $veiculo;
    }

    public function delete($id)
    {
        return Vehicle::destroy($id);
    }

    public function getVehicles()
    {
        $vehicles = DB::table('vehicles')
            ->join('status', 'vehicles.status_id', '=', 'status.id')
            ->select(
                'vehicles.id',
                'vehicles.marca',
                'vehicles.modelo',
                'vehicles.ano',
                'vehicles.quilometragem',
                'vehicles.valor_custo',
                'vehicles.valor_venda',
                'vehicles.tipo_combustivel',
                DB::raw('status.nome as status_nome'),
                DB::raw('COUNT(*) OVER() as total_count')
            )
            ->get();

        return response()->json([
            'data' => $vehicles,
            'count' => $vehicles->first()->total_count ?? 0
        ]);
    }
}
