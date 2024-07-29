@extends('boilerplate::layout.index', [
    'title' => __('boilerplate::matierepremieres.title'),
    'subtitle' => __('boilerplate::matierepremieres.create.title'),
    'breadcrumb' => [
        __('boilerplate::matierepremieres.title') => 'boilerplate.matierepremieres.index',
        __('boilerplate::matierepremieres.create.title')
    ]
])

@section('content_header')
    <h1>Ajouter une Matière Première</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('boilerplate.matierepremieres.store') }}" method="POST">
                @csrf

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
                        <!-- Ajoutez d'autres unités si nécessaire -->
                    </select>
                    @error('unite')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

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

                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>
@stop
