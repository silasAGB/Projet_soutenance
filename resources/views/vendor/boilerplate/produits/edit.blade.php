@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::produits.title'),
    'subtitle' => __('boilerplate::produits.edit.title'),
    'breadcrumb' => [
        __('boilerplate::produits.title') => 'boilerplate.produits.index',
        __('boilerplate::produits.edit.title')
    ]
])

@section('content_header')
    <h1>Modifier le Produit</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.produits.update', $produit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="reference_produit">Référence</label>
                    <input type="text" id="reference_produit" name="reference_produit" class="form-control" value="{{ $produit->reference_produit }}" required>
                    @error('reference_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nom_produit">Nom</label>
                    <input type="text" id="nom_produit" name="nom_produit" class="form-control" value="{{ $produit->nom_produit }}" required>
                    @error('nom_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description_produit">Description</label>
                    <textarea id="description_produit" name="description_produit" class="form-control">{{ $produit->description_produit }}</textarea>
                    @error('description_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prix_details_produit">Prix de Détail</label>
                    <input type="number" id="prix_details_produit" name="prix_details_produit" class="form-control" value="{{ $produit->prix_details_produit }}" required>
                    @error('prix_details_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prix_gros_produit">Prix de Gros</label>
                    <input type="number" id="prix_gros_produit" name="prix_gros_produit" class="form-control" value="{{ $produit->prix_gros_produit }}">
                    @error('prix_gros_produit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_preparation">Quantité de Préparation</label>
                    <input type="number" id="qte_preparation" name="qte_preparation" class="form-control" value="{{ $produit->qte_preparation }}">
                    @error('qte_preparation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_lot">Quantité de Lot</label>
                    <input type="number" id="qte_lot" name="qte_lot" class="form-control" value="{{ $produit->qte_lot }}">
                    @error('qte_lot')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="qte_stock">Quantité en Stock</label>
                    <input type="number" id="qte_stock" name="qte_stock" class="form-control" value="{{ $produit->qte_stock }}" required>
                    @error('qte_stock')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock_min">Stock Minimum</label>
                    <input type="number" id="stock_min" name="stock_min" class="form-control" value="{{ $produit->stock_min }}">
                    @error('stock_min')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="emplacement">Emplacement</label>
                    <input type="text" id="emplacement" name="emplacement" class="form-control" value="{{ $produit->emplacement }}">
                    @error('emplacement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_categorie">Catégorie</label>
                    <select id="id_categorie" name="id_categorie" class="form-control" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id_Categorie }}" {{ $categorie->id_Categorie == $produit->id_categorie ? 'selected' : '' }}>{{ $categorie->nom_Categorie }}</option>
                        @endforeach
                    </select>
                    @error('id_categorie')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>
@stop
