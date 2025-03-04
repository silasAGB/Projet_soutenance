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
            <div class="col-lg-4">
                @component('boilerplate::card', ['title' => 'Informations sur l\'approvisionnement'])
                    @component('boilerplate::input', ['type' => 'date', 'name' => 'date_approvisionnement', 'label' => 'Date d\'approvisionnement', 'required' => true, 'value' => $approvisionnement->date_approvisionnement])@endcomponent
                    @component('boilerplate::input', ['name' => 'reference_approvisionnement', 'label' => 'Référence d\'approvisionnement', 'required' => true, 'value' => $approvisionnement->reference_approvisionnement, 'readonly' => true])@endcomponent

                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select name="statut" id="statut" class="form-control" required>
                            <option value="en attente d'approbation" {{ $approvisionnement->statut == 'en attente d\'approbation' ? 'selected' : '' }}>En attente d'approbation</option>
                            <option value="en attente de livraison" {{ $approvisionnement->statut == 'en attente de livraison' ? 'selected' : '' }}>en attente de livraison</option>
                            <option value="livré" {{ $approvisionnement->statut == 'livré' ? 'selected' : '' }}>livré</option>
                            <option value="Annulé" {{ $approvisionnement->statut == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                @endcomponent
            </div>
            <div class="col-lg-8">
                @component('boilerplate::card', ['title' => 'Matières Premières'])
                    <table class="table table-bordered" id="matieresPremieresTable">
                        <thead>
                            <tr>
                                <th>Matière Première</th>
                                <th>Fournisseur</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Quantité livrée</th>
                                <th>Date de livraison</th>
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
                                        <select class="form-control statut" name="matieresPremieres[{{ $index }}][statut]" required>
                                            <option value="livrée" {{ $mp->pivot->statut == 'livrée' ? 'selected' : '' }}>Livrée</option>
                                            <option value="en attente" {{ $mp->pivot->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control qteLivree" name="matieresPremieres[{{ $index }}][qte_livree]" value="{{ $mp->pivot->qte_livree }}" {{ $mp->pivot->statut != 'livrée' ? 'disabled' : '' }}>
                                    </td>
                                    <td>
                                        <input type="date" class="form-control dateLivraison" name="matieresPremieres[{{ $index }}][date_livraison]" value="{{ $mp->pivot->date_livraison }}" {{ $mp->pivot->statut != 'livrée' ? 'disabled' : '' }}>
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
                            <input type="number" class="form-control quantity" name="matieresPremires[${rowNumber}][qte_approvisionnement]" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control montant" name="matieresPremires[${rowNumber}][montant]" required readonly>
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

            $('#matieresPremieresTable').on('change', '.matierePremiereSelect', function() {
                const row = $(this).closest('tr');
                const selectedOption = $(this).find('option:selected');
                const fournisseurs = JSON.parse(selectedOption.data('fournisseurs'));
                populateFournisseurs(row, fournisseurs);
                calculateMontant(row);
                updateMatierePremiereOptions();
            });

            $('#matieresPremieresTable').on('change', '.quantity', function() {
                const row = $(this).closest('tr');
                calculateMontant(row);
            });

            $('#matieresPremieresTable').on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
                updateMatierePremiereOptions();
            });

            $('#matieresPremieresTable').on('change', '.statut', function() {
                const row = $(this).closest('tr');
                const statut = $(this).val();
                const qteLivree = row.find('.qteLivree');
                const dateLivraison = row.find('.dateLivraison');

                if (statut === 'livrée') {
                    qteLivree.prop('disabled', false);
                    dateLivraison.prop('disabled', false);
                } else {
                    qteLivree.prop('disabled', true).val('');
                    dateLivraison.prop('disabled', true).val('');
                }
            }); /* Cela concerne les qte_livrée et date de livraison des matière première */

            function checkStatut() {
        const statut = $('#statut').val();
        const isLocked = statut === 'en attente de livraison'|| 'Livré';

        // Désactiver ou activer les champs en fonction du statut
        $('input[name="date_approvisionnement"]').prop('readonly', isLocked);
        $('.matierePremiereSelect').prop('disabled', isLocked);
        $('.fournisseurSelect').prop('disabled', isLocked);
        $('.quantity').prop('readonly', isLocked);


        $('.matierePremiereSelect, .fournisseurSelect').each(function() {
        const $this = $(this);
        if (isLocked) {
            // Créez un champ caché pour soumettre la valeur
            const hiddenInput = $('<input type="hidden" name="' + $this.attr('name') + '" value="' + $this.val() + '">');
            $this.parent().append(hiddenInput);
        } else {
            // Supprimez le champ caché si le statut est modifiable
            $this.parent().find('input[type="hidden"][name="' + $this.attr('name') + '"]').remove();
        }
    });


    }

    // Appel initial pour vérifier le statut
    checkStatut();

            $('#statut').change(function() {

                checkStatut();

                if ($(this).val() === 'livré') {
                    $('#livraisonFields').show();
                } else {
                    $('#livraisonFields').hide();
                }
            }).change(); // Trigger change event to set initial state

            updateMatierePremiereOptions(); // Initial call to set disabled options
        });
    </script>
    @endpush
@endsection
