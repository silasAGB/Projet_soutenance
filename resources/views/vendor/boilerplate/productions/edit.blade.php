@extends('boilerplate::layout.index', [
    'title' => __('Modifier Production'),
    'subtitle' => __('Modification d\'une production existante'),
    'breadcrumb' => [
        __('Productions') => 'boilerplate.productions.gerer',
        __('Modifier')
    ]
])
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@component('boilerplate::form', ['route' => ['boilerplate.productions.update', $production->id_production], 'method' => 'POST'])
@csrf
<input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.productions.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des productions')">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">
                        @lang('Enregistrer')
                    </button>
                </span>
            </div>
        </div>
        <!-- Alerte de stock insuffisant -->
        <div class="alert alert-warning" id="stock-alert" style="display: none;">
            <strong>Attention !</strong> Certaines matières premières sont insuffisantes pour cette production.
        </div>
        <!-- Bouton de redirection vers les approvisionnements -->
        <div class="text-right mb-3" id="approvisionnement-btn" style="display: none;">
            <a href="{{ route('boilerplate.approvisionnements.gerer') }}" class="btn btn-danger">
                Programmer des approvisionnements
            </a>
        </div>
        <div class="row">
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Produit et Matières Premières'])
                    <div class="form-group">
                        <label for="id_produit">Produit</label>
                        <select class="form-control" id="id_produit" name="id_produit" required>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_produit }}"
                                    data-qte-par-preparation="{{ $produit->qte_preparation }}"
                                    data-matieres-premieres="{{ json_encode($produit->matierePremieres->pluck('pivot.qte', 'nom_MP')) }}"
                                    data-unites="{{ json_encode($produit->matierePremieres->pluck('unite', 'nom_MP')) }}"
                                    data-stock="{{ json_encode($produit->matierePremieres->pluck('qte_stock', 'nom_MP')->toArray()) }}  "
                                    {{ $production->id_Produit == $produit->id_produit ? 'selected' : '' }}>
                                    {{ $produit->nom_produit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="matieres-premieres-section" class="mb-3" style="display: none;">
                        <h5>@lang('Matières premières nécessaires :')</h5>
                        <ul id="matieres-premieres-list">
                            <!-- La liste sera remplie dynamiquement par JavaScript -->
                        </ul>
                    </div>
                @endcomponent
            </div>
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Détails de la Production'])
                    <div class="form-group">
                        <label for="reference_production">Référence de Production</label>
                        <input type="text" class="form-control" id="reference_production" name="reference_production" value="{{ $production->reference_production }}" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="date_prevue">Date prévue</label>
                        <input type="date" class="form-control" id="date_prevue" name="date_prevue" value="{{ $production->date_prevue }}" required>
                    </div>
                    <div class="form-group">
                        <label for="heure_prevue">Heure prévue</label>
                        <input type="time" class="form-control" id="heure_prevue" name="heure_prevue" value="{{ old('heure_prevue', date('H:i', strtotime($production->heure_prevue))) }}" required>
                        @if ($errors->has('heure_prevue'))
                            <span class="text-danger">{{ $errors->first('heure_prevue') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="qte_prevue">Quantité prévue</label>
                        <input type="number" class="form-control" id="qte_prevue" name="qte_prevue" value="{{ $production->qte_prevue }}">
                    </div>
                    <div class="form-group">
                        <label for="nbr_preparation">Nombre de préparations</label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger" id="decrease-preparations">-</button>
                            </span>
                            <input type="number" class="form-control text-center" id="nbr_preparation" name="nbr_preparation" min="0" value="{{ $production->nbr_preparation }}">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" id="increase-preparations">+</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select class="form-control" id="statut" name="statut" required>
                            <option value="En attente d'approbation" {{ $production->statut == 'En attente d\'approbation' ? 'selected' : '' }}>En attente d'approbation</option>
                            <option value="En attente de production" {{ $production->statut == 'En attente de production' ? 'selected' : '' }}>En attente de production</option>
                            <option value="En cours de production" {{ $production->statut == 'En cours de production' ? 'selected' : '' }}>En cours de production</option>
                            <option value="Terminé" {{ $production->statut == 'Terminé' ? 'selected' : '' }}>Terminé</option>
                        </select>
                    </div>
                    <div id="completed-fields" style="{{ $production->statut == 'Terminé' ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="qte_produite">Quantité produite</label>
                            <input type="number" class="form-control" id="qte_produite" name="qte_produite" value="{{ $production->qte_produite }}">
                        </div>
                        <div class="form-group">
                            <label for="date_production">Date de production</label>
                            <input type="date" class="form-control" id="date_production" name="date_production" value="{{ $production->date_production }}">
                        </div>
                        <div class="form-group">
                            <label for="heure_production">Heure de production</label>
                            <input type="time" class="form-control" id="heure_production" name="heure_production" value="{{ $production->heure_production }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nom_personnel">Personnel affectée </label>
                        <input type="text" class="form-control" id="nom_personnel" name="nom_personnel" value="{{ $production->nom_personnel }}" required>
                    </div>
                    <div class="form-group">
                        <label for="consignes_specifiques">Consignes spécifiques</label>
                        <textarea class="form-control" id="consignes_specifiques" name="consignes_specifiques" rows="3">{{ $production->consignes_specifiques }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="autres_remarques">Autres remarques</label>
                        <textarea class="form-control" id="autres_remarques" name="autres_remarques" rows="3">{{ $production->autres_remarques }}</textarea>
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent
        @push('js')
        <script>
            $(document).ready(function() {
                /**
                 * Fonction pour mettre à jour la liste des matières premières nécessaires.
                 */
               /* function updateMatieresPremieres() {
                    const matieresPremieres = $('#id_produit').find('option:selected').data('matieres-premieres');
                    const unites = $('#id_produit').find('option:selected').data('unites');
                    const nbPreparations = parseInt($('#nbr_preparation').val()) || 1;
                */
                function updateMatieresPremieres() {
    const matieresPremieres = $('#id_produit').find('option:selected').data('matieres-premieres') || {};
    const unites = $('#id_produit').find('option:selected').data('unites') || {};
    const stocks = JSON.parse($('#id_produit').find('option:selected').data('stock')) || {}; // Parse le stock
    const nbPreparations = parseInt($('#nbr_preparation').val()) || 1;
    const matieresPremieresList = $('#matieres-premieres-list');
    matieresPremieresList.empty();
    let stockInsuffisant = false;

    if (matieresPremieres && unites) {
        for (const [matiere, quantite] of Object.entries(matieresPremieres)) {
            const totalQuantite = quantite * nbPreparations;
            const unite = unites[matiere] || '';
            const quantiteEnStock = parseFloat(stocks[matiere]) || 0; // Utiliser le stock récupéré

            if (totalQuantite > quantiteEnStock) {
                matieresPremieresList.append(`<li style="color: red;">${matiere}: ${totalQuantite} ${unite} (Insuffisant, stock actuel : ${quantiteEnStock})</li>`);
                stockInsuffisant = true;
            } else {
                matieresPremieresList.append(`<li>${matiere}: ${totalQuantite} ${unite}</li>`);
            }
        }

        console.log('Stocks:', stocks);
console.log('Quantité en stock pour Huile de Neem:', stocks['Huile de Neem']);
    }

    // Affiche ou masque les alertes en fonction de la disponibilité des stocks
    if (stockInsuffisant) {
        $('#stock-alert').show();
        $('#approvisionnement-btn').show();
    } else {
        $('#stock-alert').hide();
        $('#approvisionnement-btn').hide();
    }
}
                /**
                 * Fonction pour mettre à jour le nombre de préparations en fonction de la quantité prévue.
                 */
                function updateNbPreparations() {
                    const qteParPreparation = $('#id_produit').find('option:selected').data('qte-par-preparation');
                    const qtePrevue = parseFloat($('#qte_prevue').val());
                    if (qteParPreparation && qtePrevue) {
                        const nbPreparations = Math.ceil(qtePrevue / qteParPreparation);
                        $('#nbr_preparation').val(nbPreparations);
                        updateMatieresPremieres();
                    }
                }
                /**
                 * Fonction pour mettre à jour la quantité prévue en fonction du nombre de préparations.
                 */
                function updateQtePrevue() {
                    const qteParPreparation = $('#id_produit').find('option:selected').data('qte-par-preparation');
                    const nbPreparations = parseInt($('#nbr_preparation').val());
                    if (qteParPreparation && nbPreparations) {
                        const qtePrevue = nbPreparations * qteParPreparation;
                        $('#qte_prevue').val(qtePrevue);
                        updateMatieresPremieres();
                    }
                }
                /**
                 * Fonction pour gérer l'affichage des champs conditionnels en fonction du statut sélectionné.
                 */
                function handleStatusChange() {
                    const statut = $('#statut').val();
                    if (statut === 'Terminé') {
                        $('#completed-fields').show();
                    } else {
                        $('#completed-fields').hide();
                        $('#qte_produite').val('');
                        $('#date_production').val('');
                    }

                    // Désactiver ou activer les champs en fonction du statut
                    const fieldsToDisable = ['#date_prevue', '#heure_prevue', '#qte_prevue', '#nbr_preparation'];
                    if (statut === 'En cours de production') {
                        $(fieldsToDisable.join(',')).prop('readonly', true);
                        $('#increase-preparations, #decrease-preparations').prop('disabled', true); // cela me desactive les bouttons
                    } else {
                        $(fieldsToDisable.join(',')).prop('readonly', false);
                        $('#increase-preparations, #decrease-preparations').prop('disabled', false);
                    }
                }
                /**
                 * Gestionnaire d'événement pour le changement de produit sélectionné.
                 */
                $('#id_produit').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const matieresPremieresSection = $('#matieres-premieres-section');
                    matieresPremieresSection.show();
                    updateNbPreparations();
                    updateQtePrevue();
                });
                /**
                 * Gestionnaire d'événement pour le changement de quantité prévue.
                 */
                $('#qte_prevue').on('input', updateNbPreparations);
                /**
                 * Gestionnaire d'événement pour le changement du nombre de préparations.
                 */
                $('#nbr_preparation').on('input', updateQtePrevue);
                /**
                 * Gestionnaire d'événement pour les boutons d'ajustement du nombre de préparations.
                 */
                $('#increase-preparations').on('click', function() {
                    $('#nbr_preparation').val(function(i, val) {
                        return parseInt(val) + 1;
                    });
                    updateQtePrevue();
                });
                $('#decrease-preparations').on('click', function() {
                    $('#nbr_preparation').val(function(i, val) {
                        return Math.max(0, parseInt(val) - 1);
                    });
                    updateQtePrevue();
                });
                $('#statut').on('change', handleStatusChange);
                /**
                 * Initialisation de l'affichage des matières premières à la charge de la page.
                 */
                function initializeMatieresPremieres() {
                    const matieresPremieresSection = $('#matieres-premieres-section');
                    const selectedOption = $('#id_produit').find('option:selected');
                    if (selectedOption.val()) {
                        matieresPremieresSection.show();
                        updateMatieresPremieres();
                    } else {
                        matieresPremieresSection.hide();
                    }
                }
                
                /**
                 * Initialisation de l'affichage des champs conditionnels en fonction du statut actuel.
                 */
                function initializeStatus() {
                    handleStatusChange();
                }
                /**
                 * Initialisation du nombre de préparations en fonction de la quantité prévue.
                 */
                function initializeNbPreparations() {
                    updateNbPreparations();
                }
                initializeMatieresPremieres();
                initializeStatus();
                initializeNbPreparations();
            });
        </script>
        @endpush
    @endsection
