@extends('layouts.candidat')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 animated fadeInUp">Détails du Candidat</h2>

    <div class="animated fadeInUp">
        <p><strong>Nom :</strong> {{ $candidat->nom }}</p>
        <p><strong>Prénom :</strong> {{ $candidat->prenom }}</p>
        <p><strong>Email :</strong> {{ $candidat->email }}</p>
        <p><strong>Parti Politique :</strong> {{ $candidat->parti_politique }}</p>
        <p><strong>Slogan :</strong> {{ $candidat->slogan }}</p>

        <!-- Photo du candidat -->
        @if($candidat->photo)
        <p><strong>Photo :</strong></p>
        <img src="{{ asset('storage/'.$candidat->photo) }}" alt="Photo de {{ $candidat->nom }}" class="img-fluid rounded-circle shadow mb-3" style="max-width: 200px; height: auto;">
        @else
        <p><strong>Pas de photo disponible.</strong></p>
        @endif

        <!-- Couleurs du parti -->
        <p><strong>Couleurs du Parti :</strong></p>
        <div class="d-flex gap-3 mb-4">
            <div style="background-color: {{ $candidat->couleur_1 }}; width: 50px; height: 50px;" class="rounded-circle shadow"></div>
            <div style="background-color: {{ $candidat->couleur_2 }}; width: 50px; height: 50px;" class="rounded-circle shadow"></div>
            <div style="background-color: {{ $candidat->couleur_3 }}; width: 50px; height: 50px;" class="rounded-circle shadow"></div>
        </div>

        <!-- URL Informations -->
        @if($candidat->url_info)
        <p><strong>Informations supplémentaires :</strong> <a href="{{ $candidat->url_info }}" target="_blank" class="btn btn-link text-primary">{{ $candidat->url_info }}</a></p>
        @else
        <p><strong>Aucune URL d'informations disponible.</strong></p>
        @endif

        <p><strong>Date de Naissance :</strong> {{ $candidat->date_naissance }}</p>
        <p><strong>Téléphone :</strong> {{ $candidat->telephone }}</p>
    </div>
</div>
@endsection

@section('styles')
    <style>
        /* Body and Card Styling */
        body {
            background-color: #f4f7fc;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #495057;
        }

        .btn-link {
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        /* Inputs and Buttons */
        .form-control, .btn {
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ced4da;
        }

        /* Card Images */
        .img-fluid {
            max-width: 200px;
            height: auto;
        }

        .rounded-circle {
            border-radius: 50%;
        }

        /* Animations */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeInUp {
            animation: fadeInUp 1s ease-out forwards;
        }

        /* Flexbox for colors */
        .d-flex {
            display: flex;
        }

        .gap-3 {
            gap: 10px;
        }

        .shadow {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .mb-3, .mb-4 {
            margin-bottom: 20px;
        }
    </style>
@endsection
