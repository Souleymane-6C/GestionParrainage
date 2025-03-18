@extends('layouts.dge')

@section('content')
    <h1>Historique des Uploads</h1>

    @if($historiqueUploads->isEmpty())
        <p>Aucun fichier importé.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du Fichier</th>
                    <th>Adresse IP</th>
                    <th>Date d'Upload</th>
                    <th>Checksum</th>
                    <th>Statut</th>
                    <th>Électeurs à problèmes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historiqueUploads as $upload)
                    <tr>
                        <td>{{ $upload->id }}</td>
                        <td>{{ $upload->nom_fichier ?? 'Inconnu' }}</td>
                        <td>{{ $upload->ip_address ?? 'Non disponible' }}</td>
                        <td>{{ $upload->created_at ?? 'Non disponible' }}</td>
                        <td>{{ $upload->checksum ?? 'Non disponible' }}</td>
                        <td>{{ $upload->statut ?? 'En attente' }}</td>
                        <td>
                            <ul>
                                @foreach ($upload->electeursErreurs as $erreur)
                                    <li>{{ $erreur->numero_cin }} - {{ $erreur->nature_erreur }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
