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
                            $datachart = $data
                                ->map(function ($item) {
                                    return [$item->grupo => $item->total];
                                })
                                ->reduce(function ($before, $current) {
                                    return array_merge($before, $current);
                                }, []);
                        @endphp
                        <!--<Bars :groups="{{ json_encode($data->pluck('grupo')->toArray()) }}"
                                    :data="{{ json_encode($data->pluck('total')->toArray()) }}"></Bars>-->
                        <chart :data='{{ json_encode($datachart) }}'></chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
