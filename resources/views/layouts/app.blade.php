<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Parrainages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
        /* Ajouter des styles personnalisés si nécessaire */
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
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('dge.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dge.import') }}">Importer Fichier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dge.gestion_periode') }}">Gestion Période</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dge.ajout_candidat') }}">Ajouter Candidat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dge.statistiques') }}">Statistiques</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('dge.electeurs_erreurs') }}">Électeurs à Problèmes</a>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('dge.historique_upload') }}">Historique des Uploads</a></li>
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
