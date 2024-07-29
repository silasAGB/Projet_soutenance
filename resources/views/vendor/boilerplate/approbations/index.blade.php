@extends('boilerplate::layout.index', [
    'title' => 'Approbations en attente',
    'breadcrumb' => ['Approbations', 'En attente']
])

@section('content')
<div class="row">
    <div class="col-12">
        <h1>Approbations en attente</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Quantité</th>
                    <th>Montant</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approvisionnements as $approvisionnement)
                    <tr>
                        <td>{{ $approvisionnement->id_approvisionnement }}</td>
                        <td>{{ $approvisionnement->date_approvisionnement }}</td>
                        <td>{{ $approvisionnement->reference_approvisionnement }}</td>
                        <td>{{ $approvisionnement->qte_approvisionnement }}</td>
                        <td>{{ $approvisionnement->montant }}</td>
                        <td>{{ $approvisionnement->status }}</td>
                        <td>
                            <form action="{{ route('approbations.approuvé', ['id' => $approvisionnement->id_approvisionnement, 'type' => 'approvisionnement']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Approuver</button>
                            </form>
                            <form action="{{ route('approbations.rejeté', ['id' => $approvisionnement->id_approvisionnement, 'type' => 'approvisionnement']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Productions</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date prévue</th>
                    <th>Quantité prévue</th>
                    <th>Quantité produite</th>
                    <th>Date de production</th>
                    <th>Montant produit</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productions as $production)
                    <tr>
                        <td>{{ $production->id_production }}</td>
                        <td>{{ $production->date_prevue }}</td>
                        <td>{{ $production->qte_prevue }}</td>
                        <td>{{ $production->qte_produite }}</td>
                        <td>{{ $production->date_production }}</td>
                        <td>{{ $production->montant_produit }}</td>
                        <td>{{ $production->statut }}</td>
                        <td>
                            <form action="{{ route('approbations.approuvé', ['id' => $production->id_production, 'type' => 'production']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Approuver</button>
                            </form>
                            <form action="{{ route('approbations.rejeté', ['id' => $production->id_production, 'type' => 'production']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
