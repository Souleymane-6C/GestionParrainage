@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Détails du Candidat</h2>

    <p><strong>Nom :</strong> {{ $candidat->nom }}</p>
    <p><strong>Prénom :</strong> {{ $candidat->prenom }}</p>
    <p><strong>Email :</strong> {{ $candidat->email }}</p>
    <p><strong>Parti Politique :</strong> {{ $candidat->parti_politique }}</p>
    <p><strong>Slogan :</strong> {{ $candidat->slogan }}</p>

    <!-- Photo du candidat -->
    @if($candidat->photo)
    <p><strong>Photo :</strong></p>
    <img src="{{ asset('storage/'.$candidat->photo) }}" alt="Photo de {{ $candidat->nom }}" style="max-width: 200px; height: auto;">
@else
    <p><strong>Pas de photo disponible.</strong></p>
@endif


    <!-- Couleurs du parti -->
    <p><strong>Couleurs du Parti :</strong></p>
    <div style="display: flex;">
        <div style="background-color: {{ $candidat->couleur_1 }}; width: 50px; height: 50px;"></div>
        <div style="background-color: {{ $candidat->couleur_2 }}; width: 50px; height: 50px;"></div>
        <div style="background-color: {{ $candidat->couleur_3 }}; width: 50px; height: 50px;"></div>
    </div>

    <!-- URL Informations -->
    @if($candidat->url_info)
        <p><strong>Informations supplémentaires :</strong> <a href="{{ $candidat->url_info }}" target="_blank">{{ $candidat->url_info }}</a></p>
    @else
        <p><strong>Aucune URL d'informations disponible.</strong></p>
    @endif

    <p><strong>Date de Naissance :</strong> {{ $candidat->date_naissance }}</p>
    <p><strong>Téléphone :</strong> {{ $candidat->telephone }}</p>
</div>
@endsection
