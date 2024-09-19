@extends('boilerplate::layout.index', [
    'title' => __('Créer un approvisionnement'),
    'subtitle' => __('Ajouter un nouvel approvisionnement'),
    'breadcrumb' => [
        __('Approvisionnements') => 'boilerplate.approvisionnements.gerer',
        __('Créer')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.approvisionnements.store', 'method' => 'POST'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.approvisionnements.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste')">
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
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Informations sur l\'approvisionnement'])
                    @component('boilerplate::input', ['type' => 'date', 'name' => 'date_approvisionnement', 'label' => 'Date d\'approvisionnement', 'required' => true, 'value' => old('date_approvisionnement')])@endcomponent
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
                            <tr>
                                <td>
                                    <select class="form-control matierePremiereSelect" name="matieresPremieres[0][id_MP]" required>
                                        <option value="">Sélectionner une matière première</option>
                                        @foreach($matieresPremieres as $matierePremiere)
                                            <option value="{{ $matierePremiere->id_MP }}" data-fournisseurs="{{ json_encode($matierePremiere->fournisseurs) }}">
                                                {{ $matierePremiere->nom_MP }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control fournisseurSelect" name="matieresPremieres[0][id_fournisseur]" required>
                                        <option value="">Sélectionner un fournisseur</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="matieresPremieres[0][qte_approvisionnement]" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control montant" name="matieresPremieres[0][montant]" required readonly>
                                </td>
                                <td><button type="button" class="btn btn-danger removeRow">-</button></td>
                            </tr>
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
    @endcomponent

    <script>
        $(document).ready(function() {
    let rowNumber = 1;

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
            fournisseurSelect.append(
                `<option value="${fournisseur.id_fournisseur}" data-price="${fournisseur.pivot.prix_achat}">
                    ${fournisseur.nom_fournisseur}
                </option>`
            );
        });
    }

    function updateMatierePremiereOptions() {
        const selectedMatieres = $('.matierePremiereSelect').map(function() {
            return $(this).val();
        }).get();

        $('.matierePremiereSelect').each(function() {
            const currentSelect = $(this);
            const currentValue = currentSelect.val();

            currentSelect.find('option').each(function() {
                const optionValue = $(this).val();

                if (selectedMatieres.includes(optionValue) && optionValue !== currentValue) {
                    $(this).attr('disabled', true);  // Désactiver les options déjà sélectionnées
                } else {
                    $(this).attr('disabled', false); // Réactiver les options non sélectionnées
                }
            });
        });
    }

    $('#addRow').click(function() {
        const newRow = `
            <tr>
                <td>
                    <select class="form-control matierePremiereSelect" name="matieresPremieres[${rowNumber}][id_MP]" required>
                        <option value="">Sélectionner une matière première</option>
                        @foreach($matieresPremieres as $matierePremiere)
                            <option value="{{ $matierePremiere->id_MP }}" data-fournisseurs="{{ json_encode($matierePremiere->fournisseurs) }}">
                                {{ $matierePremiere->nom_MP }}
                            </option>
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
});

    </script>
@endsection
