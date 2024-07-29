<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_Commande';

    protected $fillable = ['reference_Commande', 'date_Commande', 'montant', 'statut', 'adresse_livraison', 'date_livraison', 'id_Client'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_Client');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_commande', 'id_Commande', 'id_Produit');
    }
}
