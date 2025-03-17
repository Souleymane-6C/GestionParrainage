@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Vérification du Code</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Bouton pour générer un nouveau code -->
    <form action="{{ route('candidat.generer_code', $candidat->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Générer Nouveau Code</button>
    </form>

    <!-- Formulaire pour saisir le code reçu -->
    <form action="{{ route('candidat.valider_code', $candidat->id) }}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label>Entrez le Code Reçu</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Valider</button>
    </form>
</div>
@endsection
