@extends('layouts.electeur')

@section('title', 'Validation du parrainage')

@section('content')
    <h2>Validation du parrainage</h2>
    <p>Un code de validation a été envoyé à votre email et votre téléphone.</p>

    <form action="{{ route('electeur.validation') }}" method="POST">
        @csrf
        <label>Code de validation reçu :</label>
        <input type="text" name="code_validation" required>

        <button type="submit">Confirmer</button>
    </form>
@endsection
