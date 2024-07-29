@extends('boilerplate::layout.index', [
    'title' => __('Modifier un approvisionnement'),
    'subtitle' => __('Mettre à jour un approvisionnement'),
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
                        @lang('Enregistrer')
                    </button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Informations sur l\'approvisionnement'])
                    @component('boilerplate::input', ['type' => 'date', 'name' => 'date_approvisionnement', 'label' => 'Date d\'approvisionnement', 'required' => true, 'value' => old('date_approvisionnement', $approvisionnement->date_approvisionnement)])@endcomponent
                    @component('boilerplate::input', ['name' => 'reference_approvisionnement', 'label' => 'Référence d\'approvisionnement', 'required' => true, 'value' => old('reference_approvisionnement', $approvisionnement->reference_approvisionnement)])@endcomponent
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
                            @foreach($approvisionnement->matieresPremieres as $index => $matiere)
                            <tr>
                                <td>
                                    <select class="form-control matierePremiereSelect" name="matieresPremieres[{{ $index }}][id_MP]" required>
                                        <option value="">Sélectionner une matière première</option>
                                        @foreach($matieresPremieres as $mp)
                                            <option value="{{ $mp->id_MP }}" data-price="{{ $mp->prix_achat }}" {{ $mp->id_MP == $matiere->pivot->id_MP ? 'selected' : '' }}>{{ $mp->nom_MP }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" name="matieresPremieres[{{ $index }}][id_fournisseur]" required>
                                        <option value="">Sélectionner un fournisseur</option>
                                        @foreach($fournisseurs as $fournisseur)
                                            <option value="{{ $fournisseur->id_fournisseur }}" {{ $fournisseur->id_fournisseur == $matiere->pivot->id_fournisseur ? 'selected' : '' }}>{{ $fournisseur->nom_fournisseur }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantity" name="matieresPremieres[{{ $index }}][qte_approvisionnement]" value="{{ old('matieresPremieres.'.$index.'.qte_approvisionnement', $matiere->pivot->qte_approvisionnement) }}" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control montant" name="matieresPremieres[{{ $index }}][montant]" value="{{ old('matieresPremieres.'.$index.'.montant', $matiere->pivot->montant) }}" required readonly>
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
            let rowNumber = {{ $approvisionnement->matieresPremieres->count() }};

            function calculateMontant(row) {
                const quantity = parseFloat(row.find('.quantity').val()) || 0;
                const price = parseFloat(row.find('.matierePremiereSelect option:selected').data('price')) || 0;
                const montant = quantity * price;
                row.find('.montant').val(montant.toFixed(2));
            }

            $('#addRow').click(function() {
                $('#matieresPremieresTable tbody').append(`
                    <tr>
                        <td>
                            <select class="form-control matierePremiereSelect" name="matieresPremieres[${rowNumber}][id_MP]" required>
                                <option value="">Sélectionner une matière première</option>
                                @foreach($matieresPremieres as $matierePremiere)
                                    <option value="{{ $matierePremiere->id_MP }}" data-price="{{ $matierePremiere->prix_achat }}">{{ $matierePremiere->nom_MP }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="matieresPremieres[${rowNumber}][id_fournisseur]" required>
                                <option value="">Sélectionner un fournisseur</option>
                                @foreach($fournisseurs as $fournisseur)
                                    <option value="{{ $fournisseur->id_fournisseur }}">{{ $fournisseur->nom_fournisseur }}</option>
                                @endforeach
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
                `);
                rowNumber++;
            });

            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });

            $(document).on('input', '.quantity', function() {
                const row = $(this).closest('tr');
                calculateMontant(row);
            });

            $(document).on('change', '.matierePremiereSelect', function() {
                const row = $(this).closest('tr');
                calculateMontant(row);
            });
        });
    </script>
    @endpush
@endsection
