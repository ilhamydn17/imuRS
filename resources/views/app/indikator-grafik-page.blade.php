@extends('templates.root')
@section('title', 'Grafik Data')
@section('content')
    <div class="section">
        <div class="section-header">
            <h1>Monitoring Indikator Mutu</h1>
        </div>
        <div class="section-body">
            @isset($parameter)
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                {{-- Form Input for Chart Parameter --}}
                                <form action="{{ route('indikator-mutu.getChart') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="text-capitalize">Pilih Kategori Indikator</label>
                                        <select class="form-control text-uppercase" name="indikator_mutu_id">
                                            @foreach ($parameter as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_indikator }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-capitalize">Masukkan Tahun</label>
                                        <input type="year" class="form-control" name="tahun">
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset


            @isset($chart)
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
            @endisset
        </div>
    </div>
@endsection
