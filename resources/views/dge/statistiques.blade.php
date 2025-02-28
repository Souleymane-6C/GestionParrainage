@extends('layouts.app')

@section('content')
    <h1>Statistiques des Parrainages</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Candidat</th>
                <th>Nombre de Parrainages</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dynamically list candidats and their parrainages -->
            @foreach($parrainages as $parrainage)
                <tr>
                    <td>{{ $parrainage->candidat->nom }} {{ $parrainage->candidat->prenom }}</td>
                    <td>{{ $parrainage->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
