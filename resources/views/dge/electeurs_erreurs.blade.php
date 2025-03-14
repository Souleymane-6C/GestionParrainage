@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">🔍 Électeurs à Problèmes</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($electeursErreurs->isEmpty())
            <div class="alert alert-info">✅ Aucun électeur à problème pour le moment.</div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
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
                        <th>Correction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($electeursErreurs as $electeur)
                        <tr>
                            <form action="{{ route('dge.electeursErreurs.correction', $electeur->id) }}" method="POST">
                                @csrf
                                <td>
                                    <input type="text" name="numero_carte_electeur" 
                                           value="{{ $electeur->numero_carte_electeur ?? '' }}" 
                                           class="form-control {{ $electeur->numero_carte_electeur ? '' : 'is-invalid' }}" 
                                           placeholder="Numéro Carte">
                                </td>
                                <td>
                                    <input type="text" name="numero_cni" 
                                           value="{{ $electeur->numero_cni ?? '' }}" 
                                           class="form-control {{ $electeur->numero_cni ? '' : 'is-invalid' }}" 
                                           placeholder="Numéro CNI">
                                </td>
                                <td>
                                    <input type="text" name="nom_famille" 
                                           value="{{ $electeur->nom_famille ?? '' }}" 
                                           class="form-control {{ $electeur->nom_famille ? '' : 'is-invalid' }}" 
                                           placeholder="Nom">
                                </td>
                                <td>
                                    <input type="text" name="prenom" 
                                           value="{{ $electeur->prenom ?? '' }}" 
                                           class="form-control {{ $electeur->prenom ? '' : 'is-invalid' }}" 
                                           placeholder="Prénom">
                                </td>
                                <td>
                                    <input type="date" name="date_naissance" 
                                           value="{{ $electeur->date_naissance ?? '' }}" 
                                           class="form-control {{ $electeur->date_naissance ? '' : 'is-invalid' }}">
                                </td>
                                <td>
                                    <input type="text" name="lieu_naissance" 
                                           value="{{ $electeur->lieu_naissance ?? '' }}" 
                                           class="form-control {{ $electeur->lieu_naissance ? '' : 'is-invalid' }}" 
                                           placeholder="Lieu de naissance">
                                </td>
                                <td>
                                    <select name="sexe" class="form-control">
                                        <option value="H" {{ $electeur->sexe == 'H' ? 'selected' : '' }}>Homme</option>
                                        <option value="F" {{ $electeur->sexe == 'F' ? 'selected' : '' }}>Femme</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="bureau_vote" 
                                           value="{{ $electeur->bureau_vote ?? '' }}" 
                                           class="form-control {{ $electeur->bureau_vote ? '' : 'is-invalid' }}" 
                                           placeholder="Bureau de vote">
                                </td>
                                <td class="text-danger"><strong>{{ $electeur->nature_erreur }}</strong></td>
                                <td class="text-danger">{{ $electeur->description_erreur }}</td>
                                <td>
                                    <button type="submit" class="btn btn-success btn-sm">✅ Corriger</button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
