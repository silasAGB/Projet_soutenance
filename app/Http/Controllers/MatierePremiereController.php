<?php

namespace App\Http\Controllers;

use App\Models\MatierePremiere;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Models\MouvementMp;
use App\Mail\StockAlert;
use Illuminate\Support\Facades\Mail;
use App\Models\StockAlertLog;
use Illuminate\Support\Facades\Log;

class MatierePremiereController extends Controller
{
    public function index()
    {
        $matieresPremieres = MatierePremiere::all();
        return view('boilerplate::matierepremieres.list', compact('matieresPremieres'));
    }

    public function create()
    {
        $categories = Categorie::all();
        return view('boilerplate::matierepremieres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_MP' => 'required',
            'prix_achat' => 'required|numeric',
            'unite' => 'required',
            'qte_stock' => 'required|numeric',
            'stock_min' => 'required|numeric',
            'emplacement' => 'required|string',
            'id_categorie' => 'required|exists:categories,id_categorie',
        ]);

        $matierePremiere = MatierePremiere::create($request->all());

        // Enregistrer le mouvement de stock
        MouvementMp::create([
            'id_MP' => $matierePremiere->id_MP,
            'type' => 'entrée',
            'quantité' => $matierePremiere->qte_stock,
            'stock_disponible' => $matierePremiere->qte_stock,
            'date_mouvement' => now(),
        ]);

        // Ajouter un log détaillé
    Log::channel('stack')->info('Matière première ajoutée', [
        'action' => 'Ajout',
        'matiere_premiere' => $matierePremiere->nom_MP,
        'id_mp' => $matierePremiere->id_MP,
        'quantité_stock' => $matierePremiere->qte_stock,
        'utilisateur' => auth()->user()->name ?? 'Système',
        'heure' => now()->toDateTimeString(),
    ]);

        // Vérifier si le stock est déjà sous le seuil minimum
        $this->checkAndSendStockAlert($matierePremiere);

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première ajoutée avec succès.');
    }

    public function show($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        return view('boilerplate::matierepremieres.show', compact('matierePremiere'));
    }

    public function edit($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('boilerplate::matierepremieres.edit', compact('matierePremiere', 'categories', 'fournisseurs'));
    }

    public function update(Request $request, $id_MP)
    {
        $request->validate([
            'nom_MP' => 'required',
            'unite' => 'required',
            'qte_stock' => 'required|numeric',
            'stock_min' => 'required|numeric',
            'emplacement' => 'required|string',
            'id_categorie' => 'required|exists:categories,id_categorie',
        ]);

        $matierePremiere = MatierePremiere::findOrFail($id_MP);
        $matierePremiere->update($request->all());

        $fournisseurs = $request->input('fournisseurs', []);
        $matierePremiere->fournisseurs()->sync([]);
        foreach ($fournisseurs as $fournisseur) {
            $matierePremiere->fournisseurs()->attach($fournisseur['id'], ['prix_achat' => $fournisseur['prix_achat']]);
        }

        // Ajouter un log détaillé
    Log::channel('stack')->info('Matière première modifiée', [
        'action' => 'Modification',
        'matiere_premiere' => $matierePremiere->nom_MP,
        'id_mp' => $matierePremiere->id_MP,
        'quantité_stock' => $matierePremiere->qte_stock,
        'utilisateur' => auth()->user()->name ?? 'Système',
        'heure' => now()->toDateTimeString(),
    ]);

        // Vérifier si le stock est sous le seuil minimum après la mise à jour
        $this->checkAndSendStockAlert($matierePremiere);

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première mise à jour avec succès.');
    }

    public function destroy($id_MP)
    {
        $matierePremiere = MatierePremiere::findOrFail($id_MP);

        // Ajouter un log détaillé
    Log::channel('stack')->info('Matière première supprimée', [
        'action' => 'Suppression',
        'matiere_premiere' => $matierePremiere->nom_MP,
        'id_mp' => $matierePremiere->id_MP,
        'utilisateur' => auth()->user()->name ?? 'Système',
        'heure' => now()->toDateTimeString(),
    ]);

        $matierePremiere->delete();

        return redirect()->route('boilerplate.matierepremieres.index')
            ->with('success', 'Matière première supprimée avec succès.');
    }

    public function miseAJourStock($id, $quantité, $type)
    {
        $matierePremiere = MatierePremiere::findOrFail($id);

        if ($type === 'entrée') {
            $matierePremiere->qte_stock += $quantité;
        } elseif ($type === 'sortie') {
            $matierePremiere->qte_stock -= $quantité;
        }

        $matierePremiere->save();

        // Enregistrer le mouvement
        MouvementMp::create([
            'id_MP' => $matierePremiere->id,
            'type' => $type,
            'quantité' => $quantité,
            'stock_disponible' => $matierePremiere->qte_stock,
            'date_mouvement' => now(),
        ]);

        // Vérifier si le stock est sous le seuil minimum après la mise à jour
        $this->checkAndSendStockAlert($matierePremiere);

        return redirect()->back()->with('success', 'Stock mis à jour avec succès');
    }

    // Méthode pour vérifier et envoyer des alertes de stock
    private function checkAndSendStockAlert(MatierePremiere $matierePremiere)
    {
        if ($matierePremiere->qte_stock <= $matierePremiere->stock_min) {
            // Vérifier si une alerte a déjà été envoyée aujourd'hui pour cette matière
            $lastAlert = StockAlertLog::where('id_mp', $matierePremiere->id_MP)
                ->whereDate('created_at', today())
                ->first();

            if (!$lastAlert) {
                try {
                    Mail::to(config('mail.from.address'))->send(new StockAlert($matierePremiere));

                    // Enregistrer l'alerte dans les logs
                    StockAlertLog::create([
                        'id_mp' => $matierePremiere->id_MP,
                        'qte_stock' => $matierePremiere->qte_stock,
                        'stock_min' => $matierePremiere->stock_min,
                        'status' => 'sent'
                    ]);

                    Log::info("Alerte de stock envoyée pour {$matierePremiere->nom_MP}");

                    // Ajouter un message flash pour indiquer qu'une alerte a été envoyée
                    session()->flash('info', 'Une alerte de stock a été envoyée pour ' . $matierePremiere->nom_MP);
                } catch (\Exception $e) {
                    Log::error("Erreur lors de l'envoi de l'alerte pour {$matierePremiere->nom_MP}: " . $e->getMessage());

                    // Enregistrer l'échec dans les logs
                    StockAlertLog::create([
                        'id_mp' => $matierePremiere->id_MP,
                        'qte_stock' => $matierePremiere->qte_stock,
                        'stock_min' => $matierePremiere->stock_min,
                        'status' => 'failed',
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
    }
}
