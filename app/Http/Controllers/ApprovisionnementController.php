<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Fournisseur;
use App\Models\MatierePremiere;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class ApprovisionnementController extends Controller
{
    public function index()
    {
        $approvisionnements = Approvisionnement::with(['matieresPremieres', 'matieresPremieres.fournisseurs'])->get();
        return view('boilerplate::approvisionnements.gerer', compact('approvisionnements'));
    }

    public function show($id_approvisionnement)
    {
        $approvisionnement = Approvisionnement::with(['matieresPremieres', 'fournisseurs'])->findOrFail($id_approvisionnement);
        return view('boilerplate::approvisionnements.details', compact('approvisionnement'));
    }



    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $matieresPremieres = MatierePremiere::all();
        return view('boilerplate::approvisionnements.create', compact('fournisseurs', 'matieresPremieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_approvisionnement' => 'required|date',
            'reference_approvisionnement' => 'required|string|max:255',
            'matieresPremieres.*.id_MP' => 'required|exists:matiere_premieres,id_MP',
            'matieresPremieres.*.id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
            'matieresPremieres.*.qte_approvisionnement' => 'required|numeric',
            'matieresPremieres.*.montant' => 'required|numeric',
        ]);

        $approvisionnement = Approvisionnement::create([
            'date_approvisionnement' => $request->date_approvisionnement,
            'reference_approvisionnement' => $request->reference_approvisionnement,
            'status' => 'en attente d\'approbation',
        ]);

        $totalMontant = 0;

        foreach ($request->matieresPremieres as $matiere) {
            $prixAchat = MatierePremiere::find($matiere['id_MP'])->prix_achat;
            $montant = $matiere['qte_approvisionnement'] * $prixAchat;

            $approvisionnement->matieresPremieres()->attach($matiere['id_MP'], [
                'id_fournisseur' => $matiere['id_fournisseur'],
                'qte_approvisionnement' => $matiere['qte_approvisionnement'],
                'montant' => $montant,
            ]);

            $totalMontant += $montant;
        }

        $approvisionnement->update(['montant' => $totalMontant]);

        return redirect()->route('boilerplate.approvisionnements.gerer')
                         ->with('success', 'Approvisionnement ajouté avec succès.');
    }



    public function edit($id_approvisionnement)
    {
        $approvisionnement = Approvisionnement::with(['matieresPremieres', 'fournisseurs'])->findOrFail($id_approvisionnement);
        $fournisseurs = Fournisseur::all();
        $matieresPremieres = MatierePremiere::all();
        return view('boilerplate::approvisionnements.edit', compact('approvisionnement', 'fournisseurs', 'matieresPremieres'));
    }

    public function update(Request $request, $id_approvisionnement)
    {
        $request->validate([
            'date_approvisionnement' => 'required|date',
            'reference_approvisionnement' => 'required|string|max:255',
            'matieresPremieres.*.id_MP' => 'required|exists:matiere_premieres,id_MP',
            'matieresPremieres.*.id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
            'matieresPremieres.*.qte_approvisionnement' => 'required|numeric',
            'matieresPremieres.*.montant' => 'required|numeric',
        ]);

        $approvisionnement = Approvisionnement::findOrFail($id_approvisionnement);
        $approvisionnement->update([
            'date_approvisionnement' => $request->date_approvisionnement,
            'reference_approvisionnement' => $request->reference_approvisionnement,
        ]);

        // Detach existing relations and reattach updated ones
        $approvisionnement->matieresPremieres()->detach();

        $totalMontant = 0;

        foreach ($request->matieresPremieres as $matiere) {
            $prixAchat = MatierePremiere::find($matiere['id_MP'])->prix_achat;
            $montant = $matiere['qte_approvisionnement'] * $prixAchat;

            $approvisionnement->matieresPremieres()->attach($matiere['id_MP'], [
                'id_fournisseur' => $matiere['id_fournisseur'],
                'qte_approvisionnement' => $matiere['qte_approvisionnement'],
                'montant' => $montant,
            ]);

            $totalMontant += $montant;
        }

        $approvisionnement->update(['montant' => $totalMontant]);

        return redirect()->route('boilerplate.approvisionnements.gerer')
                         ->with('success', 'Approvisionnement mis à jour avec succès.');
    }



    public function destroy($id_approvisionnement)
    {
        $approvisionnement = Approvisionnement::findOrFail($id_approvisionnement);
        $approvisionnement->matieresPremieres()->detach();
        $approvisionnement->delete();

        return redirect()->route('boilerplate.approvisionnements.gerer')
                         ->with('success', 'Approvisionnement supprimé avec succès.')
                         ->withHeaders(['Refresh' => '3;url='.route('boilerplate.approvisionnements.gerer')]);
    }

    public function statistiques()
    {
        $now = Carbon::now();

        $approvisionnementsEnAttenteApprobation = Approvisionnement::where('status', 'en attente d\'approbation')->count();
        $approvisionnementsEnAttenteLivraison = Approvisionnement::where('status', 'en attente de livraison')->count();
        $approvisionnementsEffectueCeMois = Approvisionnement::whereMonth('created_at', $now->month)
                                                            ->whereYear('created_at', $now->year)
                                                            ->count();

        return view('boilerplate::approvisionnements.statistiques', compact(
            'approvisionnementsEnAttenteApprobation',
            'approvisionnementsEnAttenteLivraison',
            'approvisionnementsEffectueCeMois'
        ));
    }
}
