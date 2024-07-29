@extends('boilerplate::layout.index', [
    'title' => __('Catégorie'),
    'subtitle' => __('Modifier une catégorie'),
    'breadcrumb' => [
        __('Catégorie') => 'boilerplate.categories.index',
        __('Modifier une catégorie')
    ]
])

@section('content_header')
    <h1>Modifier la catégorie</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.categories.update', $categorie->id_Categorie) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="code_categorie">Code de la catégorie</label>
                    <input type="text" id="code_categorie" name="code_categorie" class="form-control" value="{{ $categorie->code_Categorie }}" required>
                    @error('code_categorie')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nom_categorie">Nom de la catégorie</label>
                    <input type="text" id="nom_categorie" name="nom_categorie" class="form-control" value="{{ $categorie->nom_Categorie }}" required>
                    @error('nom_categorie')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour la catégorie</button>
            </form>
        </div>
    </div>
@stop
