<h3>Statistiques des Candidats</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Nombre de Parrainages</th>
        </tr>
    </thead>
    <tbody>
        @foreach($candidats as $candidat)
            <tr>
                <td>{{ $candidat->nom }}</td>
                <td>{{ $candidat->prenom }}</td>
                <td>{{ $candidat->parrainages_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Période de Parrainage</h3>
@if($periode)
    <p>Début : {{ $periode->date_debut }}</p>
    <p>Fin : {{ $periode->date_fin }}</p>
@else
    <p>Aucune période définie.</p>
@endif
