@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Liste des Candidats</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Parti Politique</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidats as $candidat)
            <tr>
                <td>{{ $candidat->nom }}</td>
                <td>{{ $candidat->prenom }}</td>
                <td>{{ $candidat->parti_politique }}</td>
                <td>
                <a href="{{ route('candidat.details.code', ['id' => $candidat->id]) }}" class="btn btn-info">👀 Voir Les détails</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
