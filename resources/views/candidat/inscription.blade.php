
@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Inscription Candidat</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('candidat.inscription.verify') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="numero_carte">Numéro de Carte d'Électeur</label>
            <input type="text" name="numero_carte" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Vérifier</button>
    </form>
</div>
@endsection
