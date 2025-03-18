@extends('layouts.parrain') 

@section('content')
<div class="container">
    <h2 class="text-center my-4">📝 Inscription Électeur</h2>

    <!-- Affichage des messages d'erreur généraux -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Formulaire de vérification des informations d'authentification -->
    <form action="{{ route('electeur.inscription.verifier') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_carte_electeur" class="form-label">📄 Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control @error('numero_carte_electeur') is-invalid @enderror" name="numero_carte_electeur" value="{{ old('numero_carte_electeur') }}" required>
            @error('numero_carte_electeur')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="numero_cni" class="form-label">🆔 Numéro de Carte Nationale d’Identité</label>
            <input type="text" class="form-control @error('numero_cni') is-invalid @enderror" name="numero_cni" value="{{ old('numero_cni') }}" required>
            @error('numero_cni')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nom_famille" class="form-label">👤 Nom de Famille</label>
            <input type="text" class="form-control @error('nom_famille') is-invalid @enderror" name="nom_famille" value="{{ old('nom_famille') }}" required>
            @error('nom_famille')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="bureau_vote" class="form-label">🗳️ Bureau de Vote</label>
            <input type="text" class="form-control @error('bureau_vote') is-invalid @enderror" name="bureau_vote" value="{{ old('bureau_vote') }}" required>
            @error('bureau_vote')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-info w-100">🔍 Vérifier</button>
    </form>

    @if(session('verifier')) 
        <!-- Formulaire d'inscription après vérification réussie -->
        <form action="{{ route('electeur.inscription') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <input type="hidden" name="numero_carte_electeur" value="{{ session('numero_carte_electeur') }}">
            <input type="hidden" name="numero_cni" value="{{ session('numero_cni') }}">
            <input type="hidden" name="nom_famille" value="{{ session('nom_famille') }}">
            <input type="hidden" name="bureau_vote" value="{{ session('bureau_vote') }}">

            <div class="mb-3">
                <label for="email" class="form-label">📧 Adresse Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">📞 Numéro de Téléphone</label>
                <input type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required>
                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">📩 Recevoir Code d'Authentification</button>
        </form>
    @endif
</div>
@endsection
