@extends('templates.root')
@section('title', 'Grafik Data')
@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Monitoring Indikator Mutu</h1>
        </div>
        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-container">
                                {{ $chart->container() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
