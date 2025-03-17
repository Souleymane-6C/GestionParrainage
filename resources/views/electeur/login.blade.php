@extends('layouts.electeur')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🔑 Connexion Électeur</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('electeur.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_carte" class="form-label">Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control" name="numero_carte" required>
        </div>

        <div class="mb-3">
            <label for="code_auth" class="form-label">Code d'Authentification</label>
            <input type="text" class="form-control" name="code_auth" required>
        </div>

        <button type="submit" class="btn btn-success w-100">✅ Connexion</button>
    </form>
</div>
@endsection
