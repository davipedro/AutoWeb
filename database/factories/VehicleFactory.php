<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $brands = [
            'Fiat', 'Chevrolet', 'Volkswagen', 'Ford', 'Toyota', 'Honda', 'Hyundai', 'Renault', 'Nissan',
            'Jeep', 'Peugeot', 'Citroën', 'Mitsubishi', 'Kia', 'Suzuki', 'BMW', 'Mercedes-Benz', 'Audi',
            'Volvo', 'Land Rover', 'Subaru', 'Tesla', 'Chery', 'JAC Motors', 'Lexus', 'Mazda', 'Dodge',
            'Mini', 'Jaguar'
        ];

        $models = [
            'Uno', 'Palio', 'Punto', 'Strada', 'Toro', 'Onix', 'Prisma', 'Cruze', 'Spin', 'S10',
            'Gol', 'Voyage', 'Fusca', 'Fox', 'Tiguan', 'Jetta', 'Passat', 'Corolla', 'Yaris',
            'Hilux', 'Civic', 'City', 'HR-V', 'Fit', 'Renegade', 'Compass', '3008', 'C3', 'ASX',
            'Sportage', 'Sorento', 'X1', 'X3', 'A3', 'A4', 'XC60', 'Discovery', 'Impreza',
            'Model S', 'Model 3', 'Tiggo', 'iEV20', 'Jac T40', 'RX', 'CX-5', 'Challenger',
            'Cooper', 'XF'
        ];

        $transmissions = ['manual', 'automatica', 'cvt', 'auto_dupla_emb'];
        $fuelTypes = ['gasolina', 'etanol', 'flex', 'diesel', 'eletrico', 'hibrido', 'gnv', 'hidrogenio', 'alcool'];

        $valorCusto = $this->faker->randomFloat(2, 10000, 150000);

        return [
            'marca' => $this->faker->randomElement($brands),
            'modelo' => $this->faker->randomElement($models),
            'cor' => $this->faker->safeColorName(),
            'ano' => $this->faker->numberBetween(2000, 2024),
            'quilometragem' => $this->faker->numberBetween(0, 300000),
            'tipo_combustivel' => $this->faker->randomElement($fuelTypes),
            'transmissao' => $this->faker->randomElement($transmissions),
            'valor_custo' => $valorCusto,
            'valor_venda' => $valorCusto + rand(3000, 20000),
            'placa' => strtoupper($this->faker->unique()->bothify('???-####')),
            'chassi' => strtoupper($this->faker->unique()->bothify(str_repeat('#', 17))),
            'status_id' => function () {
                $statusIds = DB::table('status')
                    ->whereIn('nome', ['disponível', 'vendido', 'manutencao', 'indisponivel', 'reservado'])
                    ->pluck('id')
                    ->toArray();
                return $this->faker->randomElement($statusIds);
            },
            'observacoes' => $this->faker->optional()->sentence(),
        ];
    }
}
