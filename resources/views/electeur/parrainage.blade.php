@extends('layouts.electeur')

@section('title', 'Enregistrement du parrainage')

@section('content')
<div class="card">
    <div class="card-header">Choisissez un candidat à parrainer</div>
    <div class="card-body">
        <form action="{{ route('electeur.store_parrainage') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="candidat" class="form-label">Sélectionner un candidat</label>
                <select class="form-control" name="candidat_id" required>
                    @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}">{{ $candidat->nom }} - {{ $candidat->slogan }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Parrainer</button>
        </form>
    </div>
</div>
@endsection
