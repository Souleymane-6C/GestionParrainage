@extends('layouts.electeur')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🏠 Tableau de Bord</h2>

    <div class="row">
        <div class="col-md-6 text-center">
            <a href="{{ route('parrainage.choisir') }}" class="btn btn-primary btn-lg mb-3 w-100">🤝 Parrainer un Candidat</a>
        </div>
        <div class="col-md-6 text-center">
            <a href="{{ route('parrainage.valider') }}" class="btn btn-success btn-lg mb-3 w-100">🔒 Valider Parrainage</a>
        </div>
    </div>
</div>
@endsection
