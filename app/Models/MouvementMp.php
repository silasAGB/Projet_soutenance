<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementMp extends Model
{
    use HasFactory;

    protected $table = 'mouvement_mp';

    protected $fillable = [
        'id_MP',
        'type',
        'quantité',
        'stock_disponible',
        'date_mouvement',
        'id_approvisionnement'
    ];

    public function matierePremiere()
    {
        return $this->belongsTo(MatierePremiere::class, 'id_MP');
    }

    public function approvisionnement()
   {
       return $this->belongsTo(Approvisionnement::class, 'id_approvisionnement');
   }
}
