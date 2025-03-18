@extends('layouts.dge')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 text-center">
                @auth
                    <h1 class="mb-4">Bienvenue sur le système DGE - Parrainages</h1>
                    <p>Vous êtes connecté. Accédez à votre tableau de bord.</p>
                    <a href="{{ route('dge.dashboard') }}" class="btn btn-info">Accéder au Dashboard</a>
                @endauth

                @guest
                    <h1 class="mb-4">Bienvenue sur le système DGE - Parrainages</h1>
                    <p>Veuillez vous connecter ou vous inscrire pour accéder à la plateforme.</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('dge.register.form') }}" class="btn btn-primary me-3">
                            S'inscrire
                        </a>
                        <a href="{{ route('user.login.form') }}" class="btn btn-success">
                            Se connecter
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
@endsection
