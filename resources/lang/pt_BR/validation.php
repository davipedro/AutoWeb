<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um e-mail válido.',
    'min' => [
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
    ],
    'max' => [
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
    ],
    'unique' => 'O valor :attribute informado já está em uso.',

    'attributes' => [
        //Veiculos
        'marca' => 'marca',
        'modelo' => 'modelo',
        'ano' => 'ano',
        'quilometragem' => 'quilometragem',
        'tipo_combustivel' => 'combustível',
        'cor' => 'cor',
        'valor_custo' => 'valor de custo',
        'valor_venda' => 'valor de venda',
        'placa' => 'placa',
        'chassi' => 'chassi',
        'status' => 'status',

        //Clientes
        'nome_completo' => 'nome do cliente',
        'data_nascimento' => 'data de nascimento',
        'email' => 'e-mail',
        'telefone' => 'telefone',
        'cpf' => 'CPF',
        'rg' => 'RG',
        'endereco' => 'endereço',
        'complemento' => 'complemento',
        'cidade' => 'cidade',
        'estado' => 'estado',
        'cep' => 'CEP',

        //Vendas
        'cliente_id' => 'cliente',
        'veiculo_id' => 'veículo',
        'vendedor_id' => 'vendedor',
        'valor_venda' => 'valor da venda',
        'data_venda' => 'data da venda',
        'forma_pagamento' => 'forma de pagamento',

        'observacoes' => 'observações',
    ],
];
