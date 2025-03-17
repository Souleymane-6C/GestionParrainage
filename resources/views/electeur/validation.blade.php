@extends('layouts.electeur
@section('content')
<div class="container">
    <h2 class="text-center my-4">🔒 Validation du Parrainage</h2>

    <form action="{{ route('parrainage.valider') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero_carte" class="form-label">Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control" name="numero_carte" required>
        </div>

        <div class="mb-3">
            <label for="code_validation" class="form-label">Code de Validation</label>
            <input type="text" class="form-control" name="code_validation" required>
        </div>

        <button type="submit" class="btn btn-success w-100">✅ Confirmer Parrainage</button>
    </form>
</div>
@endsection
