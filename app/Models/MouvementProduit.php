<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementProduit extends Model
{

    use HasFactory;

    protected $table = 'mouvement_produit';

    protected $fillable = [
        'id_produit',
        'type',
        'quantité',
        'stock_disponible',
        'date_mouvement',
        'id_production'
    ];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    public function production()
   {
       return $this->belongsTo(Production::class, 'id_produit');
   }
}
