@extends('layouts.app')

@section('content')
    

    <table class="table">
    <h1>Statistiques des Parrainages</h1>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de Carte</th>
                <th>Date de Naissance</th>
                <th>Nombre de Parrainages</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidats as $candidat)
                <tr>
                    <td>{{ $candidat->nom }}</td>
                    <td>{{ $candidat->prenom }}</td>
                    <td>{{ $candidat->numero_carte }}</td>
                    <td>{{ $candidat->date_naissance }}</td>
                    <td>{{ $candidat->parrainages_count ?? 0 }}</td> <!-- Nombre de parrainages, 0 par défaut -->
                </tr>
            @endforeach
     
