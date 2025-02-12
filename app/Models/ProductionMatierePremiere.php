<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductionMatierePremiere extends Pivot
{
    protected $table = 'production_matiere_premiere';

    protected $fillable = [
        'id_production',
        'id_MP',
        'id_produit',
        'qte',
    ];
}
