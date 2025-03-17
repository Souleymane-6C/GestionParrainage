@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🔑 Vérification du Code pour {{ $candidat->nom }} {{ $candidat->prenom }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('candidat.details.verify', ['id' => $candidat->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="newcode" class="form-label">Entrez le code reçu :</label>
            <input type="text" class="form-control" id="newcode" name="newcode" required>
        </div>
        <button type="submit" class="btn btn-primary">Vérifier</button>
    </form>

    <!-- Bouton pour générer un nouveau code -->
    <form action="{{ route('candidat.generer_code', ['id' => $candidat->id]) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-warning">🔄 Générer un Nouveau Code</button>
    </form>
</div>
@endsection
