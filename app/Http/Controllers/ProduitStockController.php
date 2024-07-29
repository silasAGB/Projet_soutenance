<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;


class ProduitStockController extends Controller
{
    public function index()
    {
        $produits = Produit::all();
        $lowStockProducts = Produit::whereColumn('qte_stock', '<=', 'stock_min')->get();
        return view('boilerplate::stocks.produits', compact('produits', 'lowStockProducts'));
    }
}
