@extends('layouts.dge')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">📊 Tableau de Bord</h1>

        <div class="row">
            <!-- Statistiques des Candidats -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fa-solid fa-users"></i> Statistiques des Candidats
                    </div>
                    <div class="card-body">
                        @if($candidats->isEmpty())
                            <p class="text-muted text-center">Aucun candidat ajouté.</p>
                        @else
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Nombre de Parrainages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidats as $candidat)
                                        <tr>
                                            <td>{{ $candidat->nom }}</td>
                                            <td>{{ $candidat->prenom }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $candidat->parrainages_count ?? 0 }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Période de Parrainage -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <i class="fa-solid fa-calendar-check"></i> Période de Parrainage
                    </div>
                    <div class="card-body text-center">
                        @if($periode)
                            <p><strong>Début :</strong> 📅 {{ \Carbon\Carbon::parse($periode->date_debut)->format('d/m/Y') }}</p>
                            <p><strong>Fin :</strong> 📅 {{ \Carbon\Carbon::parse($periode->date_fin)->format('d/m/Y') }}</p>
                        @else
                            <p class="text-muted">Aucune période définie.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
