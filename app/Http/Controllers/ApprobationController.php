<?php

namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Production;
use Illuminate\Http\Request;

class ApprobationController extends Controller
{
    public function index()
    {
        $productions = Production::where('statut', 'En attente d\'approbation')->get();
        $approvisionnements = Approvisionnement::where('statut', 'en attente d\'approbation')->get();

        return view('boilerplate::approbations.gerer', compact('productions', 'approvisionnements'));
    }

    public function validerProduction($id)
    {
        $production = Production::findOrFail($id);
        $production->statut = 'En attente de production';
        $production->save();

        return redirect()->route('boilerplate.approbations.gerer')->with('success', 'Production validée avec succès.');
    }

    public function refuserProduction(Request $request, $id)
    {
        $request->validate([
            'raison' => 'nullable|string|max:255', // Changer 'required' en 'nullable'
        ]);

        $production = Production::findOrFail($id);
        $production->statut = 'Annulé';
        $production->raison_refus = $request->raison; // La raison peut être null
        $production->save();

        return redirect()->route('boilerplate.approbations.gerer')->with('success', 'Production refusée avec succès.');
    }

    public function validerApprovisionnement($id)
    {
        $approvisionnement = Approvisionnement::findOrFail($id);
        $approvisionnement->statut = 'en attente de livraison';
        $approvisionnement->save();

        return redirect()->route('boilerplate.approbations.gerer')->with('success', 'Approvisionnement validé avec succès.');
    }

    public function refuserApprovisionnement(Request $request, $id)
    {
        $request->validate([
            'raison' => 'nullable|string|max:255', // Changer 'required' en 'nullable'
        ]);

        $approvisionnement = Approvisionnement::findOrFail($id);
        $approvisionnement->statut = 'Annulé';
        $approvisionnement->raison_refus = $request->raison; // La raison peut être null
        $approvisionnement->save();

        return redirect()->route('boilerplate.approbations.gerer')->with('success', 'Approvisionnement refusé avec succès.');
    }
}
