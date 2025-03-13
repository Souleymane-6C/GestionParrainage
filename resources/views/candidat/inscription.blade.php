@extends('layouts.candidat')

@section('title', 'Inscription Candidat')

@section('content')
    <h2>Inscription d’un candidat</h2>

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('candidat.inscription') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Numéro de carte d’électeur :</label>
        <input type="text" name="numero_carte" required>

        <button type="submit">Vérifier</button>
    </form>

    @if (session('candidat'))
        <form action="{{ route('candidat.inscription.finaliser') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="numero_carte" value="{{ session('candidat')['numero_carte'] }}">

            <p>Nom : {{ session('candidat')['nom'] }}</p>
            <p>Prénom : {{ session('candidat')['prenom'] }}</p>
            <p>Date de naissance : {{ session('candidat')['date_naissance'] }}</p>

            <label>Email :</label>
            <input type="email" name="email" required>

            <label>Téléphone :</label>
            <input type="text" name="telephone" required>

            <label>Nom du parti politique :</label>
            <input type="text" name="parti_politique">

            <label>Slogan :</label>
            <input type="text" name="slogan">

            <label>Photo :</label>
            <input type="file" name="photo">

            <label>Couleur principale du parti :</label>
            <input type="color" name="couleur_1" id="color1" value="#ff0000" onchange="updateColorPreview('color1', 'previewColor1')">
            <div id="previewColor1" style="width: 50px; height: 50px; background-color: #ff0000; border-radius: 5px; margin-top: 5px;"></div>

            <label>Couleur secondaire du parti :</label>
            <input type="color" name="couleur_2" id="color2" value="#00ff00" onchange="updateColorPreview('color2', 'previewColor2')">
            <div id="previewColor2" style="width: 50px; height: 50px; background-color: #00ff00; border-radius: 5px; margin-top: 5px;"></div>

            <label>Couleur tertiaire du parti :</label>
            <input type="color" name="couleur_3" id="color3" value="#0000ff" onchange="updateColorPreview('color3', 'previewColor3')">
            <div id="previewColor3" style="width: 50px; height: 50px; background-color: #0000ff; border-radius: 5px; margin-top: 5px;"></div>

            <label>Page d’informations :</label>
            <input type="url" name="url_page">

            <button type="submit">Enregistrer</button>
        </form>
    @endif

    <script>
        function updateColorPreview(inputId, previewId) {
            const color = document.getElementById(inputId).value;
            document.getElementById(previewId).style.backgroundColor = color;
        }
    </script>
@endsection
