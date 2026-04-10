<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ForumTopicFactory extends Factory
{
    private static array $topics = [
        'Quelle est la meilleure voiture électrique en 2025 ?',
        'Conseils pour acheter une voiture d\'occasion',
        'Comparatif : Essence vs Diesel vs Hybride',
        'Entretien moteur : les erreurs à éviter',
        'Les meilleures routes du Maroc à découvrir',
        'Assurance auto : comment choisir ?',
        'Pneus été vs pneus hiver au Maroc',
        'Mon expérience avec la Dacia Duster 2024',
        'Où faire réviser sa voiture à Casablanca ?',
        'Quels sont les meilleurs garages de confiance ?',
    ];

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'title'   => $this->faker->randomElement(self::$topics) . ' ' . $this->faker->emoji(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
