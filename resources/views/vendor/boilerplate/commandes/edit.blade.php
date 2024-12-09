@extends('boilerplate::layout.index', [
    'title' => __('Modifier Commande'),
    'subtitle' => __('Modifier une commande existante'),
    'breadcrumb' => [
        __('Commandes') => 'boilerplate.commandes.gerer',
        __('Modifier')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => ['boilerplate.commandes.edit', $commande->id_commande], 'method' => 'PUT'])
    @csrf
    <div class="row">
        <div class="col-12 pb-3">
            <a href="{{ route('boilerplate.commandes.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des commandes')">
                <span class="far fa-arrow-alt-circle-left text-muted"></span>
            </a>
            <span class="btn-group float-right">
                <button type="submit" class="btn btn-primary">
                    @lang('Enregistrer les modifications')
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
                    'value' => old('reference_commande', $commande->reference_commande),
                    'readonly' => true
                ])
                @endcomponent

                @component('boilerplate::input', [
                    'type' => 'date',
                    'name' => 'date_commande',
                    'label' => 'Date de commande',
                    'required' => true,
                    'value' => old('date_commande', $commande->date_commande)
                ])
                @endcomponent

                @component('boilerplate::input', [
                    'type' => 'number',
                    'name' => 'montant',
                    'label' => 'Montant total',
                    'required' => true,
                    'min' => 0,
                    'value' => old('montant', $commande->montant),
                    'id' => 'montant_total',
                    'readonly' => true
                ])
                @endcomponent

                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select id="statut" name="statut" class="form-control">
                        <option value="en_attente" {{ old('statut', $commande->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="valide" {{ old('statut', $commande->statut) == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="annule" {{ old('statut', $commande->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            @endcomponent
        </div>

        <div class="col-lg-6">
            @component('boilerplate::card', ['title' => 'Livraison et Client'])
                @component('boilerplate::input', [
                    'type' => 'text',
                    'name' => 'adresse_livraison',
                    'label' => 'Adresse de livraison',
                    'required' => true,
                    'value' => old('adresse_livraison', $commande->adresse_livraison)
                ])
                @endcomponent

                @component('boilerplate::input', [
                    'type' => 'date',
                    'name' => 'date_livraison',
                    'label' => 'Date de livraison',
                    'value' => old('date_livraison', $commande->date_livraison)
                ])
                @endcomponent

                <div class="form-group">
                    <label for="id_client">Client</label>
                    <select id="id_client" name="id_client" class="form-control">
                        <option value="">Aucun (Utilisateur actuel)</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('id_client', $commande->id_client) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} {{ $client->prenom }}
                            </option>
                        @endforeach
                    </select>
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
                        @foreach($commande->produits as $index => $produitCommande)
                            <tr>
                                <td>
                                    <select class="form-control produit-select" name="produits[{{ $index }}][id]" onchange="updatePrixUnitaire(this)">
                                        <option value="" disabled>Choisissez un produit</option>
                                        @foreach($produits as $produit)
                                            <option value="{{ $produit->id_produit }}"
                                                    data-price="{{ $produit->prix_details_produit }}"
                                                    {{ $produitCommande->id_produit == $produit->id_produit ? 'selected' : '' }}>
                                                {{ $produit->nom_produit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="produits[{{ $index }}][prix]"
                                           value="{{ $produitCommande->prix_unitaire }}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="produits[{{ $index }}][quantite]"
                                           value="{{ $produitCommande->qte_produit_commande }}" oninput="updateMontant($(this).closest('tr'))">
                                </td>
                                <td>
                                    <input type="number" class="form-control montant" name="produits[{{ $index }}][montant]"
                                           value="{{ $produitCommande->montant_produit_commande }}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduit(this)">@lang('Supprimer')</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" onclick="addProduit()">@lang('Ajouter un produit')</button>
            @endcomponent
        </div>
    </div>
    @endcomponent
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        // Fonction pour mettre à jour le prix unitaire et recalculer le montant
        window.updatePrixUnitaire = function (selectElement) {
            const $row = $(selectElement).closest('tr');
            const prixUnitaire = parseFloat($(selectElement).find(':selected').data('price')) || 0;
            $row.find('input[name$="[prix]"]').val(prixUnitaire);

            updateMontant($row);
        };

        // Fonction pour recalculer le montant d'une ligne
        window.updateMontant = function ($row) {
            const prixUnitaire = parseFloat($row.find('input[name$="[prix]"]').val()) || 0;
            const quantite = parseFloat($row.find('input[name$="[quantite]"]').val()) || 0;
            const montant = prixUnitaire * quantite;

            $row.find('input[name$="[montant]"]').val(montant.toFixed(2));
            updateMontantTotal();
        };

        // Fonction pour recalculer le montant total
        function updateMontantTotal() {
            let total = 0;
            $('#produits-container').find('input[name$="[montant]"]').each(function () {
                total += parseFloat($(this).val()) || 0;
            });
            $('#montant_total').val(total.toFixed(2));
        }

        // Ajouter une nouvelle ligne pour un produit
        window.addProduit = function () {
            const index = $('#produits-container tr').length;
            const newRow = `
                <tr>
                    <td>
                        <select class="form-control produit-select" name="produits[${index}][id]" onchange="updatePrixUnitaire(this)">
                            <option value="" disabled selected>Choisissez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_produit }}" data-price="{{ $produit->prix_details_produit }}">
                                    {{ $produit->nom_produit }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="produits[${index}][prix]" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="produits[${index}][quantite]" oninput="updateMontant($(this).closest('tr'))">
                    </td>
                    <td>
                        <input type="number" class="form-control montant" name="produits[${index}][montant]" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeProduit(this)">@lang('Supprimer')</button>
                    </td>
                </tr>`;
            $('#produits-container').append(newRow);
        };

        // Supprimer une ligne de produit
        window.removeProduit = function (button) {
            $(button).closest('tr').remove();
            updateMontantTotal();
        };

        // Mise à jour initiale des montants totaux
        $('#produits-container tr').each(function () {
            updateMontant($(this));
        });
    });
</script>
@endsection
