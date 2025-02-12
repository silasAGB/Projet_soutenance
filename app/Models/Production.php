<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model


{
    use HasFactory;

    protected $primaryKey = 'id_production';

    protected $fillable = [
        'reference_production',
        'date_prevue',
        'heure_prevue',
        'qte_prevue',
        'qte_produite',
        'nbr_preparation',
        'date_production',
        'heure_production',
        'nom_personnel',
        'consignes_specifiques',
        'autres_remarques',
        'montant_produit',
        'statut',
        'id_produit',
        'avaries',
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }

    public function matieresPremieres()
{
    return $this->belongsToMany(MatierePremiere::class, 'production_matiere_premiere', 'id_produit', 'id_MP')
                ->withPivot('qte')
                ->withTimestamps();
}

public function mouvements()
   {
       return $this->hasMany(MouvementProduit::class, 'id_production');
   }

protected static function boot()
    {
        parent::boot();

        static::deleting(function ($production) {
            $production->matieresPremieres()->detach();
        });
    }
}
