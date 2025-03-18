@extends('layouts.candidat')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4 animated fadeInUp">Inscription Candidat</h2>

    @if(session('error'))
        <div class="alert alert-danger animated fadeInUp">{{ session('error') }}</div>
    @endif

    <form action="{{ route('candidat.inscription.verify') }}" method="POST" class="animated fadeInUp">
        @csrf
        <div class="form-group mb-4">
            <label for="numero_carte" class="form-label">Numéro de Carte d'Électeur</label>
            <input type="text" name="numero_carte" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mt-3 animated pulse">Vérifier</button>
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

        /* Alert Style */
        .alert {
            font-size: 1.1rem;
        }
    </style>
@endsection
