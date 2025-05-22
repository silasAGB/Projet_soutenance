<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index()
    {
        $fournisseurs = Fournisseur::all();
        return view('boilerplate::approvisionnements.fournisseurs', compact('fournisseurs'));
    }


    public function create()
    {
        return view('boilerplate::approvisionnements.createfournisseur');
    }

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


    public function show($id_fournisseur)
    {
dd(
$id_fournisseur
);
        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        return view('boilerplate::approvisionnements.fournisseur', compact('fournisseur'));
    }


    public function edit($id_fournisseur)
    {
        $fournisseur = Fournisseur::findOrFail($id_fournisseur);
        return view('boilerplate::approvisionnements.editfournisseur', compact('fournisseur'));
    }


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
        $fournisseur->update($request->only(['nom_fournisseur', 'contact_fournisseur', 'email_fournisseur', 'adresse_fournisseur']));

        return redirect()->route('boilerplate.approvisionnements.fournisseurs')
            ->with('success', 'Fournisseur mis à jour avec succès.');
    }


    public function destroy($id)
    {
        $fournisseur = Fournisseur::findOrFail($id);
        $fournisseur->delete();

        return redirect()->route('boilerplate.approvisionnements.fournisseurs')
        ->with('growl', ["Fournisseur supprimé avec succès.", 'success']);
    }
}
