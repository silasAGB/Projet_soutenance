<?php

namespace App\Http\Controllers;

use App\Models\MatierePremiere;
use Illuminate\Http\Request;
use Doctrine\DBAL\Schema\Index;
use Sebastienheyd\Boilerplate\Middleware\BoilerplateGuest;

class RapportController extends Controller
{
    public function index()
    {
        return view('stocks.matiere_premieres.index', compact('matierePremieres', 'lowStockMatierePremieres'));
    }
}
