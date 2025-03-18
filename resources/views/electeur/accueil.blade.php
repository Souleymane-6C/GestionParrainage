<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Électeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5; /* Couleur de fond neutre */
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex-grow: 1;
        }

        h1 {
            font-size: 2.5rem;
            color: #343a40; /* Gris foncé */
            font-weight: 600;
        }

        .btn {
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 15px;
            transition: transform 0.2s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #6c757d; /* Gris moyen */
            border-color: #6c757d;
        }

        .btn-primary:hover {
            background-color: #5a6268; /* Gris foncé */
            border-color: #545b62;
        }

        .btn-success {
            background-color: #28a745; /* Vert */
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838; /* Vert foncé */
            border-color: #1e7e34;
        }

        .row {
            margin-top: 40px;
        }

        /* Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeIn {
            animation: fadeIn 1s ease-out;
        }

        /* Footer */
        footer {
            background-color: #343a40; /* Gris foncé */
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .flag-icon {
            width: 40px;
            height: auto;
        }

        .footer-content {
            margin-top: 10px;
        }

        .footer-content p {
            font-size: 1.1rem;
        }

        .footer-content img {
            width: 60px;
            margin-top: 10px;
        }

    </style>
</head>
<body>

    <!-- Header: Bienvenue -->
    <header class="bg-secondary text-white text-center py-4">
        <h2>Bienvenue sur l'Espace Électeur</h2>
        <p>Veuillez vous inscrire ou vous connecter pour accéder à vos fonctionnalités.</p>
    </header>

    <div class="container fadeIn">
        <h1 class="my-4">💳 Espace Électeur</h1>

        <!-- Message de bienvenue ou information -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-4">
                <a href="{{ route('electeur.inscription') }}" class="btn btn-primary btn-lg mb-3 w-100">📝 Inscription</a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('electeur.login') }}" class="btn btn-success btn-lg mb-3 w-100">🔑 Connexion</a>
            </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Affichage de l'année courante dans le footer
        document.getElementById("current-year").innerText = new Date().getFullYear();
    </script>
</body>
</html>
