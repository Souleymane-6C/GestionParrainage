@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Complétez votre Inscription</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('candidat.complement.finalize', $candidat->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" value="{{ $candidat->nom }}" disabled>
        </div>

        <div class="form-group">
            <label>Prénom</label>
            <input type="text" class="form-control" value="{{ $candidat->prenom }}" disabled>
        </div>

        <div class="form-group">
            <label>Date de Naissance</label>
            <input type="date" class="form-control" value="{{ $candidat->date_naissance }}" disabled>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nom du Parti Politique</label>
            <input type="text" name="parti_politique" class="form-control">
        </div>

        <div class="form-group">
            <label>Slogan</label>
            <input type="text" name="slogan" class="form-control">
        </div>

        <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="form-group">
            <label>Couleurs du Parti</label>
            <input type="color" name="couleur_1" class="form-control">
            <input type="color" name="couleur_2" class="form-control">
            <input type="color" name="couleur_3" class="form-control">
        </div>

        <div class="form-group">
            <label>URL Informations</label>
            <input type="url" name="url_info" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Finaliser l'Inscription</button>
    </form>
</div>
@endsection
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

