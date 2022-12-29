@extends('pdf.acta')

@section('hardware')
    <table>
        <thead>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Nro de Serie</th>
            <th>Costo</th>
            <th>Estado</th>
            <th>Observaciones</th>
        </thead>
        <tbody>
            <tr>
                <td> {{ $equipo->marca }}</td>
                <td> {{ $equipo->modelo }}</td>
                <td> {{ $equipo->color }}</td>
                <td> {{ $equipo->serie }}</td>
                <td> {{ $equipo->precio }}</td>
                <td> {{ $equipo->estado }}</td>
                <td> {{ $equipo->observacion }}</td>
            </tr>
        </tbody>
    </table>
@endsection
