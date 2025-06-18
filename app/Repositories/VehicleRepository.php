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

    public function find($id)
    {
        return Vehicle::with('status')->findOrFail($id);
    }

    public static function create(array $data)
    {
        return Vehicle::create($data);
    }

    public function update($id, array $data)
    {
        $veiculo = $this->find($id);
        $veiculo->update($data);
        return $veiculo;
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

    public static function existsPlaca(string $placa): bool
    {
        $placa = strtoupper(trim($placa));
        return Vehicle::whereRaw('UPPER(TRIM(placa)) = ?', [$placa])->exists();
    }

    public static function existsChassi(string $chassi): bool
    {
        $chassi = strtoupper(trim($chassi));
        return Vehicle::whereRaw('UPPER(TRIM(chassi)) = ?', [$chassi])->exists();
    }
}
