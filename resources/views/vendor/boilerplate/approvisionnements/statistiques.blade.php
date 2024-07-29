    @extends('boilerplate::layout.index', [
        'title' => 'Statistique Approvisionnements',
        'breadcrumb' => ['Approvisionnements', 'Statistiques']
    ])

    @section('content')

    <div class="row">
        <div class="col-md-4">
            @component('boilerplate::smallbox', [
                'text' => 'En attente d\'approbation',
                'nb' => $approvisionnementsEnAttenteApprobation,
                'icon' => 'fa-solid fa-hourglass-half',
                'link' => route('boilerplate.approvisionnements.gerer'),
                'linkText' => 'Voir plus',
                'color' => 'warning'
                ])
                @endcomponent
        </div>
        <div class="col-md-4">
            @component('boilerplate::smallbox', [
                'text' => __('En attente de livraison'),
                'nb' => $approvisionnementsEnAttenteLivraison,
                'icon' => 'fa-solid fa-truck',
                'link' => route('boilerplate.approvisionnements.gerer'),
                'linkText' => __('Voir plus'),
                'color' => 'info'
            ])
            @endcomponent
        </div>
        <div class="col-md-4">
            @component('boilerplate::smallbox', [
                'text' => __('Effectués ce mois'),
                'nb' => $approvisionnementsEffectueCeMois,
                'icon' => 'fa-solid fa-calendar-check',
                'link' => route('boilerplate.approvisionnements.gerer'),
                'linkText' => __('Voir plus'),
                'color' => 'success'
            ])
            @endcomponent
        </div>
    </div>
    @endsection
