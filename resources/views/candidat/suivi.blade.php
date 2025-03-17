@extends('layouts.candidat')

@section('content')
<div class="container">
    <h2>Suivi des Parrainages</h2>

    @if(isset($parrainages) && $parrainages->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nombre de Parrainages</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parrainages as $parrainage)
                    <tr>
                        <td>{{ $parrainage->date }}</td>
                        <td>{{ $parrainage->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Aucun parrainage trouvé.</p>
    @endif
</div>
@endsection
