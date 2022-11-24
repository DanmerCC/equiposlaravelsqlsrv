@extends('layouts.app')

@section('content')
    @php
        $title = 'Asesores';
        $breadcrumbs = [
            'Inicio' => ['url' => '/home'],
            'Asesores' => ['url' => '/asesores'],
        ];
    @endphp

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Asesores</div>

                    <div class="card-body">



                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <asesores-table ref='asesorestable'></asesores-table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
