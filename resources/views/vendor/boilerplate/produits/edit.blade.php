@extends('boilerplate::layout.index', [
    'title' => __('Modifier produit'),
    'subtitle' => __('Modification de produit'),
    'breadcrumb' => [
        __('Produits') => 'boilerplate.produits.index',
        __('Modification de produit')
    ]
])

@section('content')
    @component('boilerplate::form', ['method' => 'put', 'route' => ['boilerplate.produits.update', $produit->id_produit]])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.produits.index') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('boilerplate::produits.returntolist')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('Enregistrer')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @component('boilerplate::card', ['color' => 'orange'])

                    <div class="form-group">
                        <label for="reference_produit">Référence</label>
                        <input type="text" id="reference_produit" name="reference_produit" class="form-control" value="{{ $produit->reference_produit }}" required>
                        @error('reference_produit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nom_produit">Nom</label>
                        <input type="text" id="nom_produit" name="nom_produit" class="form-control" value="{{ $produit->nom_produit }}" required>
                        @error('nom_produit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="emplacement">Emplacement</label>
                        <input type="text" id="emplacement" name="emplacement" class="form-control" value="{{ $produit->emplacement }}">
                        @error('emplacement')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_Categorie">Catégorie</label>
                        <select id="id_Categorie" name="id_Categorie" class="form-control" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id_Categorie }}" {{ $categorie->id_Categorie == $produit->id_categorie ? 'selected' : '' }}>{{ $categorie->nom_Categorie }}</option>
                            @endforeach
                        </select>
                        @error('id_Categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description_produit">Description</label>
                        <textarea id="description_produit" name="description_produit" class="form-control">{{ $produit->description_produit }}</textarea>
                        @error('description_produit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="prix_details_produit">Prix de Détail</label>
                        <input type="number" id="prix_details_produit" name="prix_details_produit" class="form-control" value="{{ $produit->prix_details_produit }}" required>
                        @error('prix_details_produit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="prix_gros_produit">Prix de Gros</label>
                        <input type="number" id="prix_gros_produit" name="prix_gros_produit" class="form-control" value="{{ $produit->prix_gros_produit }}">
                        @error('prix_gros_produit')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="qte_preparation">Quantité de Préparation</label>
                        <input type="number" id="qte_preparation" name="qte_preparation" class="form-control" value="{{ $produit->qte_preparation }}">
                        @error('qte_preparation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="qte_lot">Quantité de Lot</label>
                        <input type="number" id="qte_lot" name="qte_lot" class="form-control" value="{{ $produit->qte_lot }}">
                        @error('qte_lot')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="qte_stock">Quantité en Stock</label>
                        <input type="number" id="qte_stock" name="qte_stock" class="form-control" value="{{ $produit->qte_stock }}" required>
                        @error('qte_stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stock_min">Stock Minimum</label>
                        <input type="number" id="stock_min" name="stock_min" class="form-control" value="{{ $produit->stock_min }}">
                        @error('stock_min')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
                @endcomponent
            </div>

        <!-- Section pour les matières premières -->

            <div class="col-6">
                @component('boilerplate::card', ['color' => 'info'])
                    <div class="form-group">
                        <label for="matiere_premieres">Matières Premières</label>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Matière Première</th>
                                    <th>Quantité</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($matiereProduits) && count($matiereProduits) > 0)
                                    @foreach($matiereProduits as $matiereProduit)
                                        <tr>
                                            <td>
                                                <select name="matieres_premieres[]" class="form-control" required>
                                                    @foreach ($matieresPremieres as $matierePremiere)
                                                        <option value="{{ $matierePremiere->id_MP }}" {{ $matierePremiere->id_MP == $matiereProduit->id_MP ? 'selected' : '' }}>
                                                            {{ $matierePremiere->nom_MP }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="quantites[]" class="form-control" value="{{ $matiereProduit->pivot->qte }}" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-matiere">Supprimer</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Aucune matière première associée.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary add-matiere">Ajouter une matière première</button>
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.add-matiere').addEventListener('click', function () {
                const newRow = `
                    <tr>
                        <td>
                            <select name="matieres_premieres[]" class="form-control" required>
                                @foreach ($matieresPremieres as $matierePremiere)
                                    <option value="{{ $matierePremiere->id_MP }}">{{ $matierePremiere->nom_MP }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantites[]" class="form-control" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-matiere">Supprimer</button>
                        </td>
                    </tr>
                `;
                document.querySelector('table tbody').insertAdjacentHTML('beforeend', newRow);
            });

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-matiere')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
@endsection
