<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Espace Électeur</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('electeur.dashboard') }}">Espace Électeur</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    @auth('electeur')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('electeur.parrainage') }}">Faire un parrainage</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('electeur.logout') }}">Déconnexion</a>
                        </li>
                    @endauth
                    @guest('electeur')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('electeur.login') }}">Connexion</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
