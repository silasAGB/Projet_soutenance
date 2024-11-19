@extends('boilerplate::layout.index', [
    'title' => 'Modifier Commande',
    'breadcrumb' => ['Commandes', 'Modifier']
])

@section('content')
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route('boilerplate.commandes.gerer') }}" class="btn btn-primary">
                @lang('Liste des commandes')
            </a>
        </span>
    </div>
</div>

@component('boilerplate::card')
    <h4 class="card-title">@lang('Modifier la commande')</h4>
    <form action="{{ route('boilerplate.commandes.edit', $commande->id_commande) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="reference_commande">@lang('Référence de la commande')</label>
            <input type="text" id="reference_commande" name="reference_commande"
                   class="form-control @error('reference_commande') is-invalid @enderror"
                   value="{{ old('reference_commande', $commande->reference_commande) }}" required>
            @error('reference_commande')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_commande">@lang('Date de la commande')</label>
            <input type="date" id="date_commande" name="date_commande"
                   class="form-control @error('date_commande') is-invalid @enderror"
                   value="{{ old('date_commande', $commande->date_commande) }}" required>
            @error('date_commande')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="montant">@lang('Montant')</label>
            <input type="number" id="montant" name="montant" step="0.01"
                   class="form-control @error('montant') is-invalid @enderror"
                   value="{{ old('montant', $commande->montant) }}" required>
            @error('montant')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="adresse_livraison">@lang('Adresse de livraison')</label>
            <input type="text" id="adresse_livraison" name="adresse_livraison"
                   class="form-control @error('adresse_livraison') is-invalid @enderror"
                   value="{{ old('adresse_livraison', $commande->adresse_livraison) }}" required>
            @error('adresse_livraison')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="date_livraison">@lang('Date de livraison')</label>
            <input type="date" id="date_livraison" name="date_livraison"
                   class="form-control @error('date_livraison') is-invalid @enderror"
                   value="{{ old('date_livraison', $commande->date_livraison) }}">
            @error('date_livraison')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="statut">@lang('Statut')</label>
            <select id="statut" name="statut"
                    class="form-control @error('statut') is-invalid @enderror" required>
                <option value="en attente" {{ old('statut', $commande->statut) == 'en attente' ? 'selected' : '' }}>@lang('En attente')</option>
                <option value="en cours" {{ old('statut', $commande->statut) == 'en cours' ? 'selected' : '' }}>@lang('En cours')</option>
                <option value="livré" {{ old('statut', $commande->statut) == 'livré' ? 'selected' : '' }}>@lang('Livré')</option>
                <option value="Terminé" {{ old('statut', $commande->statut) == 'Terminé' ? 'selected' : '' }}>@lang('Terminé')</option>
            </select>
            @error('statut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_client">@lang('Client')</label>
            <select id="id_client" name="id_client"
                    class="form-control @error('id_client') is-invalid @enderror" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ old('id_client', $commande->id_client) == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} {{ $client->prenom }}
                    </option>
                @endforeach
            </select>
            @error('id_client')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">@lang('Enregistrer')</button>
    </form>
@endcomponent
@endsection
