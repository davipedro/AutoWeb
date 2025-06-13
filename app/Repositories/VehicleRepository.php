<?php

namespace App\Repositories;

use App\Models\Vehicle;

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

    public function count()
    {
        return Vehicle::count();
    }
}
