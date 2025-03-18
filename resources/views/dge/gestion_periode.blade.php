@extends('layouts.dge')

@section('content')

    <h1>Gestion de la Période de Parrainage</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($periode)
        <div>
            <p><strong>Date de début :</strong> {{ $periode->date_debut }}</p>
            <p><strong>Date de fin :</strong> {{ $periode->date_fin }}</p>
            <p><strong>État :</strong> 
                @if($periode->etat == 1)
                    <span class="text-success">Ouvert</span>
                @else
                    <span class="text-danger">Fermé</span>
                @endif
            </p>

            <!-- Bouton pour ouvrir ou fermer la période -->
            <form action="{{ route('dge.toggle_periode', $periode->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-{{ $periode->etat ? 'danger' : 'success' }}">
                    {{ $periode->etat ? 'Fermer' : 'Ouvrir' }} la période
                </button>
            </form>
        </div>
    @endif

    @if(!$periode || $periode->etat == 0) 
        <form action="{{ route('dge.periode.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="date_debut">Date de Début</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control" 
                       value="{{ $periode ? $periode->date_debut : old('date_debut') }}" required>
            </div>

            <div class="form-group">
                <label for="date_fin">Date de Fin</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control" 
                       value="{{ $periode ? $periode->date_fin : old('date_fin') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">
                @if($periode) Mettre à jour @else Enregistrer @endif
            </button>
        </form>
    @else
        <p class="text-warning">Impossible de modifier une période déjà ouverte.</p>
    @endif

@endsection
