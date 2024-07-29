<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Méthode pour afficher tous les clients
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    // Méthode pour afficher un formulaire de création de client
    public function create()
    {
        return view('clients.create');
    }

    // Méthode pour enregistrer un nouveau client
    public function store(Request $request)
    {
        $request->validate([
            'nom_Client' => 'required',
            'contact_Client' => 'required',
            'adresse_Client' => 'required',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client ajouté avec succès.');
    }

    // Méthode pour afficher les détails d'un client spécifique
    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    // Méthode pour afficher le formulaire de modification d'un client
    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    // Méthode pour mettre à jour un client
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom_Client' => 'required',
            'contact_Client' => 'required',
            'adresse_Client' => 'required',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')
            ->with('success', 'Client mis à jour avec succès.');
    }

    // Méthode pour supprimer un client
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}
