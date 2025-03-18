<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Candidat')</title>
    <!-- Lien vers Bootstrap ou ton CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('candidat.home') }}">Espace Candidat</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('candidat.register.form') }}">Inscription</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('candidat.login.form') }}">Connexion</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        @yield('content')
    </main>

    <footer class="text-center py-3">
        <small>&copy; {{ date('Y') }} - Espace Candidat</small>
    </footer>
</body>
</html>
