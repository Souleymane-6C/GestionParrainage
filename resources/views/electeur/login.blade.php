@extends('layouts.electeur')

@section('title', 'Connexion')

@section('content')
<div class="card">
    <div class="card-header">Connexion Électeur</div>
    <div class="card-body">
        <form action="{{ route('electeur.authenticate') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Code d'authentification</label>
                <input type="text" class="form-control" name="code" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</div>
@endsection
