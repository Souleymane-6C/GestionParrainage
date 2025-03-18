<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DGE - Parrainages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .text-center h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #495057;
            animation: fadeInUp 1s ease-out forwards;
        }

        .text-center p {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 30px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .footer {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer img {
            width: 40px;
            height: auto;
            margin-bottom: 10px;
        }

        .footer p {
            font-size: 1rem;
            margin: 5px 0;
        }

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

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .btn {
                font-size: 16px;
            }

            .text-center h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                @auth
                    <h1 class="mb-4 animated fadeInUp">Bienvenue sur le système DGE - Parrainages</h1>
                    <p>Vous êtes connecté. Accédez à votre tableau de bord.</p>
                    <a href="{{ route('dge.dashboard') }}" class="btn btn-info">Accéder au Dashboard</a>
                @endauth

                @guest
                    <h1 class="mb-4 animated fadeInUp">Bienvenue sur le système DGE - Parrainages</h1>
                    <p>Veuillez vous connecter ou vous inscrire pour accéder à la plateforme.</p>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('dge.register.form') }}" class="btn btn-primary me-3">S'inscrire</a>
                        <a href="{{ route('user.login.form') }}" class="btn btn-success">Se connecter</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>

    <footer class="footer">
        <img src="https://media.istockphoto.com/id/680713780/fr/photo/drapeau-du-s%C3%A9n%C3%A9gal.jpg?s=612x612&w=0&k=20&c=jaUoz0GYFsnK9RnNJdmQ-FXvSIvcw6Q_ewFQgS9AyIQ="
            alt="Drapeau du Sénégal" class="flag-icon">
        <p>La Gestion des Parrainages au Sénégal - <strong>Un Peuple, Un But, Une Foi</strong></p>
        <p>&copy; <span id="current-year"></span> DGE - Parrainages</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Affichage de l'année courante dans le footer
        document.getElementById("current-year").innerText = new Date().getFullYear();
    </script>
</body>

</html>

