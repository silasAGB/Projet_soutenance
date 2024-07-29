<?php

namespace App\Http\Controllers;

use App\Models\Distributeur;
use Illuminate\Http\Request;

class DistributeurController extends Controller
{
    // Méthode pour afficher tous les distributeurs
    public function index()
    {
        $distributeurs = Distributeur::all();
        return view('distributeurs.index', compact('distributeurs'));
    }

    // Méthode pour afficher un formulaire de création de distributeur
    public function create()
    {
        return view('distributeurs.create');
    }

    // Méthode pour enregistrer un nouveau distributeur
    public function store(Request $request)
    {
        $request->validate([
            'id_Client' => 'required|exists:clients,id_Client',
        ]);

        Distributeur::create($request->all());

        return redirect()->route('distributeurs.index')
            ->with('success', 'Distributeur ajouté avec succès.');
    }

    // Méthode pour afficher les détails d'un distributeur spécifique
    public function show($id)
    {
        $distributeur = Distributeur::findOrFail($id);
        return view('distributeurs.show', compact('distributeur'));
    }

    // Méthode pour afficher le formulaire de modification d'un distributeur
    public function edit($id)
    {
        $distributeur = Distributeur::findOrFail($id);
        return view('distributeurs.edit', compact('distributeur'));
    }

    // Méthode pour mettre à jour un distributeur
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_Client' => 'required|exists:clients,id_Client',
        ]);

        $distributeur = Distributeur::findOrFail($id);
        $distributeur->update($request->all());

        return redirect()->route('distributeurs.index')
            ->with('success', 'Distributeur mis à jour avec succès.');
    }

    // Méthode pour supprimer un distributeur
    public function destroy($id)
    {
        $distributeur = Distributeur::findOrFail($id);
        $distributeur->delete();

        return redirect()->route('distributeurs.index')
            ->with('success', 'Distributeur supprimé avec succès.');
    }
}
