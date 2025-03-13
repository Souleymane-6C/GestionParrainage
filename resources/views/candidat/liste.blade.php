@extends('layouts.candidat')

@section('title', 'Liste des candidats')

@section('content')
    <h2>Liste des candidats enregistrés</h2>

    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Parti</th>
            <th>Slogan</th>
            <th>Actions</th>
        </tr>

        @foreach ($candidats as $candidat)
            <tr>
                <td>{{ $candidat->nom }}</td>
                <td>{{ $candidat->parti_politique }}</td>
                <td>{{ $candidat->slogan }}</td>
                <td>
                    <a href="{{ route('candidat.details', $candidat->id) }}">Voir détails</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
