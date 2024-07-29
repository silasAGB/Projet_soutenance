<?php
namespace App\Http\Controllers;

use App\Models\Approvisionnement;
use App\Models\Production;
use Illuminate\Http\Request;

class ApprobationController extends Controller
{
    public function index()
    {
        $approvisionnements = Approvisionnement::where('status', 'en attente d\'approbation')->get();
        $productions = Production::where('statut', 'en attente d\'approbation')->get(); // Assurez-vous d'utiliser le bon nom de colonne ici

        return view('boilerplate::approbations.index', compact('approvisionnements', 'productions'));
    }

    public function approuvé($id, $type)
    {
        if ($type === 'production') {
            $production = Production::findOrFail($id);
            $production->statut = 'en attente de production';
            $production->save();
        } elseif ($type === 'approvisionnement') {
            $approvisionnement = Approvisionnement::findOrFail($id);
            $approvisionnement->status = 'en attente de livraison';
            $approvisionnement->save();
        }

        return redirect()->route('approbations.index')->with('success', 'L\'approbation a été approuvée avec succès.');
    }

    public function rejeté($id, $type)
    {
        if ($type === 'production') {
            $production = Production::findOrFail($id);
            $production->statut = 'rejeté';
            $production->save();
        } elseif ($type === 'approvisionnement') {
            $approvisionnement = Approvisionnement::findOrFail($id);
            $approvisionnement->status = 'rejeté';
            $approvisionnement->save();
        }

        return redirect()->route('approbations.index')->with('success', 'L\'approbation a été rejetée avec succès.');
    }
}

