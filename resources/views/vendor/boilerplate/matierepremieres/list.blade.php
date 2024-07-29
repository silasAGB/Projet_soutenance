@extends('boilerplate::layout.index', [
    'title' => __('Matière premières'),
    'subtitle' => __('Liste des matieres premières'),
    'breadcrumb' => [
        __('Stocks') => 'boilerplate.categories.index',
        __('Liste des matières première')
    ]
])


@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.matierepremieres.create") }}" class="btn btn-primary">
                @lang('Creer une matière première')
            </a>
        </span>
    </div>
</div>
<x-boilerplate::datatable name="matierepremiers" />
@stop

