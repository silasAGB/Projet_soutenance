@extends('boilerplate::layout.index', [
    'title' => 'Gestion des clients',
    'breadcrumb' => ['Commandes', 'Client']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.commandes.createclient") }}" class="btn btn-primary">
                @lang('Ajouter un nouveau client')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
PB DE DATATABLE
@endcomponent
@endsection
