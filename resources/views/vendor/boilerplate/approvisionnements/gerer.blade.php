@extends('boilerplate::layout.index', [
    'title' => 'Gerer les approvisionnements',
    'breadcrumb' => ['Approvisionnements', 'Gerer les approvisionnments']
])



@section('content')

<div class="row">
    <div class="col-md-4">
        @component('boilerplate::smallbox', [
            'text' => 'En attente d\'approbation',
            'nb' => $approvisionnementsEnAttenteApprobation,
            'icon' => 'fa-solid fa-hourglass-half',
            'link' => route('boilerplate.approvisionnements.gerer'),
            'linkText' => 'Voir plus',
            'color' => 'warning'
            ])
            @endcomponent
    </div>
    <div class="col-md-4">
        @component('boilerplate::smallbox', [
            'text' => __('En attente de livraison'),
            'nb' => $approvisionnementsEnAttenteLivraison,
            'icon' => 'fa-solid fa-truck',
            'link' => route('boilerplate.approvisionnements.gerer'),
            'linkText' => __('Voir plus'),
            'color' => 'info'
        ])
        @endcomponent
    </div>
    <div class="col-md-4">
        @component('boilerplate::smallbox', [
            'text' => __('Effectués ce mois'),
            'nb' => $approvisionnementsEffectueCeMois,
            'icon' => 'fa-solid fa-calendar-check',
            'link' => route('boilerplate.approvisionnements.gerer'),
            'linkText' => __('Voir plus'),
            'color' => 'success'
        ])
        @endcomponent
    </div>
</div>

@component('boilerplate::card')
<h1>Liste des Approvisionnements</h1>
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.approvisionnements.create") }}" class="btn btn-primary">
                @lang('ajouter un approvisionnement')
            </a>
        </span>
    </div>
</div>
<x-boilerplate::datatable name="approvisionnements" />
@endcomponent
@endsection

