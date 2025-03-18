@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2 class="text-center">🔐 Connexion Candidat</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('candidat.authenticate') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">📧 Adresse Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">🔑 Code de Sécurité</label>
            <input type="text" class="form-control" name="code" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Se Connecter</button>
    </form>
</div>
@endsection
