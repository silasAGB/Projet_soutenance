<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    // Méthode pour afficher tous les fournisseurs
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('boilerplate::approvisionnements.fournisseurs', compact('fournisseurs'));
    }

    // Méthode pour afficher un formulaire de création de fournisseur
    public function create()
    {
        return view('boilerplate::approvisionnements.createfournisseur');
    }

    // Méthode pour enregistrer un nouveau fournisseur
    public function store(Request $request)
    {
        $request->validate([
            'nom_fournisseur' => 'required',
            'contact_fournisseur' => 'required',
            'email_fournisseur' => 'required|email',
            'adresse_fournisseur' => 'required',
        ]);

        Fournisseur::create($request->all());

        return redirect()->route('boilerplate.approvisionnements.fournisseurs')
            ->with('growl', [__('fournisseur créé'), 'success']);
    }

    // Méthode pour afficher les détails d'un fournisseur spécifique
    public function show($id_fournisseur)
    {
dd(
$id_fournisseur
);
        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        return view('boilerplate::approvisionnements.fournisseur', compact('fournisseur'));
    }

    // Méthode pour afficher le formulaire de modification d'un fournisseur
    public function edit($id_fournisseur)
    {
        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        return view('boilerplate::approvisionnements.editfournisseur', compact('fournisseur'));
    }

    // Méthode pour mettre à jour un fournisseur
    public function update(Request $request, $id_fournisseur)
    {
        dd($id_fournisseur);

        $request->validate([
            'nom_fournisseur' => 'required',
            'contact_fournisseur' => 'required',
            'email_fournisseur' => 'required|email',
            'adresse_fournisseur' => 'required',
        ]);

        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        $fournisseur->update($request->all());

        return redirect()->route('boilerplate.approvisionnements.fournisseurs')
            ->with('success', 'Fournisseur mis à jour avec succès.');
    }


    public function destroy($id_fournisseur)
    {
        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        $fournisseur->delete();

        return redirect()->route('boilerplate.approvisionnements.fournisseurs')
        ->with('growl', ["Fournisseur supprimé avec succès.", 'success']);
    }
}
