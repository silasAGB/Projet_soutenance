<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Fournisseur;
use App\Models\MatierePremiere;
use App\Models\MouvementMp;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ApprovisionnementController extends Controller
{
    public function index()
    {

        $now = Carbon::now();
        $approvisionnementsEnAttenteApprobation = Approvisionnement::where('statut', 'en attente d\'approbation')->count();
        $approvisionnementsEnAttenteLivraison = Approvisionnement::where('statut', 'en attente de livraison')->count();
        $approvisionnementsEffectueCeMois = Approvisionnement::whereMonth('created_at', $now->month)
                                                            ->whereYear('created_at', $now->year)
                                                            ->count();



        $approvisionnements = Approvisionnement::with(['matieresPremieres', 'matieresPremieres.fournisseurs'])->get();
        return view('boilerplate::approvisionnements.gerer', compact('approvisionnements', 'approvisionnementsEnAttenteApprobation',
            'approvisionnementsEnAttenteLivraison',
            'approvisionnementsEffectueCeMois'));
    }

    public function show($id_approvisionnement)
    {
        $approvisionnement = Approvisionnement::with(['matieresPremieres', 'matieresPremieres.fournisseurs'])->findOrFail($id_approvisionnement);
        $statuts = ['en attente d\'approbation', 'en attente de livraison', 'livré', 'Terminé'];

        return view('boilerplate::approvisionnements.details', compact('approvisionnement', 'statuts'));
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
            'date_approvisionnement' => 'required|date|after_or_equal:today',
            'matieresPremieres.*.id_MP' => 'required|exists:matiere_premieres,id_MP|distinct',
            'matieresPremieres.*.id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
            'matieresPremieres.*.qte_approvisionnement' => 'required|numeric',
        ]);

        $dateApprovisionnement = Carbon::parse($request->date_approvisionnement);
        $mois = $dateApprovisionnement->format('m');
        $annee = $dateApprovisionnement->format('Y');
        $nombreApprovisionnement = Approvisionnement::whereYear('date_approvisionnement', $dateApprovisionnement->year)
            ->whereMonth('date_approvisionnement', $dateApprovisionnement->month)
            ->count() + 1;

        $reference_approvisionnement = 'Appro - ' . $mois . $annee. str_pad($nombreApprovisionnement, 3, '0', STR_PAD_LEFT); // Inclure le mois et le nombre avec remplissage

        $approvisionnement = Approvisionnement::create([
            'date_approvisionnement' => $request->date_approvisionnement,
            'reference_approvisionnement' => $reference_approvisionnement,
            'statut' => 'en attente d\'approbation',
        ]);

        $totalMontant = 0;

        foreach ($request->matieresPremieres as $matiere) {
            $prixAchat = Fournisseur::find($matiere['id_fournisseur'])->matieresPremieres()->where('matiere_premieres.id_MP', $matiere['id_MP'])->first()->pivot->prix_achat;
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
        $approvisionnement = Approvisionnement::with(['matieresPremieres', 'matieresPremieres.fournisseurs', ])->findOrFail($id_approvisionnement);

        if (in_array($approvisionnement->statut, ['livré', 'Terminé'])) {
            return redirect()->route('boilerplate.approvisionnements.gerer')
                             ->with('growl', [__('Impossible de modifier un approvisionnement qui est déjà livré ou terminé.'), 'error']);
        }

        $fournisseurs = Fournisseur::all();
        $matieresPremieres = MatierePremiere::all();
        $statuts = ['en attente d\'approbation', 'en attente de livraison', 'livré', 'Terminé'];

        return view('boilerplate::approvisionnements.edit', compact('approvisionnement', 'fournisseurs', 'matieresPremieres', 'statuts', ));
    }

    public function update(Request $request, $id_approvisionnement)
{
    $request->validate([
        'date_approvisionnement' => 'required|date',
        'reference_approvisionnement' => 'required|string|max:255',
        'matieresPremieres.*.id_MP' => 'required|exists:matiere_premieres,id_MP|distinct',
        'matieresPremieres.*.id_fournisseur' => 'required|exists:fournisseurs,id_fournisseur',
        'matieresPremieres.*.qte_approvisionnement' => 'required|numeric',
        'matieresPremieres.*.date_livraison' => 'nullable|date',
        'matieresPremieres.*.qte_livree' => 'nullable|numeric',
    ]);

    $approvisionnement = Approvisionnement::findOrFail($id_approvisionnement);
    if (in_array($approvisionnement->statut, ['livré', 'Terminé'])) {
        return redirect()->route('boilerplate.approvisionnements.gerer')
                         ->with('error', 'Impossible de modifier un approvisionnement qui est déjà livré ou terminé.');
    }

    $ancienStatut = $approvisionnement->statut;
    $approvisionnement->update([
        'date_approvisionnement' => $request->date_approvisionnement,
        'reference_approvisionnement' => $request->reference_approvisionnement,
        'statut' => $request->statut,
    ]);

    $approvisionnement->matieresPremieres()->detach();
    $totalMontant = 0;
    $derniereDateLivraison = null;

    foreach ($request->matieresPremieres as $matiere) {
        $prixAchat = Fournisseur::find($matiere['id_fournisseur'])->matieresPremieres()->where('matiere_premieres.id_MP', $matiere['id_MP'])->first()->pivot->prix_achat;
        $montant = $matiere['qte_approvisionnement'] * $prixAchat;
        $approvisionnement->matieresPremieres()->attach($matiere['id_MP'], [
            'id_fournisseur' => $matiere['id_fournisseur'],
            'qte_approvisionnement' => $matiere['qte_approvisionnement'],
            'statut' => $matiere['statut'],
            'qte_livree' => $matiere['qte_livree'] ?? 0,
            'date_livraison' => $matiere['date_livraison'] ?? null,
            'montant' => $montant,
        ]);
        $totalMontant += $montant;

    }



    // Mise à jour du montant total
    $approvisionnement->update(['montant' => $totalMontant]);

    // Mise à jour de la date de livraison si le statut est "livré"
    if ($request->statut === 'livré' && $derniereDateLivraison) {

                // Vérifiez la dernière date de livraison
                if ($matiere['date_livraison'] && (!$derniereDateLivraison || Carbon::parse($matiere['date_livraison'])->isAfter($derniereDateLivraison))) {
                    $derniereDateLivraison = Carbon::parse($matiere['date_livraison']);
                }

        $approvisionnement->update(['date_livraison' => $derniereDateLivraison]);
    }

    // Mise à jour du stock de matières premières si le statut est "Livré" ou "Terminé"
    foreach ($request->matieresPremieres as $matiere) {
        if ($matiere['statut'] === 'livrée') {
            $matierePremiere = MatierePremiere::find($matiere['id_MP']);
            $mouvementExiste = MouvementMp::where('id_MP', $matiere['id_MP'])
                ->where('id_approvisionnement', $approvisionnement->id_approvisionnement)
                ->exists();
            if (!$mouvementExiste) {
                $matierePremiere->qte_stock += $matiere['qte_livree'];
                $matierePremiere->save();
                MouvementMp::create([
                    'id_MP' => $matiere['id_MP'],
                    'id_approvisionnement' => $approvisionnement->id_approvisionnement,
                    'type' => 'entrée',
                    'quantité' => $matiere['qte_livree'],
                    'stock_disponible' => $matierePremiere->qte_stock,
                    'date_mouvement' => now(),
                ]);
            }
        }
    }

    return redirect()->route('boilerplate.approvisionnements.gerer')
                     ->with('success', 'Approvisionnement mis à jour avec succès.');
}

    public function destroy($id_approvisionnement)
    {
        $approvisionnement = Approvisionnement::findOrFail($id_approvisionnement);

        if (in_array($approvisionnement->statut, ['livré', 'Terminé'])) {
            return redirect()->route('boilerplate.approvisionnements.gerer')
                             ->with('growl', [__('Impossible de supprimer un approvisionnement qui est déjà livré ou terminé.'), 'error']);
        }

        $approvisionnement->matieresPremieres()->detach();
        $approvisionnement->delete();

        return redirect()->route('boilerplate.approvisionnements.gerer')
                         ->with('growl', [__('Approvisionnement supprimé avec succès.'), 'success']);
    }

    public function downloadBonDeCommande($id_approvisionnement)
{
    $approvisionnement = Approvisionnement::with(['matieresPremieres', 'matieresPremieres.fournisseurs'])->findOrFail($id_approvisionnement);

    // Regrouper les matières premières par fournisseur
    $bonsDeCommande = [];

    foreach ($approvisionnement->matieresPremieres as $matiere) {
        $fournisseurId = $matiere->pivot->id_fournisseur;
        if (!isset($bonsDeCommande[$fournisseurId])) {
            $bonsDeCommande[$fournisseurId] = [
                'fournisseur' => $matiere->fournisseurs->first(),
                'matieres' => [],
                'date_approvisionnement' => $approvisionnement->date_approvisionnement,
            ];
        }
        $bonsDeCommande[$fournisseurId]['matieres'][] = $matiere;
    }

    // Générer le PDF ou le document de bon de commande
    // Vous pouvez utiliser une bibliothèque comme Dompdf ou Snappy pour générer le PDF
    // Exemple avec Dompdf
    $pdf = PDF::loadView('boilerplate::approvisionnements.bons_de_commande', compact('bonsDeCommande'));

    return $pdf->download('bons_de_commande' . $approvisionnement->reference_approvisionnement . '.pdf');
}

}
