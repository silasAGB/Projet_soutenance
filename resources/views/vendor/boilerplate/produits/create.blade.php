@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::produits.title'),
    'subtitle' => __('boilerplate::produits.create.title'),
    'breadcrumb' => [
        __('boilerplate::produits.title') => 'boilerplate.produits.index',
        __('boilerplate::produits.create.title')
    ]
])

@section('content_header')
    <h1>Ajouter un Produit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.produits.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="reference_produit">Référence</label>
                    <input type="text" id="reference_produit" name="reference_produit" class="form-control" required>
                    @error('reference_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nom_produit">Nom</label>
                    <input type="text" id="nom_produit" name="nom_produit" class="form-control" required>
                    @error('nom_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description_produit">Description</label>
                    <textarea id="description_produit" name="description_produit" class="form-control"></textarea>
                    @error('description_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prix_details_produit">Prix de Détail</label>
                    <input type="number" id="prix_details_produit" name="prix_details_produit" class="form-control" required>
                    @error('prix_details_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prix_gros_produit">Prix de Gros</label>
                    <input type="number" id="prix_gros_produit" name="prix_gros_produit" class="form-control">
                    @error('prix_gros_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_preparation">Quantité de Préparation</label>
                    <input type="number" id="qte_preparation" name="qte_preparation" class="form-control">
                    @error('qte_preparation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_lot">Quantité de Lot</label>
                    <input type="number" id="qte_Lot" name="qte_Lot" class="form-control">
                    @error('qte_Lot')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_stock">Quantité en Stock</label>
                    <input type="number" id="qte_stock" name="qte_stock" class="form-control" required>
                    @error('qte_stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock_min">Stock Minimum</label>
                    <input type="number" id="stock_min" name="stock_min" class="form-control">
                    @error('stock_min')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emplacement">Emplacement</label>
                    <input type="text" id="emplacement" name="emplacement" class="form-control">
                    @error('emplacement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_Categorie">Catégorie</label>
                    <select id="id_Categorie" name="id_Categorie" class="form-control" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id_Categorie }}">{{ $categorie->nom_Categorie }}</option>
                        @endforeach
                    </select>
                    @error('id_Categorie')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>
@stop
