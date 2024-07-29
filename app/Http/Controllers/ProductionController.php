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
        $productions = Production::all();
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
            'date_prevue' => 'required|date',
            'qte_prevue' => 'required|numeric',
            'id_Produit' => 'required|exists:produits,id_Produit',
        ]);

        $production = new Production();
        $production->date_prevue = $request->input('date_prevue');
        $production->qte_prevue = $request->input('qte_prevue');
        $production->id_Produit = $request->input('id_Produit');
        $production->statut = 'en attente d\'approbation'; // Assurez-vous que le statut est défini correctement
        $production->save();

        return redirect()->route('boilerplate.productions.gerer')
                         ->with('success', 'Production ajoutée avec succès.');
    }

    public function show($id)
    {
        $production = Production::findOrFail($id);
        return view('boilerplate::productions.show', compact('production'));
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
            'date_prevue' => 'required|date',
            'qte_prevue' => 'required|numeric',
            'id_Produit' => 'required|exists:produits,id_Produit',
            'statut' => 'required|string|max:255', // Assurez-vous que toutes les colonnes nécessaires sont validées ici
        ]);

        $production = Production::findOrFail($id);
        $production->fill($request->all()); // Mettez à jour toutes les colonnes à partir des données du formulaire
        $production->save();

        return redirect()->route('boilerplate.productions.gerer')
                         ->with('success', 'Production mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $production = Production::findOrFail($id);
        $production->delete();

        return redirect()->route('boilerplate.productions.gerer')
                         ->with('success', 'Production supprimée avec succès.');
    }

    public function statistiques()
    {
        // Logique pour afficher les statistiques des productions
        return view('boilerplate::productions.statistiques');
    }
}
