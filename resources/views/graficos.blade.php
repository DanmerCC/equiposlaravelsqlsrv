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
                        function formater($resumen,$attr){
                            return  $resumen->reduce(function($before,$current)use($attr){
                                $before[$current->{$attr}]=["value"=>$current->total];
                                return $before;
                            },[]);
                        }
                        @endphp
                        <div class="card">

                        </div>
                        <chart :data='{{ json_encode($datachart) }}'></chart>
                        <chart :data='{{ json_encode(formater($resumeDiscos,"tipo_disco")) }}'></chart>
                        <chart :data='{{ json_encode(formater($resumeProcesador,"procesador")) }}'></chart>
                        @php
                            $labelResumentAntiguedad = $resumentAntiguedad->pluck('years')->map(function($item){
                                return $item." años";
                            });

                            $ranges = [
                                "0 a 2 años" => [0,1],
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

                         <chart :data='{{ json_encode(array_map(function($item){
                            return ["value"=>$item];
                        },$totales)) }}'></chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
