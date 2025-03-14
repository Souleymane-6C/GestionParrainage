@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4 text-primary">
            <i class="fa-solid fa-user-plus"></i> Ajouter un candidat
        </h1>

        <!-- Messages de succès et d'erreur -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Formulaire d'ajout de candidat -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('dge.ajout_candidat') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label"><i class="fa-solid fa-user"></i> Nom :</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom du candidat" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label"><i class="fa-solid fa-user"></i> Prénom :</label>
                        <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Entrez le prénom du candidat" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_carte" class="form-label"><i class="fa-solid fa-id-card"></i> Numéro de carte d'électeur :</label>
                        <input type="text" name="numero_carte" id="numero_carte" class="form-control" placeholder="Numéro de carte" required>
                    </div>

                    <div class="mb-3">
                        <label for="date_naissance" class="form-label"><i class="fa-solid fa-calendar"></i> Date de naissance :</label>
                        <input type="date" name="date_naissance" id="date_naissance" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-user-plus"></i> Ajouter le candidat
                    </button>
                </form>
            </div>
        </div>

        <!-- Liste des candidats -->
        <h2 class="text-center text-secondary"><i class="fa-solid fa-list"></i> Liste des candidats</h2>

        @if($candidats->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-info-circle"></i> Aucun candidat enregistré.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover shadow-sm">
                    <thead class="table-dark">
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
                                <td>{{ \Carbon\Carbon::parse($candidat->date_naissance)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
