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
                <td> {{ $movil->marca }}</td>
                <td> {{ $movil->modelo }}</td>
                <td> {{ $movil->color }}</td>
                <td> {{ $movil->serie }}</td>
                <td> {{ $movil->precio }}</td>
                <td> {{ $movil->estado }}</td>
                <td> {{ $movil->observacion }}</td>
            </tr>
        </tbody>
    </table>
@endsection
