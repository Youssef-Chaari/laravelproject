<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CarUsedFactory extends Factory
{
    private static array $brands = [
        ['Renault', ['Clio', 'Megane', 'Laguna', 'Scenic']],
        ['Peugeot', ['206', '207', '307', '308']],
        ['Volkswagen', ['Golf', 'Polo', 'Passat']],
        ['Toyota', ['Yaris', 'Corolla', 'Avensis']],
        ['Ford', ['Fiesta', 'Focus', 'Mondeo']],
        ['Citroën', ['C3', 'C4', 'Picasso', 'Berlingo']],
        ['Dacia', ['Logan', 'Sandero', 'Duster']],
    ];

    public function definition(): array
    {
        [$brand, $models] = $this->faker->randomElement(self::$brands);

        return [
            'user_id'     => User::inRandomOrder()->value('id') ?? User::factory(),
            'brand'       => $brand,
            'model'       => $this->faker->randomElement($models),
            'year'        => $this->faker->numberBetween(2010, 2023),
            'price'       => $this->faker->numberBetween(15000, 250000),
            'mileage'     => $this->faker->numberBetween(10000, 200000),
            'description' => $this->faker->paragraph(2),
            'status'      => $this->faker->randomElement(['approved', 'approved', 'pending', 'rejected']),
        ];
    }
}
