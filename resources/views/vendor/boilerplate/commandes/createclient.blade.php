@extends('boilerplate::layout.index', [
    'title' => __('Créer Client'),
    'subtitle' => __('Ajouter un nouveau client'),
    'breadcrumb' => [
        __('Clients') => 'boilerplate.commandes.client',
        __('Créer')
    ]
])

@section('content')
    @component('boilerplate::form', ['route' => 'boilerplate.client.store', 'method' => 'POST'])
    @csrf
    <div class="row">
        <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.commandes.client') }}" class="btn btn-default" data-toggle="tooltip" title="@lang('Retour à la liste des clients')">
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
                @component('boilerplate::card', ['title' => 'Informations du Client'])
                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'nom_client',
                        'label' => 'Nom',
                        'required' => true,
                        'value' => old('nom_client')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'prenom_client',
                        'label' => 'Prénom',
                        'required' => true,
                        'value' => old('prenom_client')
                    ])
                    @endcomponent

                    <!-- Section : Date de naissance, Sexe et Âge -->
                    <div class="row">
                        <div class="col-lg-4">
                            @component('boilerplate::input', [
                                'type' => 'date',
                                'name' => 'date_naissance',
                                'label' => 'Date de naissance',
                                'value' => old('date_naissance')
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-4">
                            @component('boilerplate::input', [
                                'type' => 'select',
                                'name' => 'sexe',
                                'label' => 'Sexe',
                                'options' => [
                                    'M' => 'Masculin',
                                    'F' => 'Féminin',
                                    'N' => 'Non précisé'
                                ],
                                'value' => old('sexe')
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-4">
                            @component('boilerplate::input', [
                                'type' => 'text',
                                'name' => 'age',
                                'label' => 'Âge (calculé)',
                                'value' => '',
                                'readonly' => true
                            ])
                            @endcomponent
                        </div>
                    </div>

                    @component('boilerplate::input', [
                        'type' => 'email',
                        'name' => 'mail_client',
                        'label' => 'Email',
                        'required' => true,
                        'value' => old('mail_client')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'contact_client',
                        'label' => 'Numéro de contact',
                        'required' => true,
                        'value' => old('contact_client')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'adresse_client',
                        'label' => 'Adresse',
                        'required' => true,
                        'value' => old('adresse_client')
                    ])
                    @endcomponent
                @endcomponent
            </div>

            <div class="col-lg-6">
                @component('boilerplate::card', ['title' => 'Entreprise et Statut'])
                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'nom_entreprise',
                        'label' => 'Nom de l\'entreprise',
                        'value' => old('nom_entreprise')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'poste_occupe',
                        'label' => 'Poste occupé',
                        'value' => old('poste_occupe')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'type_entreprise',
                        'label' => 'Type d\'entreprise',
                        'value' => old('type_entreprise')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'secteur_activite',
                        'label' => 'Secteur d\'activité',
                        'value' => old('secteur_activite')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'num_identification_fiscale',
                        'label' => 'Numéro d\'identification fiscale',
                        'value' => old('num_identification_fiscale')
                    ])
                    @endcomponent

                    @component('boilerplate::input', [
                        'type' => 'text',
                        'name' => 'num_registre_commerce',
                        'label' => 'Numéro registre de commerce',
                        'value' => old('num_registre_commerce')
                    ])
                    @endcomponent
                @endcomponent
            </div>
        </div>

    @endcomponent
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateNaissanceField = document.querySelector('input[name="date_naissance"]');
        const ageField = document.querySelector('input[name="age"]');

        dateNaissanceField.addEventListener('change', function() {
            const dateNaissance = new Date(dateNaissanceField.value);
            const today = new Date();
            let age = today.getFullYear() - dateNaissance.getFullYear();
            const monthDiff = today.getMonth() - dateNaissance.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dateNaissance.getDate())) {
                age--;
            }

            ageField.value = isNaN(age) ? '' : age;
        });
    });
</script>
@endpush
