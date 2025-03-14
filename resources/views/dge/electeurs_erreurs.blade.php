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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($electeursErreurs as $electeur)
                        @if(!empty($electeur->numero_carte_electeur) || !empty($electeur->numero_cni) || !empty($electeur->nom_famille) || !empty($electeur->prenom))
                            <tr>
                                <form action="{{ route('dge.electeursErreurs.correction', $electeur->id) }}" method="POST">
                                    @csrf
                                    <td>
                                        <input type="text" name="numero_carte_electeur" class="form-control" value="{{ $electeur->numero_carte_electeur ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="numero_cni" class="form-control" value="{{ $electeur->numero_cni ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="nom_famille" class="form-control" value="{{ $electeur->nom_famille ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="prenom" class="form-control" value="{{ $electeur->prenom ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="date" name="date_naissance" class="form-control" value="{{ $electeur->date_naissance ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="lieu_naissance" class="form-control" value="{{ $electeur->lieu_naissance ?? '' }}">
                                    </td>
                                    <td>
                                        <select name="sexe" class="form-control">
                                            <option value="H" {{ $electeur->sexe == 'H' ? 'selected' : '' }}>Homme</option>
                                            <option value="F" {{ $electeur->sexe == 'F' ? 'selected' : '' }}>Femme</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="bureau_vote" class="form-control" value="{{ $electeur->bureau_vote ?? '' }}">
                                    </td>
                                    <td class="text-danger"><strong>{{ $electeur->nature_erreur }}</strong></td>
                                    <td class="text-danger">{{ $electeur->description_erreur }}</td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">✅ Corriger</button>
                                    </td>
                                </form>
                                <td>
                                    <form action="{{ route('dge.electeursErreurs.delete', $electeur->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
