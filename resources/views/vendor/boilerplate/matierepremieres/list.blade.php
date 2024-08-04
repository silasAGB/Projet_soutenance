@extends('boilerplate::layout.index', [
    'title' => __('Matière premières'),
    'subtitle' => __('Liste des matières premières'),
    'breadcrumb' => [
        __('Stocks') => 'boilerplate.categories.index',
        __('Liste des matières premières')
    ]
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.matierepremieres.create") }}" class="btn btn-primary">
                @lang('Créer une matière première')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
<x-boilerplate::datatable name="matierepremieres" />
@endcomponent
@stop
