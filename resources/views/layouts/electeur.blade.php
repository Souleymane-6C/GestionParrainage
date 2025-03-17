<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestion Parrainage - Électeur')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: white;
        }
        .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- 🟦 Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('electeur.dashboard') }}">📋 Gestion Parrainage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(session()->has('electeur_id'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('electeur.dashboard') }}">🏠 Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('electeur.logout') }}"method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">🚪 Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('electeur.login') }}">🔑 Connexion</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- 🏗 Contenu des pages -->
    <div class="container">
        @yield('content')
    </div>

    <!-- 🔽 Footer -->
    <footer>
        &copy; {{ date('Y') }} Gestion Parrainage - Tous droits réservés.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>