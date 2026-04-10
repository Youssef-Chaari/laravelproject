<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Marque;
use App\Models\Vehicule;
use App\Models\ForumTopic;
use App\Models\Annonce;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────────────────────
        User::firstOrCreate(['email' => 'admin@automoto.fr'], [
            'name'     => 'Admin AutoMoto',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'statut'   => 'actif',
        ]);

        // ── Demo user ─────────────────────────────────────────────────────────
        $user = User::firstOrCreate(['email' => 'jean.dupont@example.com'], [
            'name'     => 'Jean Dupont',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'statut'   => 'actif',
        ]);

        // ── Marques ───────────────────────────────────────────────────────────
        $marquesData = [
            ['nom' => 'Toyota',   'slug' => 'toyota',   'pays' => 'Japon',      'couleur' => '#EF4444'],
            ['nom' => 'BMW',      'slug' => 'bmw',      'pays' => 'Allemagne',  'couleur' => '#2563EB'],
            ['nom' => 'Mercedes', 'slug' => 'mercedes', 'pays' => 'Allemagne',  'couleur' => '#1F2937'],
            ['nom' => 'Renault',  'slug' => 'renault',  'pays' => 'France',     'couleur' => '#F59E0B'],
            ['nom' => 'Peugeot',  'slug' => 'peugeot',  'pays' => 'France',     'couleur' => '#2563EB'],
            ['nom' => 'Audi',     'slug' => 'audi',     'pays' => 'Allemagne',  'couleur' => '#111827'],
            ['nom' => 'Ford',     'slug' => 'ford',     'pays' => 'États-Unis', 'couleur' => '#2563EB'],
            ['nom' => 'Volkswagen','slug' => 'volkswagen','pays' => 'Allemagne','couleur' => '#1D4ED8'],
        ];

        foreach ($marquesData as $data) {
            Marque::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // ── Vehicules ─────────────────────────────────────────────────────────
        $vehiculesData = [
            ['marque_slug' => 'toyota',   'modele' => 'Corolla', 'annee' => 2024, 'prix' => 25990, 'carburant' => 'hybride',    'puissance' => 140, 'couleur_bg' => 'linear-gradient(135deg,#EF4444,#B91C1C)'],
            ['marque_slug' => 'toyota',   'modele' => 'Yaris',   'annee' => 2023, 'prix' => 19990, 'carburant' => 'hybride',    'puissance' => 116, 'couleur_bg' => 'linear-gradient(135deg,#F97316,#C2410C)'],
            ['marque_slug' => 'bmw',      'modele' => 'Série 3', 'annee' => 2024, 'prix' => 48900, 'carburant' => 'diesel',     'puissance' => 190, 'couleur_bg' => 'linear-gradient(135deg,#3B82F6,#1D4ED8)'],
            ['marque_slug' => 'bmw',      'modele' => 'X5',      'annee' => 2023, 'prix' => 72000, 'carburant' => 'essence',    'puissance' => 340, 'couleur_bg' => 'linear-gradient(135deg,#6366F1,#4338CA)'],
            ['marque_slug' => 'renault',  'modele' => 'Clio',    'annee' => 2024, 'prix' => 18990, 'carburant' => 'essence',    'puissance' => 90,  'couleur_bg' => 'linear-gradient(135deg,#F59E0B,#D97706)'],
            ['marque_slug' => 'peugeot',  'modele' => '208',     'annee' => 2024, 'prix' => 21490, 'carburant' => 'electrique', 'puissance' => 136, 'couleur_bg' => 'linear-gradient(135deg,#8B5CF6,#6D28D9)'],
            ['marque_slug' => 'mercedes', 'modele' => 'Classe C', 'annee' => 2024,'prix' => 52800, 'carburant' => 'essence',    'puissance' => 204, 'couleur_bg' => 'linear-gradient(135deg,#374151,#1F2937)'],
            ['marque_slug' => 'volkswagen','modele' => 'Golf',   'annee' => 2023, 'prix' => 29990, 'carburant' => 'diesel',     'puissance' => 150, 'couleur_bg' => 'linear-gradient(135deg,#2563EB,#1D4ED8)'],
        ];

        foreach ($vehiculesData as $v) {
            $marque = Marque::where('slug', $v['marque_slug'])->first();
            if (!$marque) continue;

            Vehicule::firstOrCreate(
                ['marque_id' => $marque->id, 'modele' => $v['modele'], 'annee' => $v['annee']],
                [
                    'slug'        => Str::slug($v['modele'] . '-' . $v['annee']),
                    'prix'        => $v['prix'],
                    'carburant'   => $v['carburant'],
                    'puissance'   => $v['puissance'],
                    'couple'      => rand(150, 400),
                    'transmission'=> 'manuelle',
                    'consommation'=> round(rand(40, 80) / 10, 1),
                    'nb_portes'   => 5,
                    'nb_places'   => 5,
                    'volume_coffre' => rand(280, 520),
                    'couleur'     => 'Blanc',
                    'couleur_bg'  => $v['couleur_bg'],
                    'kilometrage' => 0,
                    'garantie'    => 3,
                    'description' => 'Un véhicule exceptionnel alliant confort et performance.',
                    'equipements' => ['Climatisation', 'GPS', 'Caméra de recul', 'Bluetooth', 'Régulateur de vitesse'],
                ]
            );
        }

        // ── Forum topics ──────────────────────────────────────────────────────
        if (ForumTopic::count() === 0) {
            $topics = [
                ['title' => 'Quelle est la meilleure voiture hybride en 2024 ?', 'categorie' => 'questions', 'content' => 'Je recherche une hybride fiable et économique pour un usage mixte ville/autoroute.'],
                ['title' => 'Mon avis sur la Toyota Yaris hybride après 1 an', 'categorie' => 'avis', 'content' => 'Après 12 mois et 18 000 km, voici mon retour d\'expérience complet...'],
                ['title' => 'Conseils pour entretien BMW Série 3 Diesel', 'categorie' => 'conseils', 'content' => 'Quelques conseils pour maintenir votre BMW en parfait état.'],
            ];

            foreach ($topics as $t) {
                ForumTopic::create([
                    'user_id'   => $user->id,
                    'title'     => $t['title'],
                    'content'   => $t['content'],
                    'categorie' => $t['categorie'],
                ]);
            }
        }

        // ── Annonces occasions ────────────────────────────────────────────────
        if (Annonce::count() === 0) {
            $renault = Marque::where('slug', 'renault')->first();
            $peugeot = Marque::where('slug', 'peugeot')->first();

            if ($renault) {
                Annonce::create([
                    'user_id'     => $user->id,
                    'marque_id'   => $renault->id,
                    'titre'       => 'Renault Clio 2020 – Très bon état',
                    'modele'      => 'Clio',
                    'annee'       => 2020,
                    'kilometrage' => 45000,
                    'prix'        => 13500,
                    'carburant'   => 'essence',
                    'description' => 'Voiture en parfait état, entretien régulier, carnet de service complet.',
                    'ville'       => 'Paris',
                    'telephone'   => '06 12 34 56 78',
                    'statut'      => 'publie',
                ]);
            }

            if ($peugeot) {
                Annonce::create([
                    'user_id'     => $user->id,
                    'marque_id'   => $peugeot->id,
                    'titre'       => 'Peugeot 208 2021 – Faible kilométrage',
                    'modele'      => '208',
                    'annee'       => 2021,
                    'kilometrage' => 28000,
                    'prix'        => 16900,
                    'carburant'   => 'diesel',
                    'description' => 'Première main, non fumeur, toutes options.',
                    'ville'       => 'Lyon',
                    'telephone'   => '06 98 76 54 32',
                    'statut'      => 'publie',
                ]);
            }
        }
    }
}
