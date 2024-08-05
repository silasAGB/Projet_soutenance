@extends('adminlte::page')

@section('title', 'Approbations')

@section('content_header')
    <h1>Approbations en attente</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Productions en attente d'approbation</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date Prévue</th>
                                <th>Quantité Prévue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productions as $production)
                                <tr>
                                    <td>{{ $production->id_production }}</td>
                                    <td>{{ $production->date_prevue }}</td>
                                    <td>{{ $production->qte_prevue }}</td>
                                    <td>
                                        <form action="{{ route('approbations.approve') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $production->id_production }}">
                                            <input type="hidden" name="type" value="production">
                                            <button type="submit" class="btn btn-success">Accepté</button>
                                        </form>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuseModal" data-id="{{ $production->id_production }}" data-type="production">Refusé</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Approvisionnements en attente d'approbation</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Référence</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvisionnements as $approvisionnement)
                                <tr>
                                    <td>{{ $approvisionnement->id_approvisionnement }}</td>
                                    <td>{{ $approvisionnement->reference_approvisionnement }}</td>
                                    <td>{{ $approvisionnement->date }}</td>
                                    <td>
                                        <form action="{{ route('approbations.approve') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $approvisionnement->id_approvisionnement }}">
                                            <input type="hidden" name="type" value="approvisionnement">
                                            <button type="submit" class="btn btn-success">Accepté</button>
                                        </form>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#refuseModal" data-id="{{ $approvisionnement->id_approvisionnement }}" data-type="approvisionnement">Refusé</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Refuse Modal -->
    <div class="modal fade" id="refuseModal" tabindex="-1" role="dialog" aria-labelledby="refuseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refuseModalLabel">Raison du Refus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('approbations.refuse') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="refuse-id">
                        <input type="hidden" name="type" id="refuse-type">
                        <div class="form-group">
                            <label for="raison_refus">Raison du Refus</label>
                            <textarea class="form-control" id="raison_refus" name="raison_refus" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-danger">Refuser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#refuseModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var type = button.data('type')
            var modal = $(this)
            modal.find('.modal-body #refuse-id').val(id)
            modal.find('.modal-body #refuse-type').val(type)
        })
    </script>
@stop
