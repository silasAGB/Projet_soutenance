@extends('boilerplate::layout.index', [
    'title' => 'Produits',
    'breadcrumb' => ['Stocks', 'Produits']
])

@section('content')
<h1>Produits</h1>

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('boilerplate.stocks.createproduit') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Ajouter un produit
    </a>
</div>
@endsection
