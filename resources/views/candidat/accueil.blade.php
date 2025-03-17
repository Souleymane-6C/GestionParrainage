
@extends('layouts.candidat')

@section('content')
<div class="container text-center">
    <h1>Bienvenue sur la plateforme de Parrainage</h1>
    <p>Connectez-vous ou inscrivez-vous pour gérer votre candidature.</p>

    <a href="{{ route('candidat.login') }}" class="btn btn-primary">Se connecter</a>
    <a href="{{ route('candidat.inscription.form') }}" class="btn btn-success">S'inscrire</a>
</div>

@endsection