<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class   ProduitCommande extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'produit_commandes';

    protected $fillable = [
        'id_commande',
        'id_produit',
        'qte_produit_commande',
        'prix_unitaire',
        'montant_produit_commande',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }
}
