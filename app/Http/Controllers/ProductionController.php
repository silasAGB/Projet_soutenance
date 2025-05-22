<?php

namespace App\Http\Controllers;

use App\Models\MatierePremiere;
use App\Models\MouvementMp;
use App\Models\MouvementProduit;
use App\Models\Production;
use App\Models\Produit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::with('produit')->get();

        $now = Carbon::now();
        $productionEnAttentDeApprobation = Production::with('statut')
            ->where('statut', 'En attente d\'approbation')
            ->count();
        $productionEnAttente = Production::where('statut', 'En attente de production')->count();
        $productionEnCours = Production::where('statut', 'En cours de production')->count();
        $productionEffectueCeMois = Production::where('statut', 'Terminé')
            ->whereMonth('date_production', $now->month)
            ->whereYear('date_production', $now->year)
            ->count();


        return view('boilerplate::productions.gerer', compact('productions','productionEnAttentDeApprobation', 'productionEnAttente', 'productionEnCours', 'productionEffectueCeMois'));
    }

    public function show($id_production)
{
    $production = Production::with(['produit', 'matieresPremieres'])->findOrFail($id_production);

    return view('boilerplate::productions.details', compact('production'));
}

    public function create()
    {
        $produits = Produit::all();
        return view('boilerplate::productions.create', compact('produits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produit' => 'required|exists:produits,id_produit',
            'date_prevue' => 'required|date|after_or_equal:today',
            'heure_prevue' => 'nullable|date_format:H:i',
            'qte_prevue' => 'required|numeric|min:0',
            'nbr_preparation' => 'nullable|numeric|min:0',
            'nom_personnel' => 'required|string|max:255',
            'consignes_specifiques' => 'nullable|string|max:1000',
            'autres_remarques' => 'nullable|string|max:1000',
        ]);

        // Récupérer les informations du produit
        $produit = Produit::with('matierePremieres')->findOrFail($request->id_produit);

        // Obtenir le mois et l'année de la date prévue
        $datePrevue = Carbon::parse($request->date_prevue);
        $mois = $datePrevue->format('m'); // Récupérer le mois au format 01 à 12
        $annee = $datePrevue->format('Y');

            // Calculer le nombre de productions déjà effectuées ce mois-ci
            $nombreProduction = Production::whereYear('date_prevue', $datePrevue->year)
                ->whereMonth('date_prevue', $datePrevue->month)
                ->count() + 1;

        // Calculer le nombre de productions déjà effectuées ce mois-ci
        $nombreProduction = Production::whereYear('date_prevue', $datePrevue->year)
        ->whereMonth('date_prevue', $datePrevue->month)
        ->count() + 1; // +1 pour la nouvelle production

        // Générer la référence de production
       // $referenceProduction = $produit->nom_produit . ' N°' . $nombreProduction . ' - ' . $mois . ' - ' . $annee;

       // Générer la référence de production
    //$nombreProduction = Production::count() + 1; // Compte total des productions
    $referenceProduction = 'PROD - ' . $mois . $annee. str_pad($nombreProduction, 3, '0', STR_PAD_LEFT); // Inclure le mois et le nombre avec remplissage

        // Créer la nouvelle production
        $production =Production::create([
            'reference_production' => $referenceProduction,
            'id_produit' => $request->id_produit,
            'date_prevue' => $request->date_prevue,
            'heure_prevue' => $request->heure_prevue,
            'qte_prevue' => $request->qte_prevue,
            'nbr_preparation' => $request->nbr_preparation ?? 1,
            'nom_personnel' => $request->nom_personnel,
            'consignes_specifiques' => $request->consignes_specifiques,
            'autres_remarques' => $request->autres_remarques,
            'statut' => 'en attente d\'approbation ',
        ]);

        foreach ($produit->matierePremieres as $matierePremiere) {
            $production->matieresPremieres()->attach($matierePremiere->id_MP, [
                'id_production' => $production->id_production,
                'qte' => $matierePremiere->pivot->qte * $request->nbr_preparation,
            ]);
        }

        return redirect()->route('boilerplate.productions.gerer')
            ->with('growl', [__('Production créée avec succès.'), 'success']);
    }

    public function edit($id)
    {

        $production = Production::with(['produit', 'matieresPremieres'])->findOrFail($id);

        // Empêcher l'édition si le statut est "Terminé"
        if ($production->statut === 'Terminé') {
            return redirect()->route('boilerplate.productions.gerer')
                ->with('growl', [__('Cette production est déjà terminée et ne peut plus être modifiée.'), 'danger']);


        }

        $produits = Produit::all();
        $matieresPremieres = MatierePremiere::all();
        return view('boilerplate::productions.edit', compact('production', 'produits', 'matieresPremieres'));
    }

    public function update(Request $request, $id)
    {
        $production = Production::findOrFail($id);


        // Empêcher la mise à jour si le statut est "Terminé"
        if ($production->statut === 'Terminé') {
            return redirect()->route('boilerplate.productions.gerer')
                ->with('growl', [__('Cette production est déjà en attente de production ou terminée et ne peut plus être modifiée.'), 'danger']);
        }

        $request->validate([
            'reference_production' => 'required|string|max:255',
            'id_produit' => 'required|exists:produits,id_produit',
            'date_prevue' => 'required|date',
            'heure_prevue' => 'nullable|date_format:H:i',
            'qte_prevue' => 'required|numeric|min:0',
            'nbr_preparation' => 'nullable|numeric|min:0',
            'nom_personnel' => 'required|string|max:255',
            'statut' => 'required|in:En attente d\'approbation,En attente de production,En cours de production,Terminé',
            'qte_produite' => 'required_if:statut,Terminé|nullable|numeric|min:0',
            'date_production' => 'required_if:statut,Terminé|nullable|date',
            'heure_production' => 'nullable|date_format:H:i|required_if:statut,Terminé',
            'consignes_specifiques' => 'nullable|string|max:1000',
            'autres_remarques' => 'nullable|string|max:1000',
        ]);

        $data = [
            'reference_production' => $request->reference_production,
            'id_produit' => $request->id_produit,
            'date_prevue' => $request->date_prevue,
            'heure_prevue' => $request->heure_prevue,
            'qte_prevue' => $request->qte_prevue,
            'nbr_preparation' => $request->nbr_preparation ?? 1,
            'nom_personnel' => $request->nom_personnel,
            'statut' => $request->statut,
            'consignes_specifiques' => $request->consignes_specifiques,
            'autres_remarques' => $request->autres_remarques,
        ];

        if ($request->statut === 'Terminé') {
            $data['qte_produite'] = $request->qte_produite;
            $data['date_production'] = $request->date_production;
            $data['heure_production'] = $request->heure_production;

             // Calculer les avaries
        $avaries = $request->qte_prevue - $request->qte_produite;
        $data['avaries'] = max(0, $avaries); // Assurez-vous que les avaries ne soient pas négatives

            // Mise à jour de la quantité en stock du produit
            $produit = Produit::findOrFail($request->id_produit);
            $produit->qte_stock += $request->qte_produite;
            $produit->save();

            // Enregistrer le mouvement de stock pour le produit
            MouvementProduit::create([
                'id_produit' => $produit->id_produit,
                'type' => 'entrée',
                'quantité' => $request->qte_produite,
                'stock_disponible' => $produit->qte_stock,
                'date_mouvement' => now(),
            ]);

            // Diminuer les quantités de matières premières utilisées
            $matieresPremieres = $production->matieresPremieres; // Récupérer les matières premières associées à cette production
            foreach ($matieresPremieres as $matierePremiere) {
                $quantiteUtilisee = $matierePremiere->pivot->qte; // Calculer la quantité utilisée
                $matierePremiereModel = MatierePremiere::findOrFail($matierePremiere->id_MP);
                $matierePremiereModel->qte_stock -= $quantiteUtilisee; // Diminuer la quantité en stock
                $matierePremiereModel->save(); // Sauvegarder les modifications

                // Enregistrer le mouvement de stock
                MouvementMp::create([
                    'id_MP' => $matierePremiereModel->id_MP,
                    'type' => 'sortie',
                    'quantité' => $quantiteUtilisee,
                    'stock_disponible' => $matierePremiereModel->qte_stock,
                    'date_mouvement' => now(),
                ]);
            }
        } else {
            $data['qte_produite'] = null;
            $data['date_production'] = null;
            $data['heure_production'] = null;
        }



        $production->update($data);

        return redirect()->route('boilerplate.productions.gerer')
            ->with('growl', [__('Production mise à jour avec succès.'), 'success']);
    }

    public function destroy($id)
    {
        $production = Production::findOrFail($id);

        // Empêcher la suppression si le statut est "Terminé"
        if ($production->statut === 'Terminé') {
            return redirect()->route('boilerplate.productions.gerer')
                ->with('growl', [__('Cette production est déjà terminée et ne peut plus être supprimée.'), 'danger']);
        }

        $production->delete();
        return redirect()->route('boilerplate.productions.gerer')
            ->with('growl', [__('Production supprimée avec succès.'), 'success']);
    }
}
