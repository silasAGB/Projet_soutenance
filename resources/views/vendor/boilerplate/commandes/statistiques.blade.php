@extends('boilerplate::layout.index', [
    'title' => 'Statistiques Approvisionnements',
    'breadcrumb' => ['Approvisionnements', 'Statistiques']
])

@section('content')
<h1>Statistiques des approvisionnements</h1>

<div class="row">
    <div class="col-md-4">
        <x-smallbox color="orange" :nb="$approvisionnementsEnAttenteApprobation" text="En attente d'approbation" icon="fas fa-clock" link="#" link-text="Plus d'infos"/>
    </div>
    <div class="col-md-4">
        <x-smallbox color="blue" :nb="$approvisionnementsEnAttenteLivraison" text="En attente de livraison" icon="fas fa-truck" link="#" link-text="Plus d'infos"/>
    </div>
    <div class="col-md-4">
        <x-smallbox color="green" :nb="$approvisionnementsEffectueCeMois" text="Effectués ce mois" icon="fas fa-check" link="#" link-text="Plus d'infos"/>
    </div>
</div>
@endsection

