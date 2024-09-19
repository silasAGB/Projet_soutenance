@extends('boilerplate::layout.index', [
    'title' => __('Modifier un approvisionnement'),
    'subtitle' => __('Modifier l\'approvisionnement existant'),
    'breadcrumb' => [
        __('Approvisionnements') => 'boilerplate.approvisionnements.gerer',
        __('Modifier')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => ['boilerplate.approvisionnements.update', $approvisionnement->id_approvisionnement], 'method' => 'PUT'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.approvisionnements.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('Mettre à jour')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Informations sur l\'approvisionnement'])
                    @component('boilerplate::input', ['type' => 'date', 'name' => 'date_approvisionnement', 'label' => 'Date d\'approvisionnement', 'required' => true, 'value' => $approvisionnement->date_approvisionnement])@endcomponent
                    @component('boilerplate::input', ['name' => 'reference_approvisionnement', 'label' => 'Référence d\'approvisionnement', 'required' => true, 'value' => $approvisionnement->reference_approvisionnement, 'readonly' => true])@endcomponent

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select name="statut" id="statut" class="form-control" required>
                            <option value="en attente d\'approbation" {{ $approvisionnement->statut == 'en attente d\'approbation' ? 'selected' : '' }}>En attente d'approvisionnement</option>
                            <option value="en attente de livraison" {{ $approvisionnement->statut == 'en attente de livraison' ? 'selected' : '' }}>en attente de livraison</option>
                            <option value="livré" {{ $approvisionnement->statut == 'livré' ? 'selected' : '' }}>livré</option>
                            <option value="Annulé" {{ $approvisionnement->statut == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                @endcomponent
            </div>
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Matières Premières'])
                    <table class="table table-bordered" id="matieresPremieresTable">
                        <thead>
                            <tr>
                                <th>Matière Première</th>
                                <th>Fournisseur</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th><button type="button" class="btn btn-success" id="addRow">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvisionnement->matieresPremieres as $index => $mp)
                                <tr>
                                    <td>
                                        <select class="form-control matierePremiereSelect" name="matieresPremieres[{{ $index }}][id_MP]" required>
                                            <option value="">Sélectionner une matière première</option>
                                            @foreach($matieresPremieres as $matierePremiere)
                                                <option value="{{ $matierePremiere->id_MP }}" data-fournisseurs="{{ json_encode($matierePremiere->fournisseurs) }}" {{ $mp->id_MP == $matierePremiere->id_MP ? 'selected' : '' }}>{{ $matierePremiere->nom_MP }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control fournisseurSelect" name="matieresPremieres[{{ $index }}][id_fournisseur]" required>
                                            <option value="">Sélectionner un fournisseur</option>
                                            @foreach($mp->fournisseurs as $fournisseur)
                                                <option value="{{ $fournisseur->id_fournisseur }}" data-price="{{ $fournisseur->pivot->prix_achat }}" {{ $mp->pivot->id_fournisseur == $fournisseur->id_fournisseur ? 'selected' : '' }}>{{ $fournisseur->nom_fournisseur }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control quantity" name="matieresPremieres[{{ $index }}][qte_approvisionnement]" value="{{ $mp->pivot->qte_approvisionnement }}" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control montant" name="matieresPremieres[{{ $index }}][montant]" value="{{ $mp->pivot->montant }}" required readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger removeRow">-</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
    @endcomponent

    @push('js')
    <script>
        $(document).ready(function() {
    let rowNumber = {{ count($approvisionnement->matieresPremieres) }};

    // Fonction pour désactiver les matières premières déjà sélectionnées
    function updateMatierePremiereOptions() {
        const selectedValues = [];

        // Récupérer toutes les matières premières déjà sélectionnées
        $('.matierePremiereSelect').each(function() {
            const selectedValue = $(this).val();
            if (selectedValue) {
                selectedValues.push(selectedValue);
            }
        });

        // Désactiver les matières premières déjà sélectionnées dans toutes les listes
        $('.matierePremiereSelect').each(function() {
            const currentSelect = $(this);
            currentSelect.find('option').each(function() {
                const value = $(this).val();
                if (value) {
                    if (selectedValues.includes(value) && currentSelect.val() !== value) {
                        $(this).prop('disabled', true);
                    } else {
                        $(this).prop('disabled', false);
                    }
                }
            });
        });
    }

    function calculateMontant(row) {
        const quantity = parseFloat(row.find('.quantity').val()) || 0;
        const price = parseFloat(row.find('.fournisseurSelect option:selected').data('price')) || 0;
        const montant = quantity * price;
        row.find('.montant').val(montant.toFixed(2));
    }

    function populateFournisseurs(row, fournisseurs) {
        const fournisseurSelect = row.find('.fournisseurSelect');
        fournisseurSelect.empty();
        fournisseurSelect.append('<option value="">Sélectionner un fournisseur</option>');
        fournisseurs.forEach(fournisseur => {
            fournisseurSelect.append(`<option value="${fournisseur.id_fournisseur}" data-price="${fournisseur.pivot.prix_achat}">${fournisseur.nom_fournisseur}</option>`);
        });
    }

    $('#addRow').click(function() {
        const newRow = `
            <tr>
                <td>
                    <select class="form-control matierePremiereSelect" name="matieresPremieres[${rowNumber}][id_MP]" required>
                        <option value="">Sélectionner une matière première</option>
                        @foreach($matieresPremieres as $matierePremiere)
                            <option value="{{ $matierePremiere->id_MP }}" data-fournisseurs="{{ json_encode($matierePremiere->fournisseurs) }}">{{ $matierePremiere->nom_MP }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="form-control fournisseurSelect" name="matieresPremieres[${rowNumber}][id_fournisseur]" required>
                        <option value="">Sélectionner un fournisseur</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control quantity" name="matieresPremieres[${rowNumber}][qte_approvisionnement]" required>
                </td>
                <td>
                    <input type="number" step="0.01" class="form-control montant" name="matieresPremieres[${rowNumber}][montant]" required readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeRow">-</button>
                </td>
            </tr>
        `;
        $('#matieresPremieresTable tbody').append(newRow);
        rowNumber++;
        updateMatierePremiereOptions();
    });

    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
        updateMatierePremiereOptions();
    });

    $(document).on('input', '.quantity', function() {
        const row = $(this).closest('tr');
        calculateMontant(row);
    });

    $(document).on('change', '.matierePremiereSelect', function() {
        const row = $(this).closest('tr');
        const fournisseurs = $(this).find('option:selected').data('fournisseurs');
        populateFournisseurs(row, fournisseurs);
        updateMatierePremiereOptions();
    });

    $(document).on('change', '.fournisseurSelect', function() {
        const row = $(this).closest('tr');
        calculateMontant(row);
    });

    updateMatierePremiereOptions();
});
    </script>
    @endpush
@endsection
