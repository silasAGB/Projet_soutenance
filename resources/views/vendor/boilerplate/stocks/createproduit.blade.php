@extends('boilerplate::layout.index', [
    'title' => 'Créer Produit',
    'breadcrumb' => ['Créer Produit']
])

@section('content')
    <form role="form" action="{{ route('stocks.produits.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="reference_Produit">Référence du produit</label>
                <input type="text" class="form-control" id="reference_Produit" name="reference_Produit" placeholder="Référence du produit" required>
            </div>
            <div class="form-group">
                <label for="nom_Produit">Nom du produit</label>
                <input type="text" class="form-control" id="nom_Produit" name="nom_Produit" placeholder="Nom du produit" required>
            </div>
            <div class="form-group">
                <label for="description_Produit">Description du produit</label>
                <textarea class="form-control" id="description_Produit" name="description_Produit" placeholder="Description du produit"></textarea>
            </div>
            <div class="form-group">
                <label for="prix_details_Produit">Prix de détail</label>
                <input type="number" step="0.01" class="form-control" id="prix_details_Produit" name="prix_details_Produit" placeholder="Prix de détail" required>
            </div>
            <div class="form-group">
                <label for="prix_gros_Produit">Prix de gros</label>
                <input type="number" step="0.01" class="form-control" id="prix_gros_Produit" name="prix_gros_Produit" placeholder="Prix de gros">
            </div>
            <div class="form-group">
                <label for="prix_Preparation">Prix de préparation</label>
                <input type="number" step="0.01" class="form-control" id="prix_Preparation" name="prix_Preparation" placeholder="Prix de préparation">
            </div>
            <div class="form-group">
                <label for="qte_Lot">Quantité par lot</label>
                <input type="number" class="form-control" id="qte_Lot" name="qte_Lot" placeholder="Quantité par lot">
            </div>
            <div class="form-group">
                <label for="qte_Stock">Quantité en stock</label>
                <input type="number" class="form-control" id="qte_Stock" name="qte_Stock" placeholder="Quantité en stock" required>
            </div>
            <div class="form-group">
                <label for="stock_min">Stock minimum</label>
                <input type="number" class="form-control" id="stock_min" name="stock_min" placeholder="Stock minimum">
            </div>
            <div class="form-group">
                <label for="emplacement">Emplacement</label>
                <input type="text" class="form-control" id="emplacement" name="emplacement" placeholder="Emplacement">
            </div>
            <div class="form-group">
                <label for="id_categorie">Catégorie</label>
                <select class="form-control" id="id_categorie" name="id_categorie" required>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id_categorie }}">{{ $categorie->nom_categorie }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="text-right">
            <a href="{{ route('stocks.produits') }}" class="btn btn-default" data-toggle="tooltip" title="Retour à la liste des produits">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
@endsection
