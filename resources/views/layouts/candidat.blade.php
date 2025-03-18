<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Parrainages - Candidat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .content {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        .nav-buttons a,
        .nav-buttons form button {
            text-decoration: none;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            transition: 0.3s ease-in-out;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background: #e9ecef;
            border-top: 1px solid #dee2e6;
            margin-top: 20px;
            animation: fadeInUp 1s ease-out;
        }

        .alert-info {
            animation: slideIn 1s ease-out;
        }

        /* Animation pour le drapeau */
        .flag {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            animation: fadeIn 2s ease-out;
        }

        .flag img {
            width: 60px;
            height: auto;
            animation: bounce 1.5s infinite;
        }

        /* Animation: fadeIn */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Animation: slideIn */
        @keyframes slideIn {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Animation: fadeInUp */
        @keyframes fadeInUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Animation: bounce */
        @keyframes bounce {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

    </style>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Candidat - Parrainages</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if(session('candidat_id'))
                        <li class="nav-item"><a class="nav-link" href="{{ route('candidat.liste') }}"><i class="fa-solid fa-list"></i> Liste des Candidats</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('candidat.suivi') }}"><i class="fa-solid fa-chart-line"></i> Suivi Parrainage</a></li>
                        <li class="nav-item">
                            <form action="{{ route('candidat.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-sign-out-alt"></i> Déconnexion</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <!-- Message de Bienvenue -->
        @if(session('candidat_id'))
        <div class="alert alert-info mt-3 text-center">
            👋 Bienvenue, <strong>{{ session('candidat_nom') ?? 'Candidat' }}</strong> !
        </div>
        @endif

        <!-- Contenu principal -->
        <div class="content mt-4">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; {{ date('Y') }} Gestion Parrainage. Tous droits réservés.</p>
        </footer>
    </div>

    <!-- Drapeau du Sénégal -->
    <div class="flag">
        <img src="https://th.bing.com/th/id/OIP.Vv6OCOFliZsZoO5swrJuNgHaE8?pid=ImgDet&w=178&h=118&c=7&dpr=1,5" alt="Drapeau du Sénégal">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
