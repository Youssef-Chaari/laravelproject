<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';

    protected $fillable = [
        'marque_id',
        'modele',
        'slug',
        'annee',
        'prix',
        'carburant',
        'puissance',
        'couple',
        'transmission',
        'consommation',
        'nb_portes',
        'nb_places',
        'volume_coffre',
        'couleur',
        'couleur_bg',
        'kilometrage',
        'garantie',
        'description',
        'equipements',
    ];

    protected $casts = [
        'prix'          => 'decimal:2',
        'annee'         => 'integer',
        'puissance'     => 'integer',
        'kilometrage'   => 'integer',
        'equipements'   => 'array',
    ];

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }
}
