<!-- resources/views/vendor/boilerplate/categories/create.blade.php -->

@extends('boilerplate::layout.index', [
    'title' => __('Catégorie'),
    'subtitle' => __('Creer une catégorie'),
    'breadcrumb' => [
        __('Categories') => 'boilerplate.categories.index',
        __('creer une catégorie')
    ]
])

@section('content_header')
    <h1>Créer une nouvelle catégorie</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.categories.store') }}" method="POST">
                @csrf

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

                <button type="submit" class="btn btn-primary">Créer la catégorie</button>
            </form>
        </div>
    </div>
@stop
