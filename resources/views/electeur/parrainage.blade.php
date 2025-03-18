@extends('layouts.parrain')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🤝 Choisir un Candidat</h2>

    <form action="{{ route('parrainage.enregistrer') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_carte" class="form-label">Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control" name="numero_carte" required>
        </div>

        <div class="mb-3">
            <label for="cni" class="form-label">Numéro de Carte d'Identité</label>
            <input type="text" class="form-control" name="cni" required>
        </div>

        <div class="mb-3">
            <label for="code_auth" class="form-label">Code d'Authentification</label>
            <input type="text" class="form-control" name="code_auth" required>
        </div>

        <div class="mb-3">
            <label for="candidat_id" class="form-label">Choisir un Candidat</label>
            <select name="candidat_id" class="form-control" required>
                @foreach($candidats as $candidat)
                    <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }} - {{ $candidat->parti_politique }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">🗳️ Valider le Parrainage</button>
    </form>
</div>
@endsection
