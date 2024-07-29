<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    // Méthode pour afficher toutes les commandes
    public function index()
    {
        $commandes = Commande::all();
        return view('boilerplate::commandes.gerer', compact('commandes'));
    }

    // Méthode pour afficher un formulaire de création de commande
    public function create()
    {
        return view('commandes.create');
    }

    // Méthode pour enregistrer une nouvelle commande
    public function store(Request $request)
    {
        $request->validate([
            'reference_Commande' => 'required',
            'date_Commande' => 'required',
            'montant' => 'required',
            'statut' => 'required',
            'adresse_livraison' => 'required',
            'date_livraison' => 'required',
            'id_Client' => 'required|exists:clients,id_Client',
        ]);

        Commande::create($request->all());

        return redirect()->route('commandes.index')
            ->with('success', 'Commande ajoutée avec succès.');
    }

    // Méthode pour afficher les détails d'une commande spécifique
    public function show($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commandes.show', compact('commande'));
    }

    // Méthode pour afficher le formulaire de modification d'une commande
    public function edit($id)
    {
        $commande = Commande::findOrFail($id);
        return view('commandes.edit', compact('commande'));
    }

    // Méthode pour mettre à jour une commande
    public function update(Request $request, $id)
    {
        $request->validate([
            'reference_Commande' => 'required',
            'date_Commande' => 'required',
            'montant' => 'required',
            'statut' => 'required',
            'adresse_livraison' => 'required',
            'date_livraison' => 'required',
            'id_Client' => 'required|exists:clients,id_Client',
        ]);

        $commande = Commande::findOrFail($id);
        $commande->update($request->all());

        return redirect()->route('commandes.index')
            ->with('success', 'Commande mise à jour avec succès.');
    }

    // Méthode pour supprimer une commande
    public function destroy($id)
    {
        $commande = Commande::findOrFail($id);
        $commande->delete();

        return redirect()->route('commandes.index')
            ->with('success', 'Commande supprimée avec succès.');
    }

    public function statistiques()
    {
        return view('boilerplate::commandes.statistiques');
    }
}
