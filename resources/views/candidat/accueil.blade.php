@extends('layouts.candidat')

@section('content')
<div class="container text-center">
    <!-- Titre avec animation -->
    <h1 class="display-4 animated fadeInUp">Bienvenue sur la plateforme de Parrainage</h1>

    <!-- Message d'introduction avec animation -->
    <p class="lead animated fadeInUp">Connectez-vous ou inscrivez-vous pour gérer votre candidature.</p>

    <!-- Boutons avec animation de zoom -->
    <div class="d-flex justify-content-center gap-4">
        <a href="{{ route('candidat.login') }}" class="btn btn-primary btn-lg animated bounceInLeft">Se connecter</a>
        <a href="{{ route('candidat.inscription.form') }}" class="btn btn-success btn-lg animated bounceInRight">S'inscrire</a>
    </div>
</div>

@endsection

@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        /* Fade-in Up Animation */
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
            animation-name: fadeInUp;
        }

        /* Bounce-In Left and Right Animations */
        @keyframes bounceInLeft {
            0% {
                transform: translateX(-1000px);
                opacity: 0;
            }
            60% {
                transform: translateX(30px);
                opacity: 1;
            }
            80% {
                transform: translateX(-10px);
            }
            100% {
                transform: translateX(0);
            }
        }

        @keyframes bounceInRight {
            0% {
                transform: translateX(1000px);
                opacity: 0;
            }
            60% {
                transform: translateX(-30px);
                opacity: 1;
            }
            80% {
                transform: translateX(10px);
            }
            100% {
                transform: translateX(0);
            }
        }

        .bounceInLeft {
            animation-name: bounceInLeft;
        }

        .bounceInRight {
            animation-name: bounceInRight;
        }

        /* Style personnalisé pour les boutons */
        .btn {
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 25px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
@endsection
