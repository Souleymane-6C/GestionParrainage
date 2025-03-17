@extends('layouts.electeur')

@section('content')
<div class="container">
    <h2 class="text-center my-4">📝 Inscription Électeur</h2>

    <!-- Affichage des messages d'erreur et de succès -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Étape 1 : Formulaire de vérification des informations d'authentification -->
    <form id="verification-form">
        @csrf
        <div class="mb-3">
            <label for="numero_carte" class="form-label">📄 Numéro de Carte d'Électeur</label>
            <input type="text" class="form-control" name="numero_carte" required>
        </div>

        <div class="mb-3">
            <label for="numero_cni" class="form-label">🆔 Numéro de Carte Nationale d’Identité</label>
            <input type="text" class="form-control" name="numero_cni" required>
        </div>

        <div class="mb-3">
            <label for="nom_famille" class="form-label">👤 Nom de Famille</label>
            <input type="text" class="form-control" name="nom_famille" required>
        </div>

        <div class="mb-3">
            <label for="bureau_vote" class="form-label">🗳️ Bureau de Vote</label>
            <input type="text" class="form-control" name="bureau_vote" required>
        </div>

        <button type="button" class="btn btn-info w-100" id="btn-verifier">🔍 Vérifier</button>
    </form>

    <!-- Étape 2 : Formulaire d'ajout des informations de contact (affiché après vérification réussie) -->
    <form id="inscription-form" action="{{ route('electeur.inscription') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="numero_carte" id="hidden_numero_carte">
        <input type="hidden" name="numero_cni" id="hidden_numero_cni">
        <input type="hidden" name="nom_famille" id="hidden_nom_famille">
        <input type="hidden" name="bureau_vote" id="hidden_bureau_vote">

        <div class="mb-3">
            <label for="email" class="form-label">📧 Adresse Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">📞 Numéro de Téléphone</label>
            <input type="text" class="form-control" name="telephone" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">📩 Recevoir Code d'Authentification</button>
    </form>
</div>

<script>
   document.getElementById("form-inscription").addEventListener("submit", function (event) {
    event.preventDefault(); // Empêche le rechargement de la page

    let formData = new FormData(this);

    fetch("/electeur/inscription", {
        method: "POST",
        body: formData,
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json()) // Convertir en JSON
    .then(data => {
        if (data.error) {
            alert("Erreur: " + data.error);
        } else {
            alert("Succès: " + data.success);
            window.location.href = data.redirect; // Rediriger vers la page de vérification
        }
    })
    .catch(error => console.error("Erreur dans la requête fetch:", error));
});

});

</script>
@endsection
