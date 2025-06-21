<?php

namespace App\Repositories;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Models\Status;

class VehicleRepository
{
    public function all()
    {
        return Vehicle::with('status')->get();
    }

    public static function find($id)
    {
        return Vehicle::with('status')->withTrashed()->find($id);
    }

    public static function create(array $data)
    {
        return Vehicle::create($data);
    }

    public static function update($id, array $data)
    {
        $veiculo = Vehicle::withTrashed()->findOrFail($id);
        $veiculo->update($data);
    }

    public static function delete($id)
    {
        $veiculo = Vehicle::findOrFail($id);

        // Busca o status com nome "inativo"
        $statusInativo = Status::where('nome', 'inativo')->first();

        if (!$statusInativo) {
            throw new \Exception('Status "inativo" não encontrado. Verifique a tabela status.');
        }

        $veiculo->status_id = $statusInativo->id;
        $veiculo->save();

        return $veiculo->delete();
    }

    public static function getVehicles()
    {
        $vehicles = DB::table('vehicles')
            ->join('status', 'vehicles.status_id', '=', 'status.id')
            ->select(
                'vehicles.*',
                DB::raw('status.nome as status_nome')
            )
            ->whereNull('vehicles.deleted_at')
            ->orderBy('vehicles.marca', 'ASC')
            ->paginate(10);

        return $vehicles;
    }

    public static function getVehiclesCatalog()
    {
        $vehicles = DB::table('vehicles')
            ->join('status', 'vehicles.status_id', '=', 'status.id')
            ->select(
                'vehicles.*',
                DB::raw('status.nome as status_nome')
            )
            ->whereNull('vehicles.deleted_at')
            ->orderBy('vehicles.marca', 'ASC')
            ->get();

        return $vehicles;
    }

    public static function existsPlaca($placa, $ignoreId = null)
    {
        $query = Vehicle::where('placa', $placa);

        if ($ignoreId) {
            $query->where('id', '!==', $ignoreId);
        }

        return $query->exists();
    }

    public static function existsChassi($chassi, $ignoreId = null)
    {
        $query = Vehicle::where('chassi', $chassi);

        if ($ignoreId) {
            $query->where('id', '!==', $ignoreId);
        }

        return $query->exists();
    }
}
