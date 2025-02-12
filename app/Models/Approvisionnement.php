<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_approvisionnement';

    protected $fillable = [
        'date_approvisionnement',
        'reference_approvisionnement',
        'statut',
        'montant',
        'date_livraison',
    ];

    // Méthode pour formater le montant
    public function getFormattedMontantAttribute()
    {
        return number_format($this->montant, 2) . ' FCFA';
    }

    // Relation avec les matières premières
    public function matieresPremieres()
    {
        return $this->belongsToMany(MatierePremiere::class, 'approvisionnement_matiere_premiere', 'id_approvisionnement', 'id_MP')
                    ->withPivot('id_fournisseur', 'qte_approvisionnement', 'montant' , 'statut', 'qte_livree', 'date_livraison')
                    ->withTimestamps();
    }

    // Relation avec les fournisseurs
    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'approvisionnement_matiere_premiere', 'id_approvisionnement', 'id_fournisseur')
                    ->withPivot('id_MP', 'qte_approvisionnement', 'montant')
                    ->withTimestamps();
    }

    public function mouvements()
   {
       return $this->hasMany(MouvementMp::class, 'id_approvisionnement');
   }

    // Formater la date de livraison
    /*public function getFormattedDateLivraisonAttribute()
    {
        return $this->date_livraison ? $this->date_livraison->format('d/m/Y') : 'Non livré';
    }
    */

    public function getFormattedDateLivraisonAttribute()
{
    return $this->date_livraison ? \Carbon\Carbon::parse($this->date_livraison)->format('d/m/Y') : __('Non livré');
}
}
