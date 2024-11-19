@extends('boilerplate::layout.index', [
    'title' => __('Créer Commande'),
    'subtitle' => __('Ajouter une nouvelle commande'),
    'breadcrumb' => [
        __('Commandes') => 'boilerplate.commandes.gerer',
        __('Créer')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.commandes.store', 'method' => 'POST'])
    @csrf
    <div class="row">
        <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.commandes.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des commandes')">
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
                @component('boilerplate::card', ['title' => 'Détails de la Commande'])
                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'reference_commande',
                        'label' => 'Référence',
                        'required' => true,
                        'value' => old('reference_commande', $referenceCommande ?? ''),
                        'readonly' => true
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'date',
                        'name' => 'date_commande',
                        'label' => 'Date de commande',
                        'required' => true,
                        'value' => old('date_commande', \Carbon\Carbon::now()->format('Y-m-d')),
                        'readonly' => true
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'number',
                        'name' => 'montant',
                        'label' => 'Montant total',
                        'required' => true,
                        'min' => 0,
                        'value' => old('montant'),
                        'readonly' => true,
                        'id' => 'montant_total'
                    ])
                    @endcomponent
                @endcomponent
            </div>

            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Livraison et Client'])
                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'adresse_livraison',
                        'label' => 'Adresse de livraison',
                        'required' => true,
                        'value' => old('adresse_livraison')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'date',
                        'name' => 'date_livraison',
                        'label' => 'Date de livraison',
                        'required' => true,
                        'value' => old('date_livraison')
                    ])
                    @endcomponent

                    <div class="form-group">
                        <label for="utilisateur">Utilisateur</label>
                        <input type="text" class="form-control" id="utilisateur" name="utilisateur" value="{{ $user->name }}" readonly>
                    </div>
                @endcomponent
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                @component('boilerplate::card', ['title' => 'Produits commandés'])
                    <table class="table" id="table-produits">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="produits-container">
                            <tr>
                                <td>
                                    <select class="form-control produit-select" name="produits[0][id]" onchange="updatePrixUnitaire(this)">
                                        <option value="" disabled selected>Choisissez un produit</option>
                                        @foreach($produits as $produit)
                                            <option value="{{ $produit->id_produit }}" data-price="{{ $produit->prix_details_produit }}">{{ $produit->nom_produit }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control prix-unitaire" name="produits[0][prix_unitaire]" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantite" name="produits[0][qte]" min="1" oninput="calculateMontant(this)">
                                </td>
                                <td>
                                    <input type="number" class="form-control montant-produit" name="produits[0][montant_produit]" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="removeProduit(this)">Supprimer</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-success" onclick="addProduit()">Ajouter un produit</button>
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection

@push('js')
<script>
    let produitIndex = 1;

    function addProduit() {
        const container = document.getElementById('produits-container');
        const row = container.firstElementChild.cloneNode(true);

        row.querySelectorAll('select, input').forEach((element) => {
            if (element.name.includes('produits')) {
                element.name = element.name.replace(/\[\d+\]/, `[${produitIndex}]`);
            }
            if (element.classList.contains('quantite')) {
                element.value = '';
                element.oninput = () => calculateMontant(element);
            } else if (element.classList.contains('prix-unitaire') || element.classList.contains('montant-produit')) {
                element.value = '';
            }
        });

        container.appendChild(row);
        produitIndex++;
    }

    function removeProduit(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#produits-container tr').length > 1) {
            row.remove();
            updateTotalMontant();
        }
    }

    function updatePrixUnitaire(select) {
        const row = select.closest('tr');
        const price = select.options[select.selectedIndex].dataset.price;
        row.querySelector('.prix-unitaire').value = price || 0;
        calculateMontant(row.querySelector('.quantite'));
    }

    function calculateMontant(input) {
        const row = input.closest('tr');
        const price = parseFloat(row.querySelector('.prix-unitaire').value) || 0;
        const quantity = parseFloat(input.value) || 0;
        const montant = price * quantity;
        row.querySelector('.montant-produit').value = montant.toFixed(2);
        updateTotalMontant();
    }

    function updateTotalMontant() {
        const montantInputs = document.querySelectorAll('.montant-produit');
        let total = 0;
        montantInputs.forEach((input) => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('montant_total').value = total.toFixed(2);
    }
</script>
@endpush
