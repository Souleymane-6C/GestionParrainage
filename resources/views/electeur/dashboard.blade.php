@extends('layouts.electeur')

@section('title', 'Tableau de bord')

@section('content')
<h3>Bienvenue, {{ Auth::guard('electeur')->user()->nom }}</h3>
<p>Vous pouvez effectuer un parrainage pour un candidat.</p>
<a href="{{ route('electeur.parrainage') }}" class="btn btn-success">Faire un parrainage</a>
@endsection
