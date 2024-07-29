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
            <a href="{{ route('boilerplate.approvisionnements.gerer', $approvisionnement->id_approvisionnement) }}" class="btn btn-primary" data-toggle="tooltip" title="@lang('Télécharger le bon de commande')">
                <span class="fas fa-download text-muted"></span> @lang('Télécharger PDF')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h3>@lang('Bon de commande')</h3>
            <p><strong>@lang('Référence'):</strong> {{ $approvisionnement->reference_approvisionnement }}</p>
            <p><strong>@lang('Date'):</strong> {{ $approvisionnement->date_approvisionnement }}</p>
            <p><strong>@lang('Montant Total'):</strong> {{ $approvisionnement->formatted_montant }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>@lang('Détails des matières premières')</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Matière Première')</th>
                        <th>@lang('Fournisseur')</th>
                        <th>@lang('Quantité')</th>
                        <th>@lang('Montant')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvisionnement->matieresPremieres as $matierePremiere)
                        <tr>
                            <td>{{ $matierePremiere->nom_MP }}</td>
                            <td>
                                @php
                                    $fournisseur = $matierePremiere->fournisseurs->where('id_fournisseur', $matierePremiere->pivot->id_fournisseur)->first();
                                @endphp
                                {{ $fournisseur ? $fournisseur->nom_fournisseur : 'N/A' }}
                            </td>
                            <td>{{ $matierePremiere->pivot->qte_approvisionnement }}</td>
                            <td>{{ number_format($matierePremiere->pivot->montant, 2) }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
