@extends('boilerplate::layout.index', [
    'title' => 'Créer Production',
    'breadcrumb' => ['Créer Production']
])

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ajouter une production</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form role="form" action="{{ route('boilerplate.productions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date_prevue">Date prévue</label>
                        <input type="date" class="form-control" id="date_prevue" name="date_prevue" required>
                    </div>
                    <div class="form-group">
                        <label for="qte_prevue">Quantité prévue</label>
                        <input type="number" class="form-control" id="qte_prevue" name="qte_prevue" required>
                    </div>
                    <div class="form-group">
                        <label for="id_Produit">Produit</label>
                        <select class="form-control" id="id_Produit" name="id_Produit" required>
                            <option value="" disabled selected>Choisissez un produit</option>
                            @foreach($produits as $produit)
                                <option value="{{ $produit->id_Produit }}">{{ $produit->nom_produit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('boilerplate.productions.gerer') }}" class="btn btn-default" data-toggle="tooltip" title="Retour à la liste des productions">
                            <span class="far fa-arrow-alt-circle-left text-muted"></span>
                        </a>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection
