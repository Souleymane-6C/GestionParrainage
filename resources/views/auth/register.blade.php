<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - DGE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 500px;
            padding: 40px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px;
            border-radius: 30px;
            font-size: 18px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            font-size: 1rem;
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            margin-top: 30px;
        }
        .flag-icon {
            width: 40px;
            height: auto;
        }
        .footer-content {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('dge.register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('user.login') }}">Déjà inscrit ? Connectez-vous</a>
        </div>
    </div>

    <footer>
        <img src="https://media.istockphoto.com/id/680713780/fr/photo/drapeau-du-s%C3%A9n%C3%A9gal.jpg?s=612x612&w=0&k=20&c=jaUoz0GYFsnK9RnNJdmQ-FXvSIvcw6Q_ewFQgS9AyIQ=" alt="Drapeau du Sénégal" class="flag-icon">
        <p class="mt-2">La Gestion des Parrainages au Sénégal - <strong>Un Peuple, Un But, Une Foi</strong></p>
        <p>&copy; <span id="current-year"></span> DGE - Parrainages</p>
    </footer>

    <script>
        document.getElementById("current-year").innerText = new Date().getFullYear();
    </script>
</body>
</html>
