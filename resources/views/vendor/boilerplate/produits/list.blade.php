@extends('boilerplate::layout.index', [
    'title' => __('Produits'),
    'subtitle' => __('Liste des Produits'),
    'breadcrumb' => [
        __('Stocks') => 'boilerplate.produits.index',
        __('Liste des produits')
    ]
])


@section('content')
<div class="row">
    <div class="col-12 mbl">
        <a href="{{ route("boilerplate.produits.mouvements") }}" class="btn btn-primary">
            @lang('Historiques')
        </a>
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.produits.create") }}" class="btn btn-primary">
                @lang('Ajouter un produits')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
<x-boilerplate::datatable name="produits" />
@endcomponent
@stop

