@extends('layouts.candidat')

@section('title', 'Détails du candidat')

@section('content')
    <h2>Détails du candidat</h2>

    <p><strong>Nom :</strong> {{ $candidat->nom }}</p>
    <p><strong>Parti :</strong> {{ $candidat->parti_politique }}</p>
    <p><strong>Slogan :</strong> {{ $candidat->slogan }}</p>
    <p><strong>Email :</strong> {{ $candidat->email }}</p>
    <p><strong>Téléphone :</strong> {{ $candidat->telephone }}</p>
    
    <!-- <a href="{{ route('candidat.renvoyerCode', $candidat->id) }}">Générer un nouveau code</a> -->
@endsection
