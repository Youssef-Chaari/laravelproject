<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarNewFactory extends Factory
{
    private static array $brands = [
        ['Renault', ['Clio', 'Megane', 'Kadjar', 'Captur']],
        ['Peugeot', ['208', '308', '3008', '5008']],
        ['Volkswagen', ['Golf', 'Polo', 'Tiguan', 'Passat']],
        ['Toyota', ['Yaris', 'Corolla', 'RAV4', 'CHR']],
        ['BMW', ['Série 1', 'Série 3', 'X1', 'X3']],
        ['Mercedes', ['Classe A', 'Classe C', 'GLA', 'GLC']],
        ['Audi', ['A3', 'A4', 'Q3', 'Q5']],
        ['Hyundai', ['i10', 'i20', 'Tucson', 'Santa Fe']],
    ];

    public function definition(): array
    {
        [$brand, $models] = $this->faker->randomElement(self::$brands);

        return [
            'brand'        => $brand,
            'model'        => $this->faker->randomElement($models),
            'year'         => $this->faker->numberBetween(2020, 2025),
            'price'        => $this->faker->numberBetween(80000, 800000),
            'description'  => $this->faker->paragraph(3),
            'horsepower'   => $this->faker->numberBetween(75, 300),
            'fuel_type'    => $this->faker->randomElement(['essence', 'diesel', 'electrique', 'hybride']),
            'transmission' => $this->faker->randomElement(['manuelle', 'automatique']),
            'thumbnail'    => null,
        ];
    }
}
