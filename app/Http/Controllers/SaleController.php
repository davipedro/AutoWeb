<?php

namespace App\Http\Controllers;

use App\Enums\VehicleStatusEnum;
use App\Models\Sale;
use App\Models\Seller;
use App\Models\Status;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\SaleRepository;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function indexAdmin(Request $request)
    {

        $filters = $request->only(['nome_cliente', 'data_venda_inicio', 'data_venda_fim']);
        $filtrosAtivos = collect($filters)->filter()->isNotEmpty();

        $vendas = SaleRepository::getFilteredSale($filters);

        $clientesDisponiveis = ClientController::getAvailableClients();

        $collection = $vendas->getCollection();

        if ($filtrosAtivos) {
            // Com filtro → extrai apenas das opções filtradas
            $collection = $vendas->getCollection();
        }

        return view('sales.list', compact('vendas', 'filters', 'clientesDisponiveis'));
    }

    public function indexSeller(Request $request)
    {

        $userId = auth()->user()->id;
        $vendedorId = Seller::where('user_id', $userId)->value('id');

        $filters = $request->only(['nome_cliente', 'data_venda_inicio', 'data_venda_fim']);
        $filtrosAtivos = collect($filters)->filter()->isNotEmpty();

        $vendas = SaleRepository::getFilteredSale($filters, $vendedorId);

        $clientesDisponiveis = ClientController::getAvailableClients();

        $collection = $vendas->getCollection();

            if ($filtrosAtivos) {
                // Com filtro → extrai apenas das opções filtradas
                $collection = $vendas->getCollection();
            }

        return view('sales.list', compact('vendas', 'filters', 'clientesDisponiveis'));
    }

    public function createSale()
    {
        $vendedoresDisponiveis = SellerController::getSellers();

        $clientesDisponiveis = ClientController::getAvailableClients();

        $veiculosDisponiveis = VehicleController::getVehicles();

        if ($vendedoresDisponiveis->isEmpty()) {
            return redirect()->route('admin.vendas.list')->with('error', 'Não há vendedores disponíveis para vincular a venda.');
        } elseif ($clientesDisponiveis->isEmpty()) {
            return redirect()->route('admin.vendas.list')->with('error', 'Não há clientes disponíveis para vincular a venda.');
        } else {
            return view('sales.add', [
                'vendedores' => $vendedoresDisponiveis,
                'clientes' => $clientesDisponiveis,
                'veiculos' => $veiculosDisponiveis
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateData($request);

            $validated['valor_total'] = $this->sanitizeMoney($validated['valor_total']);
            $validated['comissao'] = $this->sanitizeMoney($validated['comissao']);

            $id = SaleRepository::create($validated);

            $veiculo = Vehicle::find($validated['veiculo_id']);
            $veiculo = Vehicle::find($validated['veiculo_id']);

            if ($veiculo) {
                $veiculo->status = VehicleStatusEnum::Sold->value;
                $veiculo->save();
            }

            return redirect()->route(auth()->user()->role .'.vendas.list')->with('success', 'Venda cadastrada com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar venda: ' . $e->getMessage())->withInput();
        }
    }



    protected function validateData(Request $request)
    {
        $rules = Sale::verifyInfo();

        try {
            return Validator::make($request->all(), $rules)->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->validator->errors()->all());
        }
    }

    private function sanitizeMoney(string $valor): float
    {
        // Remove tudo que não for número ou vírgula
        $limpo = preg_replace('/[^\d,]/', '', $valor); // Ex: "R$ 45.000,84" → "45000,84"

        // Troca vírgula por ponto
        $limpo = str_replace(',', '.', $limpo); // "45000,84" → "45000.84"

        return (float) $limpo; // Converte para número decimal (float)
    }

    public function deleteSale($id)
    {
        try {
            // Busca a venda para recuperar o veículo associado
            $venda = SaleRepository::findById($id);

            if ($venda && $venda->veiculo_id) {
                // Atualiza o status do veículo para "disponível"
                $veiculo = Vehicle::find($venda->veiculo_id);
                if ($veiculo) {
                    $veiculo->status = VehicleStatusEnum::Available->value;
                    $veiculo->save();
                }
            }

            // Deleta a venda
            SaleRepository::delete($id);

            return redirect()->route(auth()->user()->role . '.vendas.list')
                ->with('success', 'Venda removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao remover venda: ' . $e->getMessage());
        }
    }


    public function editSale($id)
    {
        $venda = Sale::findOrFail($id);

        $vendedoresDisponiveis = SellerController::getSellers();
        $clientesDisponiveis = ClientController::getAvailableClients();
        $veiculosDisponiveis = VehicleController::getVehicles($venda->veiculo_id);

        return view('sales.edit', [
            'venda' => $venda,
            'vendedores' => $vendedoresDisponiveis,
            'clientes' => $clientesDisponiveis,
            'veiculos' => $veiculosDisponiveis
        ]);
    }

    public function updateSale(Request $request, $id)
    {
        try {
            $validated = $this->validateData($request);

            $validated['valor_total'] = $this->sanitizeMoney($validated['valor_total']);
            $validated['comissao'] = $this->sanitizeMoney($validated['comissao']);

            // Busca a venda original
            $venda = Sale::findOrFail($id);
            $veiculoAntigoId = $venda->veiculo_id;

            // Atualiza os dados da venda
            SaleRepository::update($id, $validated);

            // Atualiza status dos veículos
            if ($veiculoAntigoId != $validated['veiculo_id']) {
                // Antigo volta para disponível
                if ($veiculoAntigo = Vehicle::find($veiculoAntigoId)) {
                    $veiculoAntigo->status = VehicleStatusEnum::Available->value;
                    $veiculoAntigo->save();
                }
            }

            // Novo fica como vendido
            if ($veiculoNovo = Vehicle::find($validated['veiculo_id'])) {
                $veiculoNovo->status = VehicleStatusEnum::Sold->value;
                $veiculoNovo->save();
            }

            return redirect()->route(auth()->user()->role . '.vendas.list')->with('success', 'Venda atualizada com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar venda: ' . $e->getMessage())->withInput();
        }
    }

    public static function getSales($dataInicio = null, $dataFim = null , $vendedor = null)
    {
        $userId = auth()->user()->id;
        $vendedorId = Seller::where('user_id', $userId)->value('id');

        $filters = [
            'data_venda_inicio' => $dataInicio,
            'data_venda_fim' => $dataFim,
        ];

        if (auth()->user()->role === 'admin') {
            return SaleRepository::getFilteredSale($filters, $vendedor);
        } else {
            return SaleRepository::getFilteredSale([], $vendedorId);
        }
    }

    public static function getTotalSalesBySeller($sellerId)
    {
        return SaleRepository::getFilteredSale([], $sellerId);
    }

    public static function getTotalValueOfSales()
    {
        return SaleRepository::getTotalValueOfSales();
    }

}
