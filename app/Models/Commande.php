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
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function produit_commande()
    {
        return $this->hasMany(ProduitCommande::class, 'id');
    }
}
