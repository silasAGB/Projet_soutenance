@extends('boilerplate::layout.index', [
    'title' => __('Créer Production'),
    'subtitle' => __('Ajouter une nouvelle production'),
    'breadcrumb' => [
        __('Productions') => 'boilerplate.productions.gerer',
        __('Créer')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.productions.store', 'method' => 'POST'])
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.productions.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des productions')">
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
                @component('boilerplate::card', ['title' => 'Produit et Détails de Production'])
                    <div class="form-group">
                        <label for="reference_production">Référence de Production</label>
                        <input type="text" class="form-control" id="reference_production" name="reference_production" required>
                    </div>

                    <div class="form-group">
                        <label for="nom_production">Nom de la Production</label>
                        <input type="text" class="form-control" id="nom_production" name="nom_production" required>
                    </div>

                    <div class="form-group">
                        <label for="id_produit">Produit (Nom - Référence)</label>
                        <select class="form-control" id="id_produit" name="id_produit" required>
                            <option value="" disabled selected>Choisissez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_produit }}"
                                    data-qte-par-preparation="{{ $produit->qte_preparation }}"
                                    data-matieres-premieres="{{ $produit->matierePremieres->pluck('pivot.qte', 'nom_MP') }}"
                                    data-unites="{{ $produit->matierePremieres->pluck('unite', 'nom_MP') }}">
                                    {{ $produit->nom_produit }} - {{ $produit->reference }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="matieres-premieres-section" class="mb-3" style="display: none;">
                        <h5>@lang('Matières premières nécessaires :')</h5>
                        <ul id="matieres-premieres-list"></ul>
                    </div>
                @endcomponent
            </div>

            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Détails de la Production'])
                    @component('boilerplate::input', ['type' => 'date', 'name' => 'date_prevue', 'label' => 'Date prévue', 'required' => true, 'value' => old('date_prevue')])@endcomponent

                    <div class="form-group">
                        <label for="qte_prevue">Quantité prévue</label>
                        <input type="number" class="form-control" id="qte_prevue" name="qte_prevue" required>
                    </div>

                    <div class="form-group">
                        <label for="nbr_preparation">Nombre de préparations</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger" id="decrease-preparations">-</button>
                            </span>
                            <input type="number" class="form-control text-center" id="nbr_preparation" name="nbr_preparation" min="1" value="1" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" id="increase-preparations">+</button>
                            </span>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent

    @push('js')
    <script>
        $(document).ready(function() {
            function updateMatieresPremieres() {
                const selectedOption = $('#id_produit').find('option:selected');
                const matieresPremieres = selectedOption.data('matieres-premieres');
                const unites = selectedOption.data('unites');
                const qteParPreparation = selectedOption.data('qte-par-preparation');
                const nbPreparations = parseInt($('#nbr_preparation').val()) || 1;

                const matieresPremieresList = $('#matieres-premieres-list');
                matieresPremieresList.empty();

                if (matieresPremieres && unites) {
                    for (const matierePremiere in matieresPremieres) {
                        const quantite = matieresPremieres[matierePremiere] * nbPreparations;
                        const unite = unites[matierePremiere] || '';
                        matieresPremieresList.append('<li>' + quantite + ' ' + unite + ' de ' + matierePremiere + '</li>');
                    }
                    $('#matieres-premieres-section').show();
                } else {
                    $('#matieres-premieres-section').hide();
                }
            }

            function updatePreparationsAndQuantity() {
                const qteParPreparation = $('#id_produit').find('option:selected').data('qte-par-preparation');
                const qtePrevue = parseFloat($('#qte_prevue').val()) || 0;
                const nbPreparations = parseFloat($('#nbr_preparation').val()) || 0;

                if (qteParPreparation) {
                    if (this.id === 'qte_prevue') {
                        $('#nbr_preparation').val(Math.ceil(qtePrevue / qteParPreparation));
                    } else {
                        $('#qte_prevue').val(nbPreparations * qteParPreparation);
                    }
                    updateMatieresPremieres();
                }
            }

            $('#id_produit').change(function() {
                updatePreparationsAndQuantity();
                updateMatieresPremieres();
            });

            $('#qte_prevue, #nbr_preparation').on('input change', updatePreparationsAndQuantity);

            $('#increase-preparations').click(function() {
                let currentVal = parseInt($('#nbr_preparation').val());
                if (!isNaN(currentVal)) {
                    $('#nbr_preparation').val(currentVal + 1).trigger('input');
                }
            });

            $('#decrease-preparations').click(function() {
                let currentVal = parseInt($('#nbr_preparations').val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    $('#nbr_preparation').val(currentVal - 1).trigger('input');
                }
            });

            updatePreparationsAndQuantity();
            updateMatieresPremieres();
        });
    </script>
    @endpush
@endsection
