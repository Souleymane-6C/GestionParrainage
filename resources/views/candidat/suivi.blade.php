@extends('layouts.candidat')

@section('title', 'Suivi des Parrainages')

@section('content')
    <h2>Suivi des parrainages</h2>

    <p>Vous avez actuellement <strong>{{ $nombreParrainages }}</strong> parrainages validés.</p>

    <h3>Évolution des parrainages</h3>
    <table border="1">
        <tr>
            <th>Date</th>
            <th>Nombre de parrainages</th>
        </tr>
        @foreach ($historiqueParrainages as $date => $nombre)
            <tr>
                <td>{{ $date }}</td>
                <td>{{ $nombre }}</td>
            </tr>
        @endforeach
    </table>
@endsection
