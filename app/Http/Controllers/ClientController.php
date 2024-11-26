<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    // Afficher tous les clients
    public function index()
    {
        $clients = Client::withCount('commandes')->get();
        return view('boilerplate::commandes.client', compact('clients'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('boilerplate::commandes.createclient');
    }

    // Enregistrer un nouveau client
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_client' => 'required|string|max:255',
            'prenom_client' => 'required|string|max:255',
            'date_naissance' => 'nullable|date',
            'sexe' => 'required|string|in:M,F,N',
            'mail_client' => 'required|email|unique:clients',
            'contact_client' => 'required|string|unique:clients|max:20',
            'adresse_client' => 'required|string|max:255',
            'nom_entreprise' => 'nullable|string|max:255',
            'poste_occupe' => 'nullable|string|max:255',
            'type_entreprise' => 'nullable|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'num_identification_fiscale' => 'nullable|string|max:50',
            'num_registre_commerce' => 'nullable|string|max:50',
        ]);

        try {
            Client::create(array_merge($validatedData, [
                'statut' => 'actif',
                'date_inscription' => now(),
            ]));
            return redirect()->route('boilerplate.commandes.client')->with('success', 'Client créé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la création du client : ' . $e->getMessage()]);
        }
    }

    // Afficher les détails d'un client
    public function show($id_client)
    {
        $client = Client::with('commandes')->findOrFail($id_client);
        return view('boilerplate::commandes.detailsclient', compact('client'));
    }

    // Afficher le formulaire d'édition
    public function edit($id_client)
    {
        $client = Client::findOrFail($id_client);
        return view('boilerplate::commandes.editclient', compact('client'));
    }

    // Mettre à jour un client
    public function update(Request $request, $id_client)
    {
        $client = Client::findOrFail($id_client);

        $validatedData = $request->validate([
            'nom_client' => 'required|string|max:255',
            'prenom_client' => 'required|string|max:255',
            'date_naissance' => 'nullable|date',
            'sexe' => 'required|string|in:M,F,N',
            'mail_client' => 'required|email|unique:clients,mail_client,' . $client->id_client . ',id_client',
            'contact_client' => 'required|string|max:20|unique:clients,contact_client,' . $client->id_client . ',id_client',
            'adresse_client' => 'required|string|max:255',
            'nom_entreprise' => 'nullable|string|max:255',
            'poste_occupe' => 'nullable|string|max:255',
            'type_entreprise' => 'nullable|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'num_identification_fiscale' => 'nullable|string|max:50',
            'num_registre_commerce' => 'nullable|string|max:50',
            'statut' => 'required|string|in:actif,suspendu',
        ]);

        try {
            $client->update($validatedData);
            return redirect()->route('boilerplate.commandes.client')->with('success', 'Client mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour du client : ' . $e->getMessage()]);
        }
    }

    // Supprimer un client
    public function destroy($id_client)
    {
        $client = Client::findOrFail($id_client);

        try {
            $client->delete();
            return redirect()->route('boilerplate.commandes.client')->with('success', 'Client supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erreur lors de la suppression du client : ' . $e->getMessage()]);
        }
    }
}
