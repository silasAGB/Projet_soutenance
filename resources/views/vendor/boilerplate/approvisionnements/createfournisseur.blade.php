@extends('boilerplate::layout.index', [
    'title' => 'Créer Fournisseur',
    'breadcrumb' => ['Créer Fournisseur']
])

@section('content')
    <form role="form" action="{{ route('boilerplate.fournisseurs.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 pb-3">
                <a href="{{ route('boilerplate.approvisionnements.fournisseurs') }}" class="btn btn-default" data-toggle="tooltip" title="Retour à la liste des fournisseurs">
                    <span class="far fa-arrow-alt-circle-left text-muted"></span>
                </a>
                <span class="btn-group float-right">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg">
                @component('boilerplate::card', ['title' => 'Informations Fournisseur'])
                    <div class="form-group">
                        <label for="nom_fournisseur">Nom du fournisseur</label>
                        <input type="text" class="form-control" id="nom_fournisseur" name="nom_fournisseur" placeholder="Nom du fournisseur" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_fournisseur">Contact du fournisseur</label>
                        <input type="text" class="form-control" id="contact_fournisseur" name="contact_fournisseur" placeholder="Contact du fournisseur" required>
                    </div>
                    <div class="form-group">
                        <label for="email_fournisseur">Email du fournisseur</label>
                        <input type="email" class="form-control" id="email_fournisseur" name="email_fournisseur" placeholder="Email du fournisseur" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse_fournisseur">Adresse du fournisseur</label>
                        <textarea class="form-control" id="adresse_fournisseur" name="adresse_fournisseur" rows="3" placeholder="Adresse du fournisseur" required></textarea>
                    </div>
                @endcomponent
            </div>
        </div>
    </form>
@endsection
