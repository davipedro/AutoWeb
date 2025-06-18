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
    'unique' => 'O campo :attribute informado já está em uso por outro veículo.',

    'attributes' => [
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
        'observacoes' => 'observações',
    ],
];
