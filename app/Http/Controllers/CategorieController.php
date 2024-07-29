<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('boilerplate::categories.list', compact('categories'));
    }

    public function create()
    {
        return view('boilerplate::categories.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'code_categorie' => 'required|unique:categories,code_Categorie',
        'nom_categorie' => 'required',
    ]);

    $categorie = Categorie::create([
        'code_Categorie' => $validatedData['code_categorie'],
        'nom_Categorie' => $validatedData['nom_categorie'],
    ]);

    return redirect()->route('boilerplate.categories.index')->with('success', 'Catégorie créée avec succès.');
}


    public function edit($id_Categorie)
    {
        $categorie = Categorie::findOrFail($id_Categorie);
        return view('boilerplate::categories.edit', compact('categorie'));
    }

// CategorieController.php

public function update(Request $request, $id_Categorie)
{
    $request->validate([
        'code_Categorie' => 'required|unique:categories,code_Categorie,'.$id_Categorie,
        'nom_Categorie' => 'required',
    ]);

    $categorie = Categorie::findOrFail($id_Categorie);
    $categorie->update($request->only(['code_Categorie', 'nom_Categorie']));

    return redirect()->route('boilerplate.categories.index', $categorie)
                     ->with('growl', ["Catégorie mise à jour avec succès.", 'success']);
}

    public function destroy($id_Categorie)
    {
        $categorie = Categorie::findOrFail($id_Categorie);

        $categorie->delete();

        return redirect()->route('boilerplate.categories.index')
        ->with('growl', ["Catgorie supprimé avec succès.", 'success']);
    }
}
