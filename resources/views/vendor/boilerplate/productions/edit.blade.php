@extends('boilerplate::layout.index', [
    'title' => 'Modifier Production',
    'breadcrumb' => ['Modifier Production']
])

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form role="form" action="{{ route('boilerplate.productions.update', $production->id_production) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="date_prevue">Date prévue</label>
                        <input type="date" class="form-control" id="date_prevue" name="date_prevue" value="{{ $production->date_prevue }}" required>
                    </div>
                    <div class="form-group">
                        <label for="qte_prevue">Quantité prévue</label>
                        <input type="number" class="form-control" id="qte_prevue" name="qte_prevue" value="{{ $production->qte_prevue }}" required>
                    </div>
                    <div class="form-group">
                        <label for="qte_produite">Quantité produite</label>
                        <input type="number" class="form-control" id="qte_produite" name="qte_produite" value="{{ $production->qte_produite }}">
                    </div>
                    <div class="form-group">
                        <label for="date_production">Date production</label>
                        <input type="date" class="form-control" id="date_production" name="date_production" value="{{ $production->date_production }}">
                    </div>
                    <div class="form-group">
                        <label for="montant_produit">Montant produit</label>
                        <input type="number" class="form-control" id="montant_produit" name="montant_produit" value="{{ $production->montant_produit }}">
                    </div>
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select class="form-control" id="statut" name="statut" required>
                            <option value="en attente d'approbation" {{ $production->statut == 'en attente d\'approbation' ? 'selected' : '' }}>En attente d'approbation</option>
                            <option value="en production" {{ $production->statut == 'en production' ? 'selected' : '' }}>En production</option>
                            <option value="terminé" {{ $production->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            <option value="annulé" {{ $production->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_Produit">Produit</label>
                        <select class="form-control" id="id_Produit" name="id_Produit" required>
                            @foreach($produits as $produit)
                            <option value="{{ $produit->id_Produit }}" {{ $produit->id_Produit == $production->id_Produit ? 'selected' : '' }}>
                                {{ $produit->nom_produit }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        <a href="{{ route("boilerplate.productions.gerer") }}" class="btn btn-default" data-toggle="tooltip" title="Retour à la liste des productions">
                            <span class="far fa-arrow-alt-circle-left text-muted"></span>
                        </a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
