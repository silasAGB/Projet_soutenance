@extends('boilerplate::layout.index', [
    'title' => 'Gerer Approvisionnements',
    'breadcrumb' => ['Approvisionnements', 'Gerer']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.approvisionnements.create") }}" class="btn btn-primary">
                @lang('ajouter un approvisionnement')
            </a>
        </span>
    </div>
</div>
@component('boilerplate::card')
<x-boilerplate::datatable name="approvisionnements" />
@endcomponent
@endsection

