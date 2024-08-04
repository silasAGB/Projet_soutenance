<?php

namespace App\Http\Controllers;

use App\Models\MatierePremiere;
use App\Models\Categorie;
use App\Models\Fournisseur; // Assurez-vous d'importer le modèle Fournisseur
use Illuminate\Http\Request;

class MatierePremiereController extends Controller
{
    public function index()
    {
        $matieresPremieres = MatierePremiere::all();
        return view('boilerplate::matierepremieres.list', compact('matieresPremieres'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('boilerplate::matierepremieres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_MP' => 'required',
            'prix_achat' => 'required|numeric',
            'unite' => 'required',
            'qte_stock' => 'required|numeric',
            'stock_min' => 'required|numeric',
            'emplacement' => 'required|string',
            'id_categorie' => 'required|exists:categories,id_categorie',
        ]);

        MatierePremiere::create($request->all());

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première ajoutée avec succès.');
    }

    public function show($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        return view('boilerplate::matierepremieres.show', compact('matierePremiere'));
    }

    public function edit($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all(); // Récupérer tous les fournisseurs
        return view('boilerplate::matierepremieres.edit', compact('matierePremiere', 'categories', 'fournisseurs'));
    }

    public function update(Request $request, $id_MP)
    {
        $request->validate([
            'nom_MP' => 'required',
            'unite' => 'required',
            'qte_stock' => 'required|numeric',
            'stock_min' => 'required|numeric',
            'emplacement' => 'required|string',
            'id_categorie' => 'required|exists:categories,id_categorie',
        ]);

        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        $matierePremiere->update($request->all());

        // Mettre à jour les fournisseurs et leurs prix d'achat
        $fournisseurs = $request->input('fournisseurs', []);
        $matierePremiere->fournisseurs()->sync([]);
        foreach ($fournisseurs as $fournisseur) {
            $matierePremiere->fournisseurs()->attach($fournisseur['id'], ['prix_achat' => $fournisseur['prix_achat']]);
        }

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première mise à jour avec succès.');
    }

    public function destroy($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        $matierePremiere->delete();

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première supprimée avec succès.');
    }
}
