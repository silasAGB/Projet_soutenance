<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Production;
use App\Models\Approvisionnement;

class ApprobationController extends Controller
{
    public function index()
    {
        $productions = Production::where('statut', 'en attente d\'approbation')->get();
        $approvisionnements = Approvisionnement::where('statut', 'en attente d\'approbation')->get();

        return view('approbations.index', compact('productions', 'approvisionnements'));
    }

    public function approve(Request $request)
    {
        // Logique pour approuver l'item
        if ($request->type === 'production') {
            $item = Production::find($request->id);
        } else {
            $item = Approvisionnement::find($request->id);
        }
        $item->statut = 'approuvé';
        $item->save();

        return redirect()->route('approbations.index')->with('success', 'Approbation réussie!');
    }

    public function refuse(Request $request)
    {
        // Logique pour refuser l'item avec raison
        if ($request->type === 'production') {
            $item = Production::find($request->id);
        } else {
            $item = Approvisionnement::find($request->id);
        }
        $item->statut = 'refusé';
        // Ajouter la raison du refus
        $item->raison_refus = $request->raison_refus;
        $item->save();

        return redirect()->route('approbations.index')->with('success', 'Refus réussi!');
    }
}


