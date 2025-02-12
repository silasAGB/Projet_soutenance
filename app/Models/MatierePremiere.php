<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatierePremiere extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_MP';

    protected $fillable = [
        'nom_MP',
        'prix_achat',
        'unite',
        'qte_stock',
        'stock_min',
        'emplacement',
        'id_categorie'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'matiere_produit', 'id_MP', 'id_produit')
                    ->withPivot('qte')
                    ->withTimestamps();
    }

    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_mat', 'id_MP', 'id_fournisseur')
                    ->withPivot('prix_achat')
                    ->withTimestamps();
    }

    public function approvisionnements()
    {
        return $this->belongsToMany(Approvisionnement::class, 'approvisionnement_matiere_premiere', 'id_MP', 'id_approvisionnement')
                    ->withPivot('id_fournisseur', 'qte_approvisionnement', 'montant')
                    ->withTimestamps();
    }

    public function productions()
{
    return $this->belongsToMany(Production::class, 'id_MP', 'id_production')
                ->using(ProductionMatierePremiere::class)
                ->withPivot('qte')
                ->withTimestamps();
}

public function mouvements()
{
    return $this->hasMany(MouvementMp::class, 'id_MP');
}
}
