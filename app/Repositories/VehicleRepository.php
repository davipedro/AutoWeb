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

    public static function getFilteredVehicles(array $filters = [])
    {
        $query = DB::table('vehicles')
            ->join('status', 'vehicles.status_id', '=', 'status.id')
            ->select(
                'vehicles.*',
                DB::raw('status.nome as status_nome')
            )
            ->whereNull('vehicles.deleted_at');

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
            $query->where(DB::raw('LOWER(status.nome)'), '=', strtolower($filters['status']));
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

    public static function getAllStatusNomes()
    {
        return Status::orderBy('nome')->pluck('nome');
    }
}
