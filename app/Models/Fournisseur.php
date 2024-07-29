<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_fournisseur';

    protected $fillable = [
        'nom_fournisseur',
        'contact_fournisseur',
        'email_fournisseur',
        'adresse_fournisseur'
    ];

    public function approvisionnements()
    {
        return $this->belongsToMany(Approvisionnement::class, 'approvisionnement_matiere_premiere', 'id_fournisseur', 'id_approvisionnement')
                    ->withPivot('id_MP', 'qte_approvisionnement', 'montant')
                    ->withTimestamps();
    }

    public function matieresPremieres()
    {
        return $this->belongsToMany(MatierePremiere::class, 'fournisseur_mat', 'id_fournisseur', 'id_MP')
                    ->withPivot('prix_achat')
                    ->withTimestamps();
    }
}
