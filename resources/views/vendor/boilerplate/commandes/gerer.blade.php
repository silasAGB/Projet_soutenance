@extends('boilerplate::layout.index', [
    'title' => 'Gestion Commandes',
    'breadcrumb' => ['Commandes', 'Gestion']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.categories.create") }}" class="btn btn-primary">
                @lang('Placer une commande')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
<x-boilerplate::datatable name="commandes" />
@endcomponent
@endsection
