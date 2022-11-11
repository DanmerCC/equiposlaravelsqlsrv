@extends('layouts.app')

@section('content')
    @php
        $title = 'Home';
        $breadcrumbs = [
            'First' => ['url' => '/first'],
            'Second' => ['url' => '/second'],
            'Third' => ['url' => '/third'],
        ];
    @endphp

    <div class="container">

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Contador de equipos asignados en total</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Asignadas:</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <h3>{{ $asign }} Laptops<sup style="font-size: 20px"></sup></h3>
                        <a class="small text-white stretched-link" href="Tabla_Asignados.php">></a>
                        <!--<div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Total: Call + Staff + Libres + Malogrados</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <h3>{{ $noAsign }} Laptops<sup style="font-size: 20px"></sup></h3>
                        <a class="small text-white stretched-link" href="Tabla_Total.php">></a>
                        <!--<div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                    </div>
                </div>
            </div>

        </div>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Contador de equipos asignados</li>
        </ol>
        <div class="row">
            @for ($i = 0; $i < count($resumegrups); $i++)
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body"> {{ $resumegrups[$i]->grupo }} :</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <h3>{{ $resumegrups[$i]->total }} Laptops<sup style="font-size: 20px"></sup></h3>
                            <a class="small text-white stretched-link" href="Tabla_CallCenter.php">></a>
                            <!--<div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                        </div>
                    </div>
                </div>
            @endfor


        </div>


        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Contador de equipos en el Call con caracteristicas</li>
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Laborando: Call + Staff</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <h3>84 Laptops<sup style="font-size: 20px"></sup></h3>
                        <a class="small text-white stretched-link" href="Tabla_Laborando.php">></a>
                        <!--<div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Vacaciones:</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <h3>02 Laptops<sup style="font-size: 20px"></sup></h3>
                        <a class="small text-white stretched-link" href="Tabla_Vacaciones.php">></a>
                        <!--<div class="small text-white"><i class="fas fa-angle-right"></i></div>-->
                    </div>
                </div>
            </div>
        </div>
        <equipos-table></equipos-table>
    </div>
@endsection
