@extends('boilerplate::layout.index', [
    'title' => 'Gerer Production',
    'breadcrumb' => ['Productions', 'Gerer Production']
])

@section('content')

<div class="row">
    <div class="col-md-3">
        @component('boilerplate::smallbox', [
            'text' => 'En attente d\'approbation',
            'nb' => $productionEnAttentDeApprobation,
            'icon' => 'fa-solid fa-check-circle',
            'link' => route('boilerplate.approbations.gerer'),
                'linkText' => 'Voir plus',
            'color' => 'red'
            ])
            @endcomponent
    </div>
    <div class="col-md-3">
        @component('boilerplate::smallbox', [
            'text' => 'En attente de production',
            'nb' => $productionEnAttente,
            'icon' => 'fa-solid fa-hourglass-half',
            'color' => 'warning'
            ])
            @endcomponent
    </div>
    <div class="col-md-3">
        @component('boilerplate::smallbox', [
            'text' => __('En cours de production'),
            'nb' => $productionEnCours,
            'icon' => 'fa-solid fa-solid fa-gears',
            'color' => 'info'
        ])
        @endcomponent
    </div>
    <div class="col-md-3">
        @component('boilerplate::smallbox', [
            'text' => __('Production effectuée ce mois'),
            'nb' => $productionEffectueCeMois,
            'icon' => 'fa-solid fa-calendar-check',
            'color' => 'success'
        ])
        @endcomponent
    </div>
</div>


@component('boilerplate::card')

<h1>Liste des Productions</h1>
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.productions.create") }}" class="btn btn-primary">
                @lang('Programmer une production')
            </a>
        </span>
    </div>
</div>

<x-boilerplate::datatable name="productions" />
@endcomponent
@endsection
