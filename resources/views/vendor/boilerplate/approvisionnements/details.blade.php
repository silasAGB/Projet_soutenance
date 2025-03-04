@extends('boilerplate::layout.index', [
    'title' => __('Détails de l\'approvisionnement'),
    'subtitle' => __('Voir les détails de l\'approvisionnement'),
    'breadcrumb' => [
        __('Approvisionnements') => 'boilerplate.approvisionnements.gerer',
        __('Détails')
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('boilerplate.approvisionnements.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste')">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <a href="{{ route('boilerplate.approvisionnements.bons_de_commande', $approvisionnement->id_approvisionnement) }}" class="btn btn-primary float-right" data-toggle="tooltip" title="@lang('Télécharger le bon de commande')">
                <span class="fas fa-download"></span> @lang('Télécharger le bon de commande')
            </a>
        </div>
    </div>

    @component('boilerplate::card')
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 text-primary">@lang('Détails')</h3>
            <div class="float-right pb-1">
                <a href="{{ route('boilerplate.approvisionnements.edit', $approvisionnement->id_approvisionnement) }}" class="btn btn-primary">
                    @lang('Modifier l\'approvisionnement')
                </a>
            </div>

            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 25%;">@lang('Référence')</th>
                        <td>{{ $approvisionnement->reference_approvisionnement }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Date prévue')</th>
                        <td>{{ $approvisionnement->date_approvisionnement }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Montant Total')</th>
                        <td>{{ $approvisionnement->formatted_montant }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Statut')</th>
                        <td>{{ $approvisionnement->statut }}</td>
                    </tr>
                    @if(in_array($approvisionnement->statut, ['livrée', 'terminée']))
                        <tr>
                            <th>@lang('Quantité Livrée')</th>
                            <td>{{ $approvisionnement->qte_livree ?? 'Non spécifiée' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h4 class="mb-4 text-primary">@lang('Détails des matières premières')</h4>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>@lang('Matière Première')</th>
                        <th>@lang('Fournisseur')</th>
                        <th>@lang('Quantité Commandée')</th>
                        <th>@lang('Quantité Livrée')</th>
                        <th>@lang('Date de livraison')</th>
                        <th>@lang('Montant')</th>
                        <th>@lang('Statut')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvisionnement->matieresPremieres as $matierePremiere)
                        <tr>
                            <td>{{ $matierePremiere->nom_MP }}</td>
                            <td>
                                @php
                                    $fournisseur = \App\Models\Fournisseur::find($matierePremiere->pivot->id_fournisseur);
                                @endphp
                                {{ $fournisseur ? $fournisseur->nom_fournisseur : 'N/A' }}
                            </td>
                            <td>{{ $matierePremiere->pivot->qte_approvisionnement }} {{ $matierePremiere->unite }}</td>
                            <td>{{ $matierePremiere->pivot->qte_livree ?? 'Non livrée' }} {{ $matierePremiere->unite }}</td>
                            <td>{{ $matierePremiere->pivot->date_livraison ?? 'Non livrée' }} </td>
                            <td>{{ number_format($matierePremiere->pivot->montant, 2) }} FCFA</td>
                            <td>{{ $matierePremiere->pivot->statut}} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcomponent
@endsection
