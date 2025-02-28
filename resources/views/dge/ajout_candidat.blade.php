<!-- resources/views/dge/ajout-candidat.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Ajouter un candidat</h1>

    <form action="{{ route('dge.candidat.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="numero_cin">Numéro de carte d'électeur :</label>
            <input type="text" name="numero_cin" id="numero_cin" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter le candidat</button>
    </form>
@endsection
