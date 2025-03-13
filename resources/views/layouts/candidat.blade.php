<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Espace Candidat')</title>

    <style>
        /* Style de base */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f7fc;
            color: #333;
        }

        h1, h2 {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        header {
            background-color: #0056b3;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        header:hover {
            background-color: #00429d;
        }

        nav ul {
            display: flex;
            justify-content: center;
            gap: 30px;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffb600;
            transform: translateY(-5px);
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 1s ease-out;
        }

        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 15px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        /* Animation de fade-in pour l'apparition de la page */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Style pour les formulaires */
        form {
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
            animation: slideIn 0.5s ease-out;
        }

        form input, form button {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        form input:focus, form button:focus {
            border-color: #0056b3;
            outline: none;
        }

        form button {
            background-color: #0056b3;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        form button:hover {
            background-color: #00429d;
            transform: translateY(-2px);
        }

        /* Animation d'apparition pour le formulaire */
        @keyframes slideIn {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Style des messages d'erreur */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            animation: fadeInError 1s ease-out;
        }

        @keyframes fadeInError {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        /* Animation de bouton hover */
        button[type="submit"]:hover {
            background-color: #ffb600;
            color: white;
            transform: translateY(-5px);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 15px;
            }

            header {
                text-align: center;
            }

            .main-content {
                padding: 15px;
            }

            footer {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Espace Candidat</h1>
        <nav>
            <ul>
                <li><a href="{{ route('candidat.accueil') }}">Accueil</a></li>
                <!--<li><a href="{{ route('candidat.inscription.form') }}">Inscription</a></li>-->
                <li><a href="{{ route('candidat.liste') }}">Liste des candidats</a></li>
                <li><a href="{{ route('candidat.suivi') }}">Suivi des parrainages</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2025 - Gestion des Parrainages</p>
    </footer>

</body>
</html>
