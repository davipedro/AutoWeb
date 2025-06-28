<?php

namespace App\Repositories;

use App\Enums\VehicleStatusEnum;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use App\Models\Status;

class VehicleRepository
{
    public function all()
    {
        return Vehicle::all();
    }

    public static function find($id)
    {
        return Vehicle::withTrashed()->find($id);
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
        $veiculo->status = VehicleStatusEnum::Inactive->value;
        $veiculo->save();

        return $veiculo->delete();
    }

    public static function getVehiclesCatalog()
    {
        $vehicles = DB::table('vehicles')
            ->select('vehicles.*',)
            ->where('status', '=', VehicleStatusEnum::Available->value)
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

    public static function getFilteredVehicles(array $filters = [])
    {
        $query = DB::table('vehicles')
            ->select('vehicles.*',)
            ->whereNull('vehicles.deleted_at')
            ->where('vehicles.status', '!=', VehicleStatusEnum::Inactive->value);

        // Filtros
        if (!empty($filters['modelo'])) {
            $query->where(DB::raw('LOWER(CONCAT(vehicles.marca, " ", vehicles.modelo))'),
                'like', '%' . strtolower($filters['modelo']) . '%');
        }

        if (!empty($filters['marca'])) {
            $query->where(DB::raw('LOWER(vehicles.marca)'), '=', strtolower($filters['marca']));
        }

        if (!empty($filters['ano'])) {
            $query->where('vehicles.ano', '=', $filters['ano']);
        }

        if (!empty($filters['status'])) {
            $query->where('vehicles.status', '=', $filters['status']);
        }

        return $query->orderBy('vehicles.marca', 'ASC')->paginate(10)->appends($filters);
    }

    public static function getAllMarcas()
    {
        return Vehicle::whereNull('deleted_at')
            ->select('marca')
            ->distinct()
            ->orderByRaw('LOWER(marca)')
            ->pluck('marca');
    }

    public static function getAllAnos()
    {
        return Vehicle::whereNull('deleted_at')
            ->select('ano')
            ->distinct()
            ->orderByDesc('ano')
            ->pluck('ano');
    }

    public static function getNumberOfAvailableVehicles()
    {
        return Vehicle::whereNull('deleted_at')
            ->where('status', '=', VehicleStatusEnum::Available->value)
            ->count();
    }
}
