@extends('boilerplate::layout.index', [
    'title' => __('Mouvements des matières premières'),
    'subtitle' => __('Historique des mouvements'),
    'breadcrumb' => [
        __('Stocks') => 'boilerplate.categories.index',
        __('Historique des mouvements')
    ]
])



@section('content')
@component('boilerplate::card')
<div class="row">
    <div class="col-12 mbl">
        <a href="{{ route('boilerplate.matierepremieres.create') }}" class="btn btn-primary">
            @lang('Créer une matière première')
        </a>

        <span class="float-right pb-3">
            <form method="GET" class="form-inline d-inline">
                <!-- Champ de sélection pour matière première -->
                <select name="matiere_premiere" class="form-control mx-1">
                    <option value="">@lang('Toutes les matières premières')</option>
                    @foreach ($matieresPremieres as $matierePremiere)
                        <option value="{{ $matierePremiere->id_MP }}"
                            {{ request('matiere_premiere') == $matierePremiere->id_MP ? 'selected' : '' }}>
                            {{ $matierePremiere->nom_MP }}
                        </option>
                    @endforeach
                </select>
                <!-- Filtres par date -->
                <input type="date" name="start_date" class="form-control mx-1" placeholder="Début" value="{{ request('start_date') }}">
                <input type="date" name="end_date" class="form-control mx-1" placeholder="Fin" value="{{ request('end_date') }}">

                 <!-- Filtre par type -->
    <select name="type" class="form-control mx-1">
        <option value="">@lang('Entrée/Sortie')</option>
        <option value="entrée" {{ request('type') == 'entrée' ? 'selected' : '' }}>@lang('Entrée')</option>
        <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>@lang('Sortie')</option>
    </select>

                <button type="submit" class="btn btn-primary mx-1">@lang('Filtrer')</button>
            </form>
        </span>
    </div>
</div>

@component('boilerplate::card', ['title' => __('Historique des Mouvements')])
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th>@lang('Date')</th>
                <th>@lang('Matière Première')</th>
                <th>@lang('Type')</th>
                <th>@lang('Quantité')</th>
                <th>@lang('Stock Disponible')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mouvements as $mouvement)
            <tr>
                <td>{{ $mouvement->date_mouvement }}</td>
                <td>{{ $mouvement->matierePremiere->nom_MP ?? __('Non spécifié') }}</td>
                <td>
                    <span class="badge {{ $mouvement->type == 'entrée' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($mouvement->type) }}
                    </span>
                </td>
                <td>{{ $mouvement->quantité }}</td>
                <td>{{ $mouvement->stock_disponible }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">@lang('Aucun mouvement trouvé.')</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


@if ($mouvements->count() > 0 && request('matiere_premiere'))
    <div class="row mt-4">
        <div class="col-md-6">
            <h5>@lang('Consommation sur la période') : {{ $consommation }}</h5>
        </div>
        <div class="col-md-6">
            <h5>@lang('Stock disponible avant période') : {{ $valeurStockAvantDebut }}</h5>
        </div>
    </div>
@endif


<div class="mt-3">
    {{ $mouvements->appends(request()->query())->links() }}
</div>
@endcomponent
@endcomponent
@stop
