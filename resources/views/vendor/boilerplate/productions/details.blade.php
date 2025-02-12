@extends('boilerplate::layout.index', [
    'title' => __('Détails de la production'),
    'subtitle' => __('Voir les détails de la production'),
    'breadcrumb' => [
        __('Productions') => 'boilerplate.productions.gerer',
        __('Détails')
    ]
])

@section('content')
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('boilerplate.productions.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste')">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <a href="#" class="btn btn-primary float-right" data-toggle="tooltip" title="@lang('Télécharger les détails de production')">
                <span class="fas fa-download"></span>
            </a>
        </div>
    </div>

    @component('boilerplate::card')
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 text-primary">@lang('Détails de production')</h3>
            <div class="float-right pb-1">
                <a href="{{ route('boilerplate.productions.edit', $production->id_production) }}" class="btn btn-primary">
                    @lang('Modifier la production')
                </a>
            </div>

            <table class="table table-striped table-hover table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 25%;">@lang('Référence')</th>
                        <td>{{ $production->reference_production }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Date de production')</th>
                        <td>{{ $production->date_production ?? __('N/A') }}</td>
                        <th>@lang('Date prévue')</th>
                        <td>{{ $production->date_prevue }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Quantité prévue')</th>
                        <td>{{ $production->qte_prevue }}</td>
                        <th>@lang('Quantité produite')</th>
                        <td>{{ $production->qte_produite ?? __('N/A') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Heure prévue')</th>
                        <td>{{ $production->heure_prevue ?? __('N/A') }}</td>
                        <th>@lang('Heure de production')</th>
                        <td>{{ $production->heure_production ?? __('N/A') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Nombre de préparations')</th>
                        <td>{{ $production->nbr_preparation }}</td>
                        <th>@lang('Personnel affectée')</th>
                        <td>{{ $production->nom_personnel }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Statut')</th>
                        <td>{{ $production->statut }}</td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <th>@lang('Consignes spécifiques')</th>
                        <td colspan="3">{{ $production->consignes_specifiques ?? __('Aucune') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Autre remarque')</th>
                        <td colspan="3">{{ $production->autres_remarques ?? __('N/A') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h4 class="mb-4 text-primary">@lang('Détails des matières premières utilisées')</h4>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>@lang('Matière Première')</th>
                        <th>@lang('Quantité nécessaire')</th>
                        <th>@lang('Quantité disponible')</th>
                        <th>@lang('État')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($production->matieresPremieres as $matierePremiere)
                        <tr>
                            <td>{{ $matierePremiere->nom_MP }}</td>
                            <td>{{ $matierePremiere->pivot->qte }} {{ $matierePremiere->unite }}</td>
                            <td>{{ $matierePremiere->qte_stock }} {{ $matierePremiere->unite }}</td>
                            <td>
                                @if($matierePremiere->qte_stock >= $matierePremiere->pivot->qte)
                                    <span class="badge badge-success">@lang('Suffisant')</span>
                                @else
                                    <span class="badge badge-danger">@lang('Insuffisant')</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endcomponent
@endsection
