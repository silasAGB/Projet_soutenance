<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_approvisionnement';

    protected $fillable = ['date_approvisionnement', 'reference_approvisionnement', 'status', 'montant'];

    public function getFormattedMontantAttribute()
    {
        return number_format($this->montant, 2) . ' FCFA';
    }

    public function matieresPremieres()
    {
        return $this->belongsToMany(MatierePremiere::class, 'approvisionnement_matiere_premiere', 'id_approvisionnement', 'id_MP')
                    ->withPivot('id_fournisseur', 'qte_approvisionnement', 'montant')
                    ->withTimestamps();
    }

    public function fournisseurs()
    {
        return $this->belongsToMany(Fournisseur::class, 'approvisionnement_matiere_premiere', 'id_approvisionnement', 'id_fournisseur')
                    ->withPivot('id_MP', 'qte_approvisionnement', 'montant')
                    ->withTimestamps();
    }
}
