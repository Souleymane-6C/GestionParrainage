@extends('layouts.app')

@section('content')
    <h1>Ajouter un candidat</h1>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('dge.ajout_candidat') }}" method="POST">
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
            <label for="numero_carte">Numéro de carte d'électeur :</label>
            <input type="text" name="numero_carte" id="numero_carte" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance :</label>
            <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter le candidat</button>
    </form>

    <hr>

    <!-- Liste des candidats ajoutés -->
    <h2>Liste des candidats</h2>
    @if($candidats->isEmpty())
        <p>Aucun candidat enregistré.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Numéro de carte</th>
                    <th>Date de naissance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($candidats as $candidat)
                    <tr>
                        <td>{{ $candidat->nom }}</td>
                        <td>{{ $candidat->prenom }}</td>
                        <td>{{ $candidat->numero_carte }}</td>
                        <td>{{ $candidat->date_naissance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
