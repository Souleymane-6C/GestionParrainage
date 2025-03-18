<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Parrainages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .content {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        /* Animation for hover effects */
        .content:hover {
            transform: translateY(-5px);
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            margin-top: auto;
        }

        .flag-icon {
            width: 40px;
            height: auto;
        }

        .footer-content {
            margin-top: 10px;
        }

        /* Responsive styles for small screens */
        @media (max-width: 768px) {
            .flag-icon {
                width: 30px;
            }
        }

        /* Ensuring the footer stays at the bottom */
        .main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <div class="container main-wrapper">
        @auth
        <!-- Navigation visible uniquement pour les utilisateurs connectés -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">DGE - Parrainages</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.import') }}"><i class="fa-solid fa-upload"></i> Importer Fichier</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.gestion_periode') }}"><i class="fa-solid fa-calendar"></i> Gestion Période</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.ajout_candidat') }}"><i class="fa-solid fa-user-plus"></i> Ajouter Candidat</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.statistiques') }}"><i class="fa-solid fa-chart-pie"></i> Statistiques</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.electeurs_erreurs') }}"><i class="fa-solid fa-triangle-exclamation"></i> Électeurs à Problèmes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('dge.historique_upload') }}"><i class="fa-solid fa-clock-rotate-left"></i> Historique Uploads</a></li>
                </ul>

                <!-- Ajout du bouton pour valider les électeurs -->
                <form action="{{ route('dge.validerElecteurs') }}" method="POST" class="d-flex ms-3">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check-circle"></i> Valider les Électeurs
                    </button>
                </form>

                <!-- Bouton de déconnexion -->
                <form action="{{ route('user.logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>
        @endauth

        <!-- Contenu principal -->
        <div class="content mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <img src="https://media.istockphoto.com/id/680713780/fr/photo/drapeau-du-s%C3%A9n%C3%A9gal.jpg?s=612x612&w=0&k=20&c=jaUoz0GYFsnK9RnNJdmQ-FXvSIvcw6Q_ewFQgS9AyIQ=" alt="Drapeau du Sénégal" class="flag-icon">
            <p class="mt-2">La Gestion des Parrainages au Sénégal - <strong>Un Peuple, Un But, Une Foi</strong></p>
            <p>&copy; <span id="current-year"></span> DGE - Parrainages</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Affichage de l'année courante dans le footer
        document.getElementById("current-year").innerText = new Date().getFullYear();
    </script>
</body>

</html>
