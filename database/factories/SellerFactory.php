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
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'comissao' => $this->faker->randomFloat(4, 0, 1),
            'telefone' => $this->faker->phoneNumber,
            'observacoes' => $this->faker->optional()->text(100),
        ];
    }
}
