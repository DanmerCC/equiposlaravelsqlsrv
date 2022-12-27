@extends('layouts.app')

@section('content')
    @php
        $title = 'Mobiles';
        $breadcrumbs = [
            'Inicio' => ['url' => '/home'],
            'Mobiles' => ['url' => '/Mobiles'],
        ];
    @endphp

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">

            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Mobiles</div>

                    <div class="card-body">



                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <moviles-table ref='movilestable'></moviles-table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
