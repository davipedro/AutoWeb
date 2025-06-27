<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'comissao' => $this->faker->randomFloat(2, 50, 5000),
            'telefone' => $this->faker->phoneNumber,
            'observacoes' => $this->faker->optional()->text(100),
        ];
    }
}
