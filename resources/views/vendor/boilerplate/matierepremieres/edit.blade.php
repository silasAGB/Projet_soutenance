@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::matierepremieres.title'),
    'subtitle' => __('boilerplate::matierepremieres.edit.title'),
    'breadcrumb' => [
        __('boilerplate::matierepremieres.title') => 'boilerplate.matierepremieres.index',
        __('boilerplate::matierepremieres.edit.title')
    ]
])

@section('content_header')
    <h1>Modifier la Matière Première</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.matierepremieres.update', $matierePremiere->id_MP) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom_MP">Nom</label>
                    <input type="text" id="nom_MP" name="nom_MP" class="form-control" value="{{ $matierePremiere->nom_MP }}" required>
                    @error('nom_MP')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prix_achat">Prix d'Achat</label>
                    <input type="number" id="prix_achat" name="prix_achat" class="form-control" value="{{ $matierePremiere->prix_achat }}" required>
                    @error('prix_achat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="unite">Unité</label>
                    <input type="text" id="unite" name="unite" class="form-control" value="{{ $matierePremiere->unite }}" required>
                    @error('unite')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_stock">Quantité en Stock</label>
                    <input type="number" id="qte_stock" name="qte_stock" class="form-control" value="{{ $matierePremiere->qte_stock }}" required>
                    @error('qte_stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock_min">Stock Minimum</label>
                    <input type="number" id="stock_min" name="stock_min" class="form-control" value="{{ $matierePremiere->stock_min }}" required>
                    @error('stock_min')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emplacement">Emplacement</label>
                    <input type="text" id="emplacement" name="emplacement" class="form-control" value="{{ $matierePremiere->emplacement }}" required>
                    @error('emplacement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_categorie">Catégorie</label>
                    <select id="id_categorie" name="id_categorie" class="form-control" required>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id_Categorie }}" {{ $matierePremiere->id_Categorie == $categorie->id_Categorie ? 'selected' : '' }}>{{ $categorie->nom_Categorie }}</option>
                        @endforeach
                    </select>
                    @error('id_Categorie')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
@stop
