@extends('boilerplate::layout.index', [
    'title' => 'Approbations',
    'subtitle' => 'Gérer les approbations',
    'breadcrumb' => [
        __('Approvisionnements') => 'boilerplate.approbations.gerer',
        __('Créer')
    ]
])

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Productions en attente d'approbation</h3>
    </div>
    <div class="card-body">
        @if($productions->isEmpty())
            <p>Aucune production en attente d'approbation.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Date prévue</th>
                        <th>Quantité prévue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productions as $production)
                        <tr>
                            <td>{{ $production->reference_production }}</td>
                            <td>{{ $production->nom_production }}</td>
                            <td>{{ $production->date_prevue }}</td>
                            <td>{{ $production->qte_prevue }}</td>
                            <td>
                                <a href="{{ route('boilerplate.approbations.valider.production', $production->id_production) }}" class="btn btn-success">Valider</a>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#refusModal" data-id="{{ $production->id }}" data-type="production">Refuser</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Approvisionnements en attente d'approbation</h3>
    </div>
    <div class="card-body">
        @if($approvisionnements->isEmpty())
            <p>Aucun approvisionnement en attente d'approbation.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvisionnements as $approvisionnement)
                        <tr>
                            <td>{{ $approvisionnement->reference_approvisionnement }}</td>
                            <td>{{ $approvisionnement->date_approvisionnement }}</td>
                            <td>{{ $approvisionnement->formatted_montant }}</td>
                            <td>
                                <a href="{{ route('boilerplate.approbations.valider.approvisionnement', $approvisionnement->id_approvisionnement) }}" class="btn btn-success">Valider</a>
                                <button class="btn btn-danger" data-toggle="modal" data-target="#refusModal" data-id="{{ $approvisionnement->id_approvisionnement }}" data-type="approvisionnement">Refuser</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!-- Modal de refus -->
<div class="modal fade" id="refusModal" tabindex="-1" role="dialog" aria-labelledby="refusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="" id="refusForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="refusModalLabel">Raison du refus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="raison">Raison</label>
                        <textarea name="raison" id="raison" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Refuser</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#refusModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var type = button.data('type');
        var form = $('#refusForm');

        if (type === 'production') {
            form.attr('action', '/approbations/production/refuser/' + id);
        } else if (type === 'approvisionnement') {
            form.attr('action', '/approbations/approvisionnement/refuser/' + id);
        }
    });
</script>

@endsection
