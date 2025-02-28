@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Électeurs avec erreurs</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numéro CIN</th>
                    <th>Numéro Électeur</th>
                    <th>Problème</th>
                    <th>Tentative Upload</th>
                </tr>
            </thead>
            <tbody>
                @foreach($electeursErreurs as $erreur)
                    <tr>
                        <td>{{ $erreur->id }}</td>
                        <td>{{ $erreur->numero_cin }}</td>
                        <td>{{ $erreur->numero_electeur }}</td>
                        <td>{{ $erreur->probleme }}</td>
                        <td>
                            <a href="{{ route('dge.historique_upload', ['id' => $erreur->tentative_upload_id]) }}">
                                Voir l'historique
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
