<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produit';

    protected $fillable = [
        'reference_produit', 'nom_produit', 'description_produit', 'prix_details_produit',
        'prix_gros_produit', 'qte_preparation', 'qte_lot', 'qte_stock', 'stock_min', 'emplacement', 'id_Categorie'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_Categorie');
    }

    public function matierePremieres()
    {
        return $this->belongsToMany(MatierePremiere::class ,'matiere_produit','id_produit', 'id_MP')
                    ->withPivot('qte')
                    ->withTimestamps();
    }

    public function mouvements()
{
    return $this->hasMany(MouvementProduit::class, 'id_produit');
}


}
