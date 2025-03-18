@extends('layouts.parrain')

@section('content')
<div class="container">
    <h2 class="text-center my-4">🔑 Vérification du Code</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('electeur.valider_code', $electeur->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Entrez le Code Reçu</label>
            <input type="text" class="form-control" name="code" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">✔️ Valider</button>
    </form>
</div>
@endsection
