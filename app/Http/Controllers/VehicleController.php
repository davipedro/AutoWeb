<?php

namespace App\Http\Controllers;

use App\Repositories\VehicleRepository;
use App\Models\Status;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $repository;

    public function __construct(VehicleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $response = $this->repository->getVehicles();
        $content = $response->getData();

        $veiculos = collect($content->data)->map(function ($veiculo) {
            $veiculo->valor_custo = number_format($veiculo->valor_custo, 2, ',', '.');
            $veiculo->valor_venda = number_format($veiculo->valor_venda, 2, ',', '.');
            $veiculo->ano = (string) $veiculo->ano;
            $veiculo->quilometragem = number_format($veiculo->quilometragem, 0, ',', '.');
            return $veiculo;
        });

        $veiculosArray = [
            'itens' => $veiculos,
            'count' => $content->count ?? 0,
        ];

        return view('vehicles.list', compact('veiculosArray'));
    }

    public function create()
    {
        $statusList = Status::all();
        return view('vehicles.add', compact('statusList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            'quilometragem' => 'required|numeric',
            'tipoCombustivel' => 'required|string',
            'valorCusto' => 'required|numeric',
            'valorVenda' => 'required|numeric',
            'chassi' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ]);

        $this->repository->create($validated);
        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $veiculo = $this->repository->find($id);
        $statusList = Status::all();
        return view('veiculos.edit', compact('veiculo', 'statusList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'marca' => 'required|string',
            'modelo' => 'required|string',
            'ano' => 'required|integer',
            'quilometragem' => 'required|numeric',
            'tipoCombustivel' => 'required|string',
            'valorCusto' => 'required|numeric',
            'valorVenda' => 'required|numeric',
            'chassi' => 'nullable|string',
            'status_id' => 'required|exists:status,id',
        ]);

        $this->repository->update($id, $validated);
        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function delete($id)
    {
        $this->repository->delete($id);
        return redirect()->route('veiculos.index')->with('success', 'Veículo removido com sucesso!');
    }
}
