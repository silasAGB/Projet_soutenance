<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_Categorie';

    protected $fillable = ['code_Categorie', 'nom_Categorie'];

    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_Categorie');
    }

    public function matieresPremieres()
    {
        return $this->hasMany(MatierePremiere::class, 'id_Categorie');
    }
}

