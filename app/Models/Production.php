<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_production';

    protected $fillable = ['date_prevue', 'qte_prevue', 'qte_produite', 'date_production', 'montant_produit', 'statut', 'id_Produit'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_Produit');
    }
}
