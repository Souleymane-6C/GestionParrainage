@extends('layouts.app')

@section('content')

    <h1>Gestion de la Période de Parrainage</h1>

    @if($periode)
        <div>
            <p><strong>Date de début :</strong> {{ $periode->date_debut }}</p>
            <p><strong>Date de fin :</strong> {{ $periode->date_fin }}</p>
        </div>
    @else
        <form action="{{ route('dge.periode.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="date_debut">Date de Début</label>
                <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
            </div>

            <div class="form-group">
                <label for="date_fin">Date de Fin</label>
                <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

@endsection
