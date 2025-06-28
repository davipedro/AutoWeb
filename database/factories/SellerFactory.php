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
            'telefone' => $this->faker->phoneNumber,
            'salario' => $this->faker->randomFloat(2, 1000, 10000),
            'data_admissao' => $this->faker->date(),
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'rg' => $this->faker->numerify('##.###.###-#'),
            'endereco' => $this->faker->streetAddress,
            'complemento' => $this->faker->word(),
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'comissao' => $this->faker->randomFloat(4, 0, 1),
            'observacoes' => $this->faker->optional()->text(100),
        ];
    }
}
