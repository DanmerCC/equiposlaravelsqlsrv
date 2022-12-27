@extends('layouts.app')

@section('content')
    @php
        $title = 'Actas';
        $breadcrumbs = [
            'Inicio' => ['url' => '/home'],
            'Actas' => ['url' => '/actas'],
        ];
    @endphp

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Actas</div>

                    <div class="card-body">



                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <actas-crear></actas-crear>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
