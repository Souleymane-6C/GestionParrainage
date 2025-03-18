@extends('layouts.dge')

@section('content')
    <h1>Validation des Électeurs</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    @if($electeursErreurs->isEmpty() && $electeursTemp->isNotEmpty())
        <!-- Affichage du message lorsque les électeurs n'ont aucune erreur -->
        <div class="alert alert-success text-center">
            <strong>Il n'y a pas d'électeurs à problèmes et le fichier est validable !</strong>
        </div>

        <!-- Formulaire pour valider les électeurs -->
        <form action="{{ route('dge.validerElecteurs') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro Carte Électeur</th>
                        <th>Numéro CIN</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de Naissance</th>
                        <th>Lieu de Naissance</th>
                        <th>Sexe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($electeursTemp as $electeur)
                        <tr>
                            <td>{{ $electeur->numero_carte_electeur }}</td>
                            <td>{{ $electeur->numero_cni }}</td>
                            <td>{{ $electeur->nom_famille }}</td>
                            <td>{{ $electeur->prenom }}</td>
                            <td>{{ $electeur->date_naissance }}</td>
                            <td>{{ $electeur->lieu_naissance }}</td>
                            <td>{{ $electeur->sexe }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-check-circle"></i> Valider les Électeurs
            </button>
        </form>
    @elseif($electeursErreurs->isEmpty())
        <!-- Affichage lorsque la table electeurs_temp est vide -->
        <div class="alert alert-info text-center">
            Aucun électeur en attente de validation.
        </div>
    @else
        <!-- Affichage lorsque des erreurs existent dans la table electeurs_erreurs -->
        <div class="alert alert-danger text-center">
            <strong>Il y a des erreurs dans le fichier ! Vous devez les corriger avant de valider.</strong>
        </div>
    @endif
@endsection
