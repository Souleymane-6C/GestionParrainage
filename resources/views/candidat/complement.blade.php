@extends('layouts.candidat')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 animated fadeInUp">Complétez votre Inscription</h2>

    @if(session('error'))
        <div class="alert alert-danger animated fadeInUp">{{ session('error') }}</div>
    @endif

    <form action="{{ route('candidat.complement.finalize', $candidat->id) }}" method="POST" enctype="multipart/form-data" class="animated fadeInUp">
        @csrf

        <div class="form-group mb-4">
            <label>Nom</label>
            <input type="text" class="form-control" value="{{ $candidat->nom }}" disabled>
        </div>

        <div class="form-group mb-4">
            <label>Prénom</label>
            <input type="text" class="form-control" value="{{ $candidat->prenom }}" disabled>
        </div>

        <div class="form-group mb-4">
            <label>Date de Naissance</label>
            <input type="date" class="form-control" value="{{ $candidat->date_naissance }}" disabled>
        </div>

        <div class="form-group mb-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label>Téléphone</label>
            <input type="text" name="telephone" class="form-control" required>
        </div>

        <div class="form-group mb-4">
            <label>Nom du Parti Politique</label>
            <input type="text" name="parti_politique" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label>Slogan</label>
            <input type="text" name="slogan" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label>Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="form-group mb-4">
            <label>Couleurs du Parti</label>
            <div class="d-flex gap-3">
                <input type="color" name="couleur_1" class="form-control" title="Couleur 1">
                <input type="color" name="couleur_2" class="form-control" title="Couleur 2">
                <input type="color" name="couleur_3" class="form-control" title="Couleur 3">
            </div>
        </div>

        <div class="form-group mb-4">
            <label>URL Informations</label>
            <input type="url" name="url_info" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mt-3 animated pulse">Finaliser l'Inscription</button>
    </form>
</div>
@endsection

@section('styles')
    <style>
        /* Body and Form Styling */
        body {
            background-color: #f4f7fc;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .container:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2.5rem;
            font-weight: 600;
            color: #495057;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Animation for button pulse */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
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

        /* Flexbox for color inputs */
        .d-flex {
            display: flex;
        }

        .gap-3 {
            gap: 15px;
        }

        /* Footer Style */
        footer {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
