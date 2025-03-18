@extends('layouts.dge')

@section('content')
    <h1>Importer le fichier électoral</h1>

    <!-- Affichage des messages de succès ou d'erreur -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('dge.import.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="fichier_electeurs" class="form-label">Fichier CSV des électeurs</label>
            <input type="file" class="form-control" id="fichier_electeurs" name="fichier_electeurs" required>
        </div>
        <div class="mb-3">
            <label for="checksum" class="form-label">Empreinte SHA256</label>
            <input type="text" class="form-control" id="checksum" name="checksum" required>
        </div>
        <button type="submit" class="btn btn-primary">Importer</button>
    </form>
@endsection
