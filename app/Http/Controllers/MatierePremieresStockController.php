<?php

namespace App\Http\Controllers;
use App\Models\MatierePremiere;
use Illuminate\Http\Request;

class MatierePremieresStockController extends Controller
{
    public function index()
    {
        $matierePremieres = MatierePremiere::all();
        $lowStockMatierePremieres = MatierePremiere::whereColumn('qte_stock', '<=', 'stock_min')->get();
        return view('boilerplate::stocks.matierepremieres', compact('matierePremieres', 'lowStockMatierePremieres'));
    }
}
