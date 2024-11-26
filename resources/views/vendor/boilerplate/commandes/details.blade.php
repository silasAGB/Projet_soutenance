@extends('boilerplate::layout.index', [
    'title' => __('Détails de la commande'),
    'subtitle' => __('Informations sur la commande : :ref', ['ref' => $commande->reference_commande]),
    'breadcrumb' => [
        __('Commandes') => 'boilerplate.commandes.gerer',
        __('Détails')
    ]
])

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('boilerplate.commandes.gerer') }}" class="btn btn-default mb-3">
            <span class="far fa-arrow-alt-circle-left"></span> @lang('Retour à la liste')
        </a>

        <div class="float-right pb-1">
            <a href="{{ route('boilerplate.commandes.edit', $commande->id_commande) }}" class="btn btn-primary">
                @lang('Modifier la commande')
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        @component('boilerplate::card', ['title' => __('Informations générales')])
            <div class="mb-3">
                <strong>@lang('Référence') :</strong> {{ $commande->reference_commande }}
            </div>
            <div class="mb-3">
                <strong>@lang('Date de commande') :</strong> {{ \Carbon\Carbon::parse($commande->date_commande)->format('d/m/Y') }}
            </div>
            <div class="mb-3">
                <strong>@lang('Statut') :</strong>
                <span class="badge badge-{{ $commande->statut == 'En_attente' ? 'warning' : 'success' }}">
                    {{ ucfirst($commande->statut) }}
                </span>
            </div>
            <div class="mb-3">
                <strong>@lang('Montant total') :</strong> {{ number_format($commande->montant, 2, ',', ' ') }} €
            </div>
        @endcomponent
    </div>

    <div class="col-lg-6">
        @component('boilerplate::card', ['title' => __('Livraison')])
            <div class="mb-3">
                <strong>@lang('Adresse de livraison') :</strong> {{ $commande->adresse_livraison }}
            </div>
            <div class="mb-3">
                <strong>@lang('Date de livraison') :</strong> {{ \Carbon\Carbon::parse($commande->date_livraison)->format('d/m/Y') }}
            </div>
            <div class="mb-3">
                <strong>@lang('Client') :</strong>
                {{ $commande->client ? $commande->client->nom_client . ' ' . $commande->client->prenom_client : __('Non spécifié') }}
            </div>
        @endcomponent
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        @component('boilerplate::card', ['title' => __('Produits commandés')])
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Produit')</th>
                        <th>@lang('Prix Unitaire')</th>
                        <th>@lang('Quantité')</th>
                        <th>@lang('Montant')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commande->produit_commande as $produitCommande)
                        <tr>
                            <td>{{ $produitCommande->produit->nom_produit }}</td>
                            <td>{{ number_format($produitCommande->prix_unitaire, 2, ',', ' ') }} €</td>
                            <td>{{ $produitCommande->qte_produit_commande }}</td>
                            <td>{{ number_format($produitCommande->montant_produit_commande, 2, ',', ' ') }} €</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">@lang('Total')</th>
                        <th>{{ number_format($commande->montant, 2, ',', ' ') }} €</th>
                    </tr>
                </tfoot>
            </table>
        @endcomponent
    </div>
</div>
@endsection
