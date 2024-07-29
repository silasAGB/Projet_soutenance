@extends('boilerplate::layout.index', [
    'title' => 'Modifier Fournisseur',
    'breadcrumb' => ['Modifier Fournisseur']
])

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form role="form" action="{{ route('boilerplate.fournisseurs.update', $fournisseur->id_fournisseur) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="nom_fournisseur">Nom du fournisseur</label>
                <input type="text" class="form-control" id="nom_fournisseur" name="nom_fournisseur" value="{{ old('nom_fournisseur', $fournisseur->nom_fournisseur) }}" placeholder="Nom du fournisseur" required>
            </div>
            <div class="form-group">
                <label for="contact_fournisseur">Contact du fournisseur</label>
                <input type="text" class="form-control" id="contact_fournisseur" name="contact_fournisseur" value="{{ old('contact_fournisseur', $fournisseur->contact_fournisseur) }}" placeholder="Contact du fournisseur" required>
            </div>
            <div class="form-group">
                <label for="email_fournisseur">Email du fournisseur</label>
                <input type="email" class="form-control" id="email_fournisseur" name="email_fournisseur" value="{{ old('email_fournisseur', $fournisseur->email_fournisseur) }}" placeholder="Email du fournisseur" required>
            </div>
            <div class="form-group">
                <label for="adresse_fournisseur">Adresse du fournisseur</label>
                <textarea class="form-control" id="adresse_fournisseur" name="adresse_fournisseur" rows="3" placeholder="Adresse du fournisseur" required>{{ old('adresse_fournisseur', $fournisseur->adresse_fournisseur) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>
@endsection
