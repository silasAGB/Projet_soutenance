@extends('boilerplate::layout.index', [
    'title' => 'Gerer fournisseurs',
    'breadcrumb' => ['Fournisseurs', 'Gerer']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.approvisionnements.createfournisseur") }}" class="btn btn-primary">
                @lang('ajouter un fournisseur')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
<x-boilerplate::datatable name="fournisseurs" />
@endcomponent   
@endsection
