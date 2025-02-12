<?php

namespace App\Http\Controllers;

use App\Menu\Produits;
use Illuminate\Http\Request;
use App\Models\MouvementProduit;
use App\Models\Production;
use App\Models\Produit;

class MouvementproduitController extends Controller
{

    public function index (Request $request)
    {

        $query = MouvementProduit::query();

    // Filtrer par matière première si spécifiée
    if ($request->filled('produit')) {
        $query->where('id_produit', $request->produit);
    }

    // Dates de filtrage
    $startDate = $request->start_date ?? now()->subMonth()->toDateString();
    $endDate = $request->end_date ?? now()->toDateString();

    // Filtrer les mouvements par date
    $query->whereBetween('date_mouvement', [$startDate, $endDate]);

    // Charger les mouvements paginés
    $mouvements = $query->with('produit')
    ->orderBy('date_mouvement', 'desc')
    ->orderBy('created_at', 'desc')
    ->paginate(12);

    // Charger les matières premières pour le filtre
    $produits = Produit::all();


    // Calculer la consommation sur la période filtrée
    $consommationQuery = clone $query; // Cloner la requête pour le calcul de la consommation
    $consommation = $consommationQuery->where('type', 'sortie')->sum('quantité');


    $stockAvantDebut = MouvementProduit::where('id_produit', $request->produit)
       ->where('date_mouvement', '<', $startDate)
       ->orderBy('date_mouvement', 'desc')
       ->first();

    $valeurStockAvantDebut = $stockAvantDebut ? $stockAvantDebut->stock_disponible : 0;

        return view('boilerplate::produits.mouvements ', compact('mouvements', 'produits', 'consommation', 'valeurStockAvantDebut' ));
    }
}
