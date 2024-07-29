@extends('boilerplate::layout.index', [
    'title' => __('Catégorie'),
    'subtitle' => __('Liste des catégories'),
    'breadcrumb' => [
        __('Stocks') => 'boilerplate.categories.index',
        __('Liste des catégories')
    ]
])


@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.categories.create") }}" class="btn btn-primary">
                @lang('Creer une catégorie')
            </a>
        </span>
    </div>
</div>

<x-boilerplate::datatable name="categories" />
@stop

