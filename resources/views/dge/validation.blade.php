@extends('layouts.app')

@section('content')
    <h1>Validation des Électeurs</h1>

    @if($electeursTemp->isEmpty())
        <p>Aucun électeur en attente de validation.</p>
    @else
        <form action="{{ route('dge.valider') }}" method="POST">
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
            <button type="submit" class="btn btn-success">Valider Tous</button>
        </form>
    @endif
@endsection
