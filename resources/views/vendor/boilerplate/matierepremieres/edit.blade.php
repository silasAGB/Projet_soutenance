@extends('boilerplate::layout.index', [
    'title' => __('Modifier Matière Première'),
    'subtitle' => __('Modification de la matière première'),
    'breadcrumb' => [
        __('Matières Premières') => 'boilerplate.matierepremieres.index',
        __('Modification de la matière première')
    ]
])

@section('content')
    @component('boilerplate::form', ['method' => 'put', 'route' => ['boilerplate.matierepremieres.update', $matierePremiere->id_MP]])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.matierepremieres.index') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('boilerplate::matierepremieres.returntolist')">
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
                        <label for="nom_MP">@lang('Nom')</label>
                        <input type="text" id="nom_MP" name="nom_MP" class="form-control" value="{{ old('nom_MP', $matierePremiere->nom_MP) }}" required>
                        @error('nom_MP')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unite">@lang('Unité')</label>
                        <select id="unite" name="unite" class="form-control" required>
                            <option value="">@lang('Sélectionnez une unité')</option>
                            <option value="kg" {{ old('unite', $matierePremiere->unite) == 'kg' ? 'selected' : '' }}>Kg</option>
                            <option value="l" {{ old('unite', $matierePremiere->unite) == 'l' ? 'selected' : '' }}>L</option>
                            <option value="g" {{ old('unite', $matierePremiere->unite) == 'g' ? 'selected' : '' }}>g</option>
                            <option value="ml" {{ old('unite', $matierePremiere->unite) == 'ml' ? 'selected' : '' }}>mL</option>
                            <option value="Boite" {{ old('unite', $matierePremiere->unite) == 'Boite' ? 'selected' : '' }}>Boites</option>
                            <option value="Bouteille" {{ old('unite', $matierePremiere->unite) == 'Bouteille' ? 'selected' : '' }}>Bouteilles</option>
                            <option value="Boite" {{ old('unite', $matierePremiere->unite) == 'Boite' ? 'selected' : '' }}>Bouchons</option>
                            <option value="Emballage" {{ old('unite', $matierePremiere->unite) == 'Emballage' ? 'selected' : '' }}>Emballages</option>

                        </select>
                        @error('unite')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="qte_stock">@lang('Quantité en Stock')</label>
                        <input type="number" id="qte_stock" name="qte_stock" class="form-control" value="{{ old('qte_stock', $matierePremiere->qte_stock) }}" required>
                        @error('qte_stock')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="stock_min">@lang('Stock Minimum')</label>
                        <input type="number" id="stock_min" name="stock_min" class="form-control" value="{{ old('stock_min', $matierePremiere->stock_min) }}" required>
                        @error('stock_min')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endcomponent
            </div>
            <div class="col-md-6">
                @component('boilerplate::card', ['color' => 'teal'])
                    <div class="form-group">
                        <label for="emplacement">@lang('Emplacement')</label>
                        <input type="text" id="emplacement" name="emplacement" class="form-control" value="{{ old('emplacement', $matierePremiere->emplacement) }}" required>
                        @error('emplacement')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_categorie">@lang('Catégorie')</label>
                        <select id="id_categorie" name="id_categorie" class="form-control" required>
                            @foreach ($categories as $categorie)
                                <option value="{{ $categorie->id_Categorie }}" {{ old('id_categorie', $matierePremiere->id_categorie) == $categorie->id_Categorie ? 'selected' : '' }}>
                                    {{ $categorie->nom_Categorie }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_categorie')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fournisseurs">@lang('Fournisseurs et Prix d\'Achat')</label>
                        <div id="fournisseurs">
                            @foreach ($matierePremiere->fournisseurs as $fournisseur)
                                <div class="fournisseur-group mb-3">
                                    <div class="input-group">
                                        <select name="fournisseurs[{{ $loop->index }}][id]" class="form-control">
                                            @foreach ($fournisseurs as $f)
                                                <option value="{{ $f->id_fournisseur }}" {{ $fournisseur->id_fournisseur == $f->id_fournisseur ? 'selected' : '' }}>
                                                    {{ $f->nom_fournisseur }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="fournisseurs[{{ $loop->index }}][prix_achat]" class="form-control" value="{{ old("fournisseurs.{$loop->index}.prix_achat", $fournisseur->pivot->prix_achat) }}" placeholder="@lang('Prix d\'Achat')">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-danger remove-fournisseur">@lang('Supprimer')</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-fournisseur" class="btn btn-secondary">@lang('Ajouter un Fournisseur')</button>
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let fournisseurCount = {{ $matierePremiere->fournisseurs->count() }};
            document.getElementById('add-fournisseur').addEventListener('click', function () {
                const fournisseurs = {!! $fournisseurs->toJson() !!};
                const fournisseurGroup = document.createElement('div');
                fournisseurGroup.className = 'fournisseur-group mb-3';
                let fournisseurOptions = '';
                fournisseurs.forEach(f => {
                    fournisseurOptions += `<option value="${f.id_fournisseur}">${f.nom_fournisseur}</option>`;
                });
                fournisseurGroup.innerHTML = `
                    <div class="input-group">
                        <select name="fournisseurs[${fournisseurCount}][id]" class="form-control">
                            ${fournisseurOptions}
                        </select>
                        <input type="number" name="fournisseurs[${fournisseurCount}][prix_achat]" class="form-control" placeholder="@lang('Prix d\'Achat')">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-fournisseur">@lang('Supprimer')</button>
                        </div>
                    </div>
                `;
                document.getElementById('fournisseurs').appendChild(fournisseurGroup);
                fournisseurCount++;


                fournisseurGroup.querySelector('.remove-fournisseur').addEventListener('click', function () {
                    fournisseurGroup.remove();
                });
            });

            document.querySelectorAll('.remove-fournisseur').forEach(button => {
                button.addEventListener('click', function () {
                    this.closest('.fournisseur-group').remove();
                });
            });
        });
    </script>
@endsection
