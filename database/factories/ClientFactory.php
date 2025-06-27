<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome_completo' => $this->faker->name,
            'data_nascimento' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail,
            'telefone' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'rg' => $this->faker->numerify('##.###.###-#'),
            'endereco' => $this->faker->streetAddress,
            'complemento' => $this->faker->optional()->secondaryAddress,
            'cidade' => $this->faker->city,
            'estado' => $this->faker->stateAbbr,
            'cep' => $this->faker->postcode,
            'observacoes' => $this->faker->optional()->text(100),
        ];
    }
}
