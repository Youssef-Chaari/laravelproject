<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'annonces';

    protected $fillable = [
        'user_id',
        'marque_id',
        'titre',
        'modele',
        'annee',
        'kilometrage',
        'prix',
        'carburant',
        'transmission',
        'puissance',
        'description',
        'ville',
        'telephone',
        'statut',
    ];

    protected $casts = [
        'prix'        => 'decimal:2',
        'annee'       => 'integer',
        'kilometrage' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function getVendeurPrenomAttribute()
    {
        return $this->user?->first_name ?? explode(' ', $this->user?->name ?? 'Vendeur')[0];
    }

    public function getVendeurNomAttribute()
    {
        $parts = explode(' ', $this->user?->name ?? 'V');
        return $parts[1] ?? $parts[0];
    }

    public function getDateRelativeAttribute()
    {
        return $this->created_at?->diffForHumans() ?? '';
    }

    public function scopePublished($query)
    {
        return $query->where('statut', 'publie');
    }
}
