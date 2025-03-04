<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\MouvementProduit;
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
            'nom_produit' => 'required',
            'description_produit' => 'nullable',
            'prix_details_produit' => 'required|numeric',
            'prix_gros_produit' => 'nullable|numeric',
            'qte_stock' => 'required|numeric',
            'id_Categorie' => 'required|exists:categories,id_Categorie',
        ]);

        // Génération de la référence du produit
        $categorie = Categorie::findOrFail($request->id_Categorie);
        $prefix = strtoupper(substr($categorie->nom_Categorie, 0, 4));
        $lastProduit = Produit::where('id_Categorie', $request->id_Categorie)
            ->orderBy('id_produit', 'desc')
            ->first();
        $numero = $lastProduit ? intval(substr($lastProduit->reference_produit, 4)) + 1 : 1;
        $referenceProduit = $prefix . str_pad($numero, 3, '0', STR_PAD_LEFT);

        // Création du produit
        $produit = new Produit($request->all());
        $produit->reference_produit = $referenceProduit;
        $produit->save();

        // Enregistrer le mouvement de stock
        MouvementProduit::create([
            'id_produit' => $produit->id_produit,
            'type' => 'entrée',
            'quantité' => $produit->qte_stock,
            'stock_disponible' => $produit->qte_stock,
            'date_mouvement' => now(),
        ]);

        return redirect()->route('boilerplate.produits.index')
            ->with('success', 'Produit ajouté avec succès.');
    }

    public function show($id_produit)
    {
        $produit = Produit::findOrFail($id_produit);
        return view('boilerplate::produits.details', compact('produit'));
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
        'nom_produit' => 'required',
        'description_produit' => 'nullable',
        'prix_details_produit' => 'required|numeric',
        'prix_gros_produit' => 'nullable|numeric',
        'qte_stock' => 'required|numeric',
        'id_Categorie' => 'required|exists:categories,id_Categorie',
    ]);

    $produit = Produit::findOrFail($id_produit);
    $ancienStock = $produit->qte_stock;

    // Mettre à jour les informations du produit
    $produit->update($request->all());

    // Mettre à jour les mouvements de stock uniquement si le stock a changé
    if ($produit->qte_stock !== $ancienStock) {
        $mouvementType = $produit->qte_stock > $ancienStock ? 'entrée' : 'sortie';
        $quantiteMouvement = abs($produit->qte_stock - $ancienStock);

        // Vérifier si la quantité à enregistrer est supérieure à 0
        if ($quantiteMouvement > 0) {
            MouvementProduit::create([
                'id_produit' => $produit->id_produit,
                'type' => $mouvementType,
                'quantité' => $quantiteMouvement,
                'stock_disponible' => $produit->qte_stock,
                'date_mouvement' => now(),
            ]);
        }
    }

    // Synchroniser les matières premières
    $matieresPremieres = $request->input('matieres_premieres', []);
    $quantites = $request->input('quantites', []);
    $syncData = [];
    foreach ($matieresPremieres as $index => $matierePremiereId) {
        if (!empty($quantites[$index])) {
            $syncData[$matierePremiereId] = ['qte' => $quantites[$index]];
        }
    }
    $produit->matierePremieres()->sync($syncData);

    return redirect()->route('boilerplate.produits.index')
        ->with('success', 'Produit mis à jour avec succès.');
}


public function destroy($id_produit)
{
    $produit = Produit::findOrFail($id_produit);

    $produit->delete();

    return redirect()->route('boilerplate.produits.index')
    ->with('growl', ["Produit supprimé avec succès.", 'success']);
}

    public function miseAJourStock($id, $quantité, $type)
    {
        $produit = Produit::findOrFail($id);

        // Vérification de la quantité pour éviter un stock négatif
        if ($type === 'entrée') {
            $produit->qte_stock += $quantité;
        } elseif ($type === 'sortie') {
            if ($produit->qte_stock < $quantité) {
                return redirect()->back()->withErrors(['message' => 'Stock insuffisant pour effectuer cette sortie.']);
            }
            $produit->qte_stock -= $quantité;
        }

        $produit->save();

        // Enregistrer le mouvement
        MouvementProduit::create([
            'id_produit' => $produit->id,
            'type' => $type,
            'quantité' => $quantité,
            'stock_disponible' => $produit->qte_stock,
            'date_mouvement' => now(),
        ]);
    }
}
