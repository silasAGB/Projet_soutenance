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
            <h3 class="mb-4 text-primary">@lang('Détails du Produit')</h3>
            <div class="float-right pb-1">
                <a href="{{ route('boilerplate.produits.edit', $produit->id_produit) }}" class="btn btn-primary">
                    @lang('Modifier le produit')
                </a>
            </div>

            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 25%;">@lang('Référence')</th>
                        <td>{{ $produit->reference_produit }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Nom')</th>
                        <td>{{ $produit->nom_produit }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Prix de détail')</th>
                        <td>{{ number_format($produit->prix_details_produit, 2) }} FCFA</td>
                    </tr>
                    <tr>
                        <th>@lang('Prix en gros')</th>
                        <td>{{ $produit->prix_gros_produit ? number_format($produit->prix_gros_produit, 2) . ' FCFA' : 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Quantité en stock')</th>
                        <td>{{ $produit->qte_stock }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Stock Minimum')</th>
                        <td>{{ $produit->stock_min }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Emplacement')</th>
                        <td>{{ $produit->emplacement ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Description')</th>
                        <td>{{ $produit->description_produit ?? 'Aucune description disponible' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Quantité par préparation')</th>
                        <td>{{ $produit->qte_preparation ?? 'Non défini' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Quantité par lot')</th>
                        <td>{{ $produit->qte_lot ?? 'Non défini' }} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h3 class="mb-4 text-primary">@lang('Matières premières associées au produit')</h3>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
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
