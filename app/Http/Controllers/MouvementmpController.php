<?php

namespace App\Http\Controllers;

use App\Models\MouvementMp;
use Illuminate\Http\Request;
use App\Models\MatierePremiere;


class MouvementmpController extends Controller
{





    public function index(Request $request)
    {

        $query = MouvementMp::query();

    // Filtrer par matière première si spécifiée
    if ($request->filled('matiere_premiere')) {
        $query->where('id_MP', $request->matiere_premiere);
    }

    // Filtrer par type si spécifié
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Dates de filtrage
    $startDate = $request->start_date ?? now()->subMonth()->toDateString();
    $endDate = $request->end_date ?? now()->toDateString();

    // Filtrer les mouvements par date
    $query->whereBetween('date_mouvement', [$startDate, $endDate]);

    // Charger les mouvements paginés
    $mouvements = $query->with('matierePremiere')
    ->orderBy('date_mouvement', 'desc')
    ->orderBy('created_at', 'desc')
    ->paginate(12);

    // Charger les matières premières pour le filtre
    $matieresPremieres = MatierePremiere::all();


    // Calculer la consommation sur la période filtrée
    $consommationQuery = clone $query; // Cloner la requête pour le calcul de la consommation
    $consommation = $consommationQuery->where('type', 'sortie')->sum('quantité');


    $stockAvantDebut = MouvementMp::where('id_MP', $request->matiere_premiere)
       ->where('date_mouvement', '<', $startDate)
       ->orderBy('date_mouvement', 'desc')
       ->first();

    $valeurStockAvantDebut = $stockAvantDebut ? $stockAvantDebut->stock_disponible : 0;

        return view('boilerplate::matierepremieres.mouvements ', compact('mouvements', 'matieresPremieres', 'consommation', 'valeurStockAvantDebut'));
    }



}
