@extends('layouts.app')

@section('content')
    @php
        $title = 'Graficos';
        $breadcrumbs = [
            'home' => ['url' => '/home']
        ];
    @endphp

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @php
                        //dd($resumegrups);
                            $datachart = $resumegrups
                                ->map(function ($item) {
                                    //dd($item);
                                    return [$item->supervisor->nombres => $item->total];
                                })
                                ->reduce(function ($before, $current) {
                                    return array_merge($before, $current);
                                }, []);
                        @endphp
                        <chart :data='{{ json_encode($datachart) }}'></chart>
                        <Bars :horizontal="true"
                            :groups="{{ json_encode($resumeDiscos->pluck('tipo_disco')->toArray()) }}"
                            :data="{{ json_encode($resumeDiscos->pluck('total')->toArray()) }}">
                        </Bars>
                        <Bars :horizontal="true"
                            :groups="{{ json_encode($resumeProcesador->pluck('procesador')->toArray()) }}"
                            :data="{{ json_encode($resumeProcesador->pluck('total')->toArray()) }}">
                        </Bars>
                        @php
                            $labelResumentAntiguedad = $resumentAntiguedad->pluck('years')->map(function($item){
                                return $item." años";
                            })
                        @endphp
                        <Bars :horizontal="true"
                            :groups="{{ json_encode($labelResumentAntiguedad->toArray()) }}"
                            :data="{{ json_encode($resumentAntiguedad->pluck('total')->toArray()) }}">
                        </Bars>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
