@extends('layouts.app')

@section('content')
    <h1>Électeurs à problèmes</h1>

    @if($electeursErreurs->isEmpty())
        <p>Aucune erreur détectée.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Numéro Carte Électeur</th>
                    <th>Numéro CIN</th>
                    <th>Nom</th>
                    <th>Bureau de Vote</th>
                    <th>Nature de l'erreur</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($electeursErreurs as $erreur)
                    <tr>
                        <td>{{ $erreur->numero_carte_electeur ?? 'Non renseigné' }}</td>
                        <td>{{ $erreur->numero_cin ?? 'Non renseigné' }}</td>
                        <td>{{ $erreur->nom_famille ?? 'Non renseigné' }}</td>
                        <td>{{ $erreur->bureau_vote ?? 'Non renseigné' }}</td>
                        <td>{{ $erreur->nature_erreur }}</td>
                        <td>{{ $erreur->description_erreur }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
