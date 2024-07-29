@extends('boilerplate::layout.index', [
    'title' => 'Gerer Production',
    'breadcrumb' => ['Productions', 'Gerer']
])

@section('content')
<h1>Gestion des Productions</h1>
<div class="row">
    <div class="col-12 mbl">
        <span class="float-right pb-3">
            <a href="{{ route("boilerplate.productions.create") }}" class="btn btn-primary">
                @lang('Programmer une production')
            </a>
        </span>
    </div>
</div>
<x-boilerplate::datatable name="productions" />
@endsection
