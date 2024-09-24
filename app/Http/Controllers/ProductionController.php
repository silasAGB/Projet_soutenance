<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Produit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::with('produit')->get();
        return view('boilerplate::productions.gerer', compact('productions'));
    }

    public function create()
    {
        $produits = Produit::all();
        return view('boilerplate::productions.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit',
            'date_prevue' => 'required|date',
            'qte_prevue' => 'required|numeric|min:0',
            'nbr_preparation' => 'nullable|numeric|min:0',
        ]);

        // Récupérer les informations du produit
        $produit = Produit::findOrFail($request->id_produit);

        // Obtenir le mois et l'année de la date prévue
        $datePrevue = Carbon::parse($request->date_prevue);
        $mois = $datePrevue->format('F');
        $annee = $datePrevue->format('Y');

        // Calculer le nombre de productions déjà effectuées ce mois-ci
        $nombreProduction = Production::whereYear('date_prevue', $datePrevue->year)
            ->whereMonth('date_prevue', $datePrevue->month)
            ->count() + 1;

        // Générer la référence de production
        $referenceProduction = $produit->nom_produit . ' N°' . $nombreProduction . ' - ' . $mois . ' - ' . $annee;

        // Créer la nouvelle production
        Production::create([
            'reference_production' => $referenceProduction,
            'id_produit' => $request->id_produit,
            'date_prevue' => $request->date_prevue,
            'qte_prevue' => $request->qte_prevue,
            'nbr_preparation' => $request->nbr_preparation ?? 1,
            'statut' => 'en attente d\'approbation ',
        ]);

        return redirect()->route('boilerplate.productions.gerer')->with('success', 'Production créée avec succès.');
    }

    public function edit($id)
    {
        $production = Production::findOrFail($id);
        $produits = Produit::all();

        return view('boilerplate::productions.edit', compact('production', 'produits'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reference_production' => 'required|string|max:255',
            'id_produit' => 'required|exists:produits,id_produit',
            'date_prevue' => 'required|date',
            'qte_prevue' => 'required|numeric|min:0',
            'nbr_preparation' => 'nullable|numeric|min:0',
            'statut' => 'required|in:En attente d\'approbation,En attente de production,Terminé',
            'qte_produite' => 'required_if:statut,Terminé|nullable|numeric|min:0',
            'date_production' => 'required_if:statut,Terminé|nullable|date',
        ]);

        $production = Production::findOrFail($id);

        $data = [
            'reference_production' => $request->reference_production,
            'id_produit' => $request->id_produit,
            'date_prevue' => $request->date_prevue,
            'qte_prevue' => $request->qte_prevue,
            'nbr_preparation' => $request->nbr_preparation ?? 1,
            'statut' => $request->statut,
        ];

        if ($request->statut === 'Terminé') {
            $data['qte_produite'] = $request->qte_produite;
            $data['date_production'] = $request->date_production;

            // Mise à jour de la quantité en stock du produit
            $produit = Produit::findOrFail($request->id_produit);
            $produit->qte_stock += $request->qte_produite;
            $produit->save();
        } else {
            $data['qte_produite'] = null;
            $data['date_production'] = null;
        }

        $production->update($data);

        return redirect()->route('boilerplate.productions.gerer')->with('success', 'Production mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $production = Production::findOrFail($id);
        $production->delete();
        return redirect()->route('boilerplate.productions.gerer')->with('success', 'Production supprimée avec succès.');
    }
}
