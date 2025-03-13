@extends('layouts.app')

@section('content')

    <h1>Liste des Électeurs en Erreur</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($electeursErreurs->isEmpty())
        <div class="alert alert-success">
            Aucun électeur en erreur. Le fichier est prêt à être validé.
            <form action="{{ route('dge.validerElecteurs') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Valider les Électeurs</button>
            </form>
        </div>
    @else
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Numéro Carte Électeur</th>
                    <th>Numéro CIN</th>
                    <th>Nom</th>
                    <th>Bureau de Vote</th>
                    <th>Nature de l'Erreur</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($electeursErreurs as $electeur)
                    <tr>
                        <td>{{ $electeur->numero_carte_electeur ?? 'N/A' }}</td>
                        <td>{{ $electeur->numero_cni ?? 'N/A' }}</td>
                        <td>{{ $electeur->nom_famille ?? 'N/A' }}</td>
                        <td>{{ $electeur->bureau_vote ?? 'N/A' }}</td>
                        <td>{{ $electeur->nature_erreur }}</td>
                        <td>{{ $electeur->description_erreur }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
