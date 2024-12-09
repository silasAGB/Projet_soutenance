<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_commande';
    protected $table = 'commandes';

    protected $fillable = [
        'reference_commande',
        'date_commande',
        'montant',
        'statut',
        'adresse_livraison',
        'date_livraison',
        'id_client',
        'id_utilisateur',
    ];

    // Liste des statuts possibles
    const STATUTS = [
        'en_attente' => 'En attente',
        'en_cours' => 'En cours',
        'livree' => 'Livrée',
        'annulee' => 'Annulée',
    ];

    // Relation avec le modèle Client
    public function clients()
    {
        return $this->belongsTo(Client::class, 'id_client')->withDefault();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client')->withDefault();
    }
    // Relation avec l'utilisateur ayant créé la commande
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    // Relation avec les produits commandés
    public function produits()
    {
        return $this->hasMany(ProduitCommande::class, 'id_commande');
    }

    public function produit_commande()
    {
        return $this->hasMany(ProduitCommande::class, 'id_commande', 'id_commande');
    }


    // Scopes pour filtrer les commandes
    public function scopeParClient($query, $clientId)
    {
        return $query->where('id_client', $clientId);
    }

    public function scopeParStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    // Calcul du montant total de la commande
    public function getMontantTotalAttribute()
    {
        return $this->produits->sum(function ($produitCommande) {
            return $produitCommande->quantite * $produitCommande->prix_unitaire;
        });
    }

    // Accesseur pour un statut lisible
    public function getStatutLabelAttribute()
    {
        return self::STATUTS[$this->statut] ?? 'Inconnu';
    }
}
