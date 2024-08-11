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
        <!-- ... -->
        <!-- Section pour les matières premières -->
        <div class="row">
            <div class="col-12">
                @component('boilerplate::card', ['color' => 'info'])
                    <div class="form-group">
                        <label for="matieres_premieres">Matières Premières</label>
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
