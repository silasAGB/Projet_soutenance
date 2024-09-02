@extends('boilerplate::layout.index', [
    'title' => __('Ajouter de matière première'),
    'subtitle' => __('Ajouter une nouvelle matière première'),
    'breadcrumb' => [
        __('Matière première') => 'boilerplate.matierepremieres.index',
        __('Ajouter')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.matierepremieres.store', 'method' => 'POST'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.matierepremieres.index') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des matières premières')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('Ajouter')
                    </button>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Informations Générales'])
                    <div class="form-group">
                        <label for="nom_MP">Nom</label>
                        <input type="text" id="nom_MP" name="nom_MP" class="form-control" required>
                        @error('nom_MP')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="prix_achat">Prix d'Achat (en FCFA)</label>
                        <input type="number" id="prix_achat" name="prix_achat" class="form-control" required>
                        @error('prix_achat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unite">Unité</label>
                        <select id="unite" name="unite" class="form-control" required>
                            <option value="">Sélectionnez une unité</option>
                            <option value="kg">Kg</option>
                            <option value="l">L</option>
                            <option value="g">G</option>
                            <option value="ml">mL</option>
                        </select>
                        @error('unite')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endcomponent
            </div>

            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Détails du Stock'])
                    <div class="form-group">
                        <label for="qte_stock">Quantité en Stock</label>
                        <input type="number" id="qte_stock" name="qte_stock" class="form-control" required>
                        @error('qte_stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_min">Stock Minimum</label>
                        <input type="number" id="stock_min" name="stock_min" class="form-control" required>
                        @error('stock_min')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="emplacement">Emplacement</label>
                        <input type="text" id="emplacement" name="emplacement" class="form-control" required>
                        @error('emplacement')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_categorie">Catégorie</label>
                        <select id="id_categorie" name="id_categorie" class="form-control" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id_Categorie }}">{{ $categorie->nom_Categorie }}</option>
                            @endforeach
                        </select>
                        @error('id_categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
