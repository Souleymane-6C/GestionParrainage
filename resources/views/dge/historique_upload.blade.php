@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Historique des Uploads</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Adresse IP</th>
                    <th>Checksum</th>
                    <th>Électeurs à problèmes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historiqueUploads as $upload)
                    <tr>
                        <td>{{ $upload->id }}</td>
                        <td>{{ $upload->user_id }}</td>
                        <td>{{ $upload->ip_address }}</td>
                        <td>{{ $upload->checksum }}</td>
                        <td>
                            <ul>
                                @foreach($upload->electeursErreurs as $erreur)
                                    <li>{{ $erreur->numero_cin }} - {{ $erreur->probleme }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
