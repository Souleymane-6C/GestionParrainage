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
        }
        .navbar-brand {
            font-weight: bold;
        }
        .content {
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Navigation -->
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
            </div>
        </nav>

        <!-- Contenu principal -->
        <div class="content mt-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
