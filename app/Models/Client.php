<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;


    // Définir la clé primaire personnalisée
    protected $primaryKey = 'id_client';


    protected $table = 'clients';



    protected $fillable = [
        'nom_client',
        'prenom_client',
        'date_naissance',
        'age',
        'sexe',
        'mail_client',
        'contact_client',
        'adresse_client',
        'nom_entreprise',
        'poste_occupe',
        'type_entreprise',
        'secteur_activite',
        'num_identification_fiscale',
        'num_registre_commerce',
        'statut',
        'date_inscription',
    ];

    /**
     * Définir une relation avec les commandes.
     * Un client peut avoir plusieurs commandes.
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'id_client');
    }

    /**
     * Définir une relation avec une éventuelle table "produits" si besoin.
     * Un client peut distribuer ou acheter plusieurs produits.
     */
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_client');
    }

    /**
     * Accesseur pour calculer l'âge à partir de la date de naissance.
     * Si l'âge n'est pas explicitement défini, il est calculé automatiquement.
     */

    public function getAgeAttribute($value)
    {
        if ($value) {
            return $value;
        }

        if ($this->date_naissance) {
            return \Carbon\Carbon::parse($this->date_naissance)->age;
        }

        return null;
    }


    public function getClientNameAttribute()
    {
        if ($this->client) {
            return "{$this->client->nom_client} {$this->client->prenom_client}";
        }

        return 'Inconnu';
    }
    /**
     * Scopes personnalisés pour filtrer les clients.
     */
    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeParEntreprise($query, $entreprise)
    {
        return $query->where('nom_entreprise', $entreprise);
    }
}
