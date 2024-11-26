<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Produit;
use App\Models\User;
use App\Models\Client;
use App\Models\ProduitCommande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CommandeController extends Controller
{
public function index()
{
    $commandes = Commande::with('client','clients')->get();
    return view('boilerplate::commandes.gerer', compact('commandes'));
}

public function create()
{
    $currentDate = Carbon::now();
    $month = $currentDate->month;
    $year = $currentDate->year;
    $commandeCount = Commande::whereMonth('date_commande', $month)
        ->whereYear('date_commande', $year)
        ->count() + 1;
    $referenceCommande = 'Commande N°' . $commandeCount . ' - ' . $month . ' - ' . $year;

    $user = Auth::user();
    $produits = Produit::all();
    $clients = Client::all();
    return view('boilerplate::commandes.create', compact('user', 'produits', 'referenceCommande', 'clients'));
}

public function store(Request $request)
{


    $request->validate([
        'reference_commande' => 'required|string|unique:commandes',
        'date_commande' => 'required|date',
        'adresse_livraison' => 'required|string',
        'date_livraison' => 'required|date|after_or_equal:date_commande',
        'produits' => 'required|array|min:1',
        'produits.*.id' => 'required|exists:produits,id_produit',
        'produits.*.qte' => 'required|integer|min:1',
        'id_client' => 'nullable|exists:clients,id_client'
    ]);

DB::beginTransaction();

    try {


        $commande = Commande::create([
            'reference_commande' => $request->reference_commande,
            'date_commande' => $request->date_commande,
            'montant' => 0,
            'statut' => $request->statut ?? 'En_attente',
            'adresse_livraison' => $request->adresse_livraison,
            'date_livraison' => $request->date_livraison,
            'id_client' => $request->id_client,
            'id_utilisateur' => Auth::id(),
        ]);

    $montantTotal = 0;

        foreach ($request->produits as $produitData) {
    $produit = Produit::findOrFail($produitData['id']);
    $montantProduit = $produit->prix_details_produit * $produitData['qte'];

            ProduitCommande::create([
                'id_commande' => $commande->id_commande,
                'id_produit' => $produitData['id'],
                'qte_produit_commande' => $produitData['qte'],
                'prix_unitaire' => $produit->prix_details_produit,
                'montant_produit_commande' => $montantProduit,
            ]);

        $montantTotal += $montantProduit;
        }

    $commande->update(['montant' => $montantTotal]);



        DB::commit();


        return redirect()->route('boilerplate.commandes.gerer')->with('success', 'Commande et produits ajoutés avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();



        return back()->withErrors(['error' => 'Erreur lors de la création de la commande: ' . $e->getMessage()]);
    }
}

public function show($id_commande)
{
    $commande = Commande::with('produits')->findOrFail($id_commande);
    return view('boilerplate::commandes.details', compact('commande'));
}

public function edit($id_commande)
{
    $commande = Commande::with('produit_commande')->findOrFail($id_commande);
    if (!$commande) {
        return redirect()->route('boilerplate.commandes.gerer')
            ->with('error', 'Commande introuvable.');
    }
    $produits = Produit::all();
    $clients = User::all();
    return view('boilerplate::commandes.edit', compact('commande', 'produits', 'clients'));
}

public function update(Request $request, $id_commande)
{

    $commande = Commande::findOrFail($id_commande);

    $request->validate([
        'adresse_livraison' => 'required|string',
        'date_livraison' => 'required|date|after_or_equal:date_commande',
        'produits' => 'required|array|min:1',
        'produits.*.id' => 'required|exists:produits,id_produit',
        'produits.*.qte' => 'required|integer|min:1',
        'id_client' => 'required|exists:users,id',
    ]);

DB::beginTransaction();

    try {

        $commande->update([
            'adresse_livraison' => $request->adresse_livraison,
            'date_livraison' => $request->date_livraison,
        ]);

        // Supprimer les anciens produits associés
        $commande->produit_commande()->delete();

        $montantTotal = 0;

        // Réajouter les nouveaux produits
        foreach ($request->produits as $produitData) {
            $produit = Produit::findOrFail($produitData['id']);
            $montantProduit = $produit->prix_details_produit * $produitData['qte'];

            ProduitCommande::create([
                'id_commande' => $commande->id_commande,
                'id_produit' => $produitData['id'],
                'qte_produit_commande' => $produitData['qte'],
                'prix_unitaire' => $produit->prix_details_produit,
                'montant_produit_commande' => $montantProduit,
            ]);

            $montantTotal += $montantProduit;
        }

        $commande->update(['montant' => $montantTotal]);

        DB::commit();

        return redirect()->route('boilerplate::commandes.gerer')->with('success', 'Commande mise à jour avec succès.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Erreur lors de la mise à jour de la commande : ' . $e->getMessage()]);
    }
}

// Supprimer une commande
public function destroy($id_commande)
{
    $commande = Commande::findOrFail($id_commande);

    try {
        $commande->delete();
        return redirect()->route('commandes.gerer')->with('success', 'Commande supprimée avec succès.');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Erreur lors de la suppression de la commande : ' . $e->getMessage()]);
    }
}
}

