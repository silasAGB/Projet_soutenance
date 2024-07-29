<?php

namespace App\Http\Controllers;

use App\Models\MatiereProduit;
use App\Models\MatierePremiere;
use App\Models\Produit;
use Illuminate\Http\Request;

class MatiereProduitController extends Controller
{
    public function index()
    {
        $matiereProduits = MatiereProduit::with(['matierePremiere', 'produit'])->get();
        return view('matiere_produit.index', compact('matiereProduits'));
    }

    public function create()
    {
        $matierePremieres = MatierePremiere::all();
        $produits = Produit::all();
        return view('matiere_produit.create', compact('matierePremieres', 'produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_MP' => 'required|exists:matiere_premieres,id_MP',
            'id_Produit' => 'required|exists:produits,id_Produit',
            'qte' => 'required|integer',
        ]);

        MatiereProduit::create($request->all());

        return redirect()->route('matiere_produit.index')->with('success', 'Matière Produit ajoutée avec succès');
    }

    public function show($id)
    {
        $matiereProduit = MatiereProduit::with(['matierePremiere', 'produit'])->findOrFail($id);
        return view('matiere_produit.show', compact('matiereProduit'));
    }

    public function edit($id)
    {
        $matiereProduit = MatiereProduit::findOrFail($id);
        $matierePremieres = MatierePremiere::all();
        $produits = Produit::all();
        return view('matiere_produit.edit', compact('matiereProduit', 'matierePremieres', 'produits'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_MP' => 'required|exists:matiere_premieres,id_MP',
            'id_Produit' => 'required|exists:produits,id_Produit',
            'qte' => 'required|integer',
        ]);

        $matiereProduit = MatiereProduit::findOrFail($id);
        $matiereProduit->update($request->all());

        return redirect()->route('matiere_produit.index')->with('success', 'Matière Produit mise à jour avec succès');
    }

    public function destroy($id)
    {
        $matiereProduit = MatiereProduit::findOrFail($id);
        $matiereProduit->delete();

        return redirect()->route('matiere_produit.index')->with('success', 'Matière Produit supprimée avec succès');
    }
}
