@extends('layouts.dge')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">
            🔍 <span class="text-primary">Électeurs à Problèmes</span>
        </h1>

        <!-- Affichage des messages -->
        @if(session('success'))
            <div class="alert alert-success text-center">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if($electeursErreurs->isEmpty())
            <div class="alert alert-info text-center">
                ✅ Aucun électeur à problème pour le moment.
            </div>
        @else
            <div class="table-responsive shadow-lg p-3 mb-5 bg-body rounded">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Numéro Carte Électeur</th>
                            <th>Numéro CNI</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Date de Naissance</th>
                            <th>Lieu de Naissance</th>
                            <th>Sexe</th>
                            <th>Bureau de Vote</th>
                            <th>Nature de l'erreur</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($electeursErreurs as $electeur)
                            @if(!empty($electeur->numero_carte_electeur) || !empty($electeur->numero_cni) || !empty($electeur->nom_famille) || !empty($electeur->prenom))
                                @php
                                    $errors = [];

                                    // 🔹 Vérification des erreurs selon ControlerElecteurs()
                                    if(empty($electeur->numero_carte_electeur)) {
                                        $errors['numero_carte_electeur'] = "Numéro de carte électeur manquant";
                                    } elseif(strlen($electeur->numero_carte_electeur) !== 10) {
                                        $errors['numero_carte_electeur'] = "Le numéro de carte doit contenir 10 caractères.";
                                    }

                                    if(empty($electeur->numero_cni)) {
                                        $errors['numero_cni'] = "Numéro CNI manquant";
                                    } elseif(strlen($electeur->numero_cni) !== 13) {
                                        $errors['numero_cni'] = "Le numéro CNI doit contenir 13 caractères.";
                                    }

                                    if(empty($electeur->nom_famille)) {
                                        $errors['nom_famille'] = "Nom manquant";
                                    }

                                    if(empty($electeur->prenom)) {
                                        $errors['prenom'] = "Prénom manquant";
                                    }

                                    if(empty($electeur->date_naissance)) {
                                        $errors['date_naissance'] = "Date de naissance manquante";
                                    }

                                    if(empty($electeur->lieu_naissance)) {
                                        $errors['lieu_naissance'] = "Lieu de naissance manquant";
                                    }

                                    if(empty($electeur->bureau_vote)) {
                                        $errors['bureau_vote'] = "Bureau de vote manquant";
                                    }
                                @endphp
                                <tr>
                                    <form action="{{ route('dge.electeursErreurs.correction', $electeur->id) }}" method="POST">
                                        @csrf
                                        <td>
                                            <input type="text" name="numero_carte_electeur" 
                                                   class="form-control {{ isset($errors['numero_carte_electeur']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->numero_carte_electeur ?? '' }}">
                                            @if(isset($errors['numero_carte_electeur']))
                                                <div class="invalid-feedback">{{ $errors['numero_carte_electeur'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="numero_cni" 
                                                   class="form-control {{ isset($errors['numero_cni']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->numero_cni ?? '' }}">
                                            @if(isset($errors['numero_cni']))
                                                <div class="invalid-feedback">{{ $errors['numero_cni'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="nom_famille" 
                                                   class="form-control {{ isset($errors['nom_famille']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->nom_famille ?? '' }}">
                                            @if(isset($errors['nom_famille']))
                                                <div class="invalid-feedback">{{ $errors['nom_famille'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="prenom" 
                                                   class="form-control {{ isset($errors['prenom']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->prenom ?? '' }}">
                                            @if(isset($errors['prenom']))
                                                <div class="invalid-feedback">{{ $errors['prenom'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" name="date_naissance" 
                                                   class="form-control {{ isset($errors['date_naissance']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->date_naissance ?? '' }}">
                                            @if(isset($errors['date_naissance']))
                                                <div class="invalid-feedback">{{ $errors['date_naissance'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" name="lieu_naissance" 
                                                   class="form-control {{ isset($errors['lieu_naissance']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->lieu_naissance ?? '' }}">
                                            @if(isset($errors['lieu_naissance']))
                                                <div class="invalid-feedback">{{ $errors['lieu_naissance'] }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <select name="sexe" class="form-control">
                                                <option value="H" {{ $electeur->sexe == 'H' ? 'selected' : '' }}>Homme</option>
                                                <option value="F" {{ $electeur->sexe == 'F' ? 'selected' : '' }}>Femme</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="bureau_vote" 
                                                   class="form-control {{ isset($errors['bureau_vote']) ? 'is-invalid' : '' }}" 
                                                   value="{{ $electeur->bureau_vote ?? '' }}">
                                            @if(isset($errors['bureau_vote']))
                                                <div class="invalid-feedback">{{ $errors['bureau_vote'] }}</div>
                                            @endif
                                        </td>
                                        <td class="text-danger text-center">
                                            <strong>{{ $electeur->nature_erreur }}</strong>
                                        </td>
                                        <td class="text-danger text-center">{{ $electeur->description_erreur }}</td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                ✅ Corriger
                                            </button>
                                        </td>
                                    </form>
                                    <td class="text-center">
                                        <form action="{{ route('dge.electeursErreurs.delete', $electeur->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                🗑️ Supprimer
                                            </button>
                                        </form>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
