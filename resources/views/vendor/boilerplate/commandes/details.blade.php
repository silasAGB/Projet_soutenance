@extends('boilerplate::layout.index', [
    'title' => 'Details Commandes',
    'breadcrumb' => ['Commandes', 'Details']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.commandes.gerer") }}" class="btn btn-primary">
                @lang('Liste des commandes')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
    VOICI LES DETAILS DE CETTE COMMANDES
@endcomponent
@endsection
