@extends('layouts.app')

@section('content')
    @php
        $title = 'Usuarios';
        $breadcrumbs = [
            'Inicio' => ['url' => '/home'],
            'Usuarios' => ['url' => '/usuarios'],
        ];
    @endphp

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Usuarios</div>

                    <div class="card-body">



                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <usuarios-table></usuarios-table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
