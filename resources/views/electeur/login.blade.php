@extends('layouts.parrain')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🔑 Connexion Électeur</h2>

    <!-- Affichage des messages d'erreur et de succès -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulaire de connexion -->
    <form action="{{ route('electeur.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_carte_electeur" class="form-label">📄 Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control @error('numero_carte_electeur') is-invalid @enderror" name="numero_carte_electeur" value="{{ old('numero_carte_electeur') }}" required>
            @error('numero_carte_electeur')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="code_authentification" class="form-label">🆔 Code d'Authentification</label>
            <input type="text" class="form-control @error('code_authentification') is-invalid @enderror" name="code_authentification" value="{{ old('code_authentification') }}" required>
            @error('code_authentification')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">🔑 Se connecter</button>
    </form>
</div>
@endsection
