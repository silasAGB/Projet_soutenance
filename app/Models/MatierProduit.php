<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MatiereProduit extends Pivot
{
    use HasFactory;

    protected $table = 'matiere_produit';

    protected $fillable = [
        'id_MP', 'id_produit', 'qte',
    ];

    public function matierePremiere()
    {
        return $this->belongsTo(MatierePremiere::class, 'id_MP', 'id_MP');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id_produit');
    }
}
