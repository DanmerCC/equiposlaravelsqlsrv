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
                                    return [$item->supervisor->nombres => [
                                        "value"=>$item->total,
                                        "photo_url"=>$item->supervisor->photo_url
                                        ]
                                    ];
                                })
                                ->reduce(function ($before, $current) {
                                    return array_merge($before, $current);
                                }, []);
                            //dd($datachart);
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
                            });

                            $ranges = [
                                "0 a 2 años" => [0,1,2],
                                "2 años" => [2],
                                "3 años" => [3]
                            ];

                            $totales = [];

                            foreach ($ranges as $key => $value) {
                                $totales[$key] = $resumentAntiguedad->filter(function($resume)use(&$totales,$value){
                                    return in_array($resume->years,$value);
                                })->reduce(function($current,$resume){
                                    return $current + $resume->total;
                                },0);
                            }

                            $totales["4 a mas"] = $resumentAntiguedad->filter(function($resume)use(&$totales,$value){
                                return $resume->years>=4;
                            })->reduce(function($current,$resume){
                                return $current + $resume->total;
                            },0);

                        @endphp
                        <Bars :horizontal="true"
                            :groups="{{ json_encode(array_keys($totales)) }}"
                            :data="{{ json_encode(array_values($totales)) }}">
                        </Bars>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
