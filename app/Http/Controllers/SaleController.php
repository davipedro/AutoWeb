<?php

namespace App\Http\Controllers;

use App\Enums\SalePaymentMethodEnum;
use App\Models\Seller;
use App\Repositories\SaleRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    public function createSale()
    {
        $sellersCommissions = Seller::pluck('comissao', 'cpf');

        $paymentMethods = SalePaymentMethodEnum::getAllMethods();
        $vehicles = \App\Models\Vehicle::where('status', 'disponível')->get();
        return view('sell.add', [
            'veiculos' => $vehicles,
            'metodosPagamento' => $paymentMethods,
            'porcentagemComissao' => $sellersCommissions,
        ]);
    }

    public function storeSale(Request $request)
    {
        $validated = $request->validate([
            'cpf' => 'required|string|size:14',
            'rg' => 'nullable|string|max:20',
            'nome_completo' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'telefone' => 'required|string',
            'data_nascimento' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'required|string|max:100',
            'estado' => 'required|string|size:2',
            'cep' => ['nullable', 'string', 'size:9', 'regex:/^\d{5}-\d{3}$/'],
            'veiculo' => 'required|exists:vehicles,id',
            'vendedor_cpf' => 'required|string|size:14',
            'data_venda' => 'required|date',
            'valor_venda' => 'required|numeric|min:0',
            'metodo_pagamento' => ['required', Rule::in(SalePaymentMethodEnum::getAllMethods())],
            'valor_comissao' => 'required|numeric|min:0',
        ]);

        dd($validated);
        try {
            SaleRepository::create($validated);
            return redirect()->route('admin.sell.add')->with('success', 'Venda cadastrada com sucesso!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage())->withInput();
        }
    }

    public function showSell(string $id)
    {
        //
    }

    public function editSell(string $id)
    {
        //
    }

    public function updateSell(Request $request, string $id)
    {
        //
    }

    public function destroySell(string $id)
    {
        //
    }
}
