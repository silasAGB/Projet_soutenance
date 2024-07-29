<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FournisseurMat extends Pivot
{
    protected $table = 'fournisseur_mat';
    protected $fillable = ['id_fournisseur', 'id_MP', 'prix_achat'];
}
