<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use App\Models\MatierePremiere;

class ProduitController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        return view('boilerplate::produits.list', compact('produits'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('boilerplate::produits.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reference_produit' => 'required',
            'nom_produit' => 'required',
            'description_produit' => 'nullable',
            'prix_details_produit' => 'required|numeric',
            'prix_gros_produit' => 'nullable|numeric',
            'qte_preparation' => 'nullable|numeric',
            'qte_lot' => 'nullable|numeric',
            'qte_stock' => 'required|numeric',
            'stock_min' => 'nullable|numeric',
            'emplacement' => 'nullable|string',
            'id_Categorie' => 'required|exists:categories,id_categorie',
        ]);

        Produit::create($request->all());

        return redirect()->route('boilerplate.produits.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    public function show($id_produit)
    {
        $produit = Produit::findOrFail($id_produit);
        return view('boilerplate::produits.show', compact('produit'));
    }

    public function edit($id_produit)
{
    $produit = Produit::findOrFail($id_produit);
    $categories = Categorie::all();
    $matieresPremieres = MatierePremiere::all();
    $matiereProduits = $produit->matierePremieres;

    return view('boilerplate::produits.edit', compact('produit', 'categories', 'matieresPremieres', 'matiereProduits'));
}

public function update(Request $request, $id_produit)
{
    $request->validate([
        'reference_produit' => 'required',
        'nom_produit' => 'required',
        'description_produit' => 'nullable',
        'prix_details_produit' => 'required|numeric',
        'prix_gros_produit' => 'nullable|numeric',
        'qte_preparation' => 'nullable|numeric',
        'qte_lot' => 'nullable|numeric',
        'qte_stock' => 'required|numeric',
        'stock_min' => 'nullable|numeric',
        'emplacement' => 'nullable|string',
        'id_Categorie' => 'required|exists:categories,id_Categorie',
    ]);

    $produit = Produit::findOrFail($id_produit);
    $produit->update($request->all());

    $matieresPremieres = $request->input('matieres_premieres', []);
    $quantites = $request->input('quantites', []);

    // Préparez les données pour la synchronisation
    $syncData = [];
    foreach ($matieresPremieres as $index => $matierePremiereId) {
        if (!empty($quantites[$index])) {
            $syncData[$matierePremiereId] = ['qte' => $quantites[$index]];
        }
    }

    // Synchronisation des matières premières avec les quantités
    $produit->matierePremieres()->sync($syncData);

    return redirect()->route('boilerplate.produits.index')
        ->with('success', 'Produit mis à jour avec succès.');
}



    public function destroy($id_produit)
    {
        $produit = Produit::findOrFail($id_produit);
        $produit->delete();

        return redirect()->route('boilerplate.produits.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}
