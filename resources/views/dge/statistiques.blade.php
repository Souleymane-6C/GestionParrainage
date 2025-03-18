@extends('layouts.dge')

@section('content')
    <div class="container">
        <h1 class="text-center text-primary mb-4">
            <i class="fa-solid fa-chart-bar"></i> Statistiques des Parrainages
        </h1>

        <!-- Section des statistiques générales -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body text-center">
                        <h4><i class="fa-solid fa-users"></i> Nombre total de candidats</h4>
                        <h2>{{ count($candidats) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-info text-white shadow-sm">
                    <div class="card-body text-center">
                        <h4><i class="fa-solid fa-handshake"></i> Total des parrainages</h4>
                        <h2>{{ $candidats->sum('parrainages_count') }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des candidats -->
        @if($candidats->isEmpty())
            <div class="alert alert-info text-center">
                <i class="fa-solid fa-info-circle"></i> Aucun candidat enregistré.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Numéro de Carte</th>
                            <th>Date de Naissance</th>
                            <th>Nombre de Parrainages</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidats as $candidat)
                            <tr>
                                <td>{{ $candidat->nom }}</td>
                                <td>{{ $candidat->prenom }}</td>
                                <td>{{ $candidat->numero_carte }}</td>
                                <td>{{ \Carbon\Carbon::parse($candidat->date_naissance)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="fa-solid fa-hands-helping"></i> {{ $candidat->parrainages_count ?? 0 }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
