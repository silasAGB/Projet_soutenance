@extends('boilerplate::layout.index', [
    'title' => 'Gestion Commandes',
    'breadcrumb' => ['Commandes', 'Gestion']
])

@section('content')
<h1>Gestion des commandes</h1>
<x-boilerplate::datatable name="commandes" />
@endsection
