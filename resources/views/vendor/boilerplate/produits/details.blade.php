@extends('boilerplate::layout.index', [
    'title' => __('Détails du produit'),
    'subtitle' => __('Voir les détails du produit'),
    'breadcrumb' => [
        __('Produits') => 'boilerplate.produits.index',
        __('Détails')
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('boilerplate.produits.index') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste')">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <a href="{{ route('boilerplate.produits.index', $produit->id_produit) }}" class="btn btn-primary float-right" data-toggle="tooltip" title="@lang('Télécharger les détails du produit')">
                <span class="fas fa-download"></span>
            </a>
        </div>
    </div>

    @component('boilerplate::card')
    <div class="row">
        <div class="col-12">
            <h3>@lang('Détails du Produit')</h3>
            <span class="float-right pb-1">
                <a href="{{ route('boilerplate.produits.edit', $produit->id_produit) }}" class="btn btn-primary">
                    @lang('Modifier le produit')
                </a>
            </span>
            <p><strong>@lang('Référence'):</strong> {{ $produit->reference_produit }}</p>
            <p><strong>@lang('Nom'):</strong> {{ $produit->nom_produit }}</p>
            <p><strong>@lang('Catégorie'):</strong> {{ $produit->categorie->nom_Categorie ?? 'Non défini' }}</p>
            <p><strong>@lang('Prix de détail'):</strong> {{ number_format($produit->prix_details_produit, 2) }} FCFA</p>
            <p><strong>@lang('Prix en gros'):</strong> {{ $produit->prix_gros_produit ? number_format($produit->prix_gros_produit, 2) . ' FCFA' : 'Non défini' }}</p>
            <p><strong>@lang('Quantité en stock'):</strong> {{ $produit->qte_stock }}</p>
            <p><strong>@lang('Stock Minimum'):</strong> {{ $produit->stock_min }}</p>
            <p><strong>@lang('Emplacement'):</strong> {{ $produit->Emplacement ?? 'Non défini' }}</p>
            <p><strong>@lang('Description'):</strong> {{ $produit->description_produit ?? 'Aucune description disponible' }}</p>
            <p><strong>@lang('Quantité par préparation'):</strong> {{ $produit->qte_preparation ?? 'Non défini' }}</p>
            <p><strong>@lang('Quantité par lot'):</strong> {{ $produit->qte_lot ?? 'Non défini' }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>@lang('Matières premières associer au produit')</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Matière Première')</th>
                        <th>@lang('Quantité')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produit->matierePremieres as $matierePremiere)
                        <tr>
                            <td>{{ $matierePremiere->nom_MP }}</td>
                            <td>{{ $matierePremiere->pivot->qte }} {{ $matierePremiere->unite }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcomponent
@endsection
