@extends('layouts.electeur')

@section('title', 'Inscription')

@section('content')
<div class="card">
    <div class="card-header">Inscription Électeur</div>
    <div class="card-body">
        <form action="{{ route('electeur.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="numero_carte" class="form-label">Numéro de carte d'électeur</label>
                <input type="text" class="form-control" name="numero_carte" required>
            </div>
            <div class="mb-3">
                <label for="numero_cni" class="form-label">Numéro de CNI</label>
                <input type="text" class="form-control" name="numero_cni" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de famille</label>
                <input type="text" class="form-control" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="bureau_vote" class="form-label">Numéro du bureau de vote</label>
                <input type="text" class="form-control" name="bureau_vote" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" name="telephone" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</div>
@endsection
