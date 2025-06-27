<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data_venda' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'valor_total' => $this->faker->randomFloat(2, 1000, 50000),
            'comissao' => $this->faker->randomFloat(2, 50, 5000),
            'metodo_pagamento' => $this->faker->randomElement(['Cartão de Crédito', 'Dinheiro', 'Transferência Bancária']),
            'vendedor_id' => \App\Models\Seller::factory(),
            'cliente_id' => \App\Models\Client::factory(),
            'veiculo_id' => \App\Models\Vehicle::inRandomOrder()->first()->id, // Assumindo que o modelo Vehicle tem um factory configurado
        ];
    }
}
