<!-- resources/views/vendor/boilerplate/categories/create.blade.php -->

@extends('boilerplate::layout.index', [
    'title' => __('Catégorie'),
    'subtitle' => __('Créer une nouvelle catégorie'),
    'breadcrumb' => [
        __('Catégories') => 'boilerplate.categories.index',
        __('Créer une catégorie')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.categories.store', 'method' => 'POST'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.categories.index') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des catégories')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('Créer la catégorie')
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 ">
                @component('boilerplate::card', ['title' => 'Détails de la catégorie'])
                    <div class="form-group">
                        <label for="code_categorie">Code de la catégorie</label>
                        <input type="text" id="code_categorie" name="code_categorie" class="form-control" required>
                        @error('code_categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom_categorie">Nom de la catégorie</label>
                        <input type="text" id="nom_categorie" name="nom_categorie" class="form-control" required>
                        @error('nom_categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent
@stop
