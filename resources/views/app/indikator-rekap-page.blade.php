@extends('templates.root')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Rekap Harian</h1>
        </div>

        <div class="section-body">
            <h2 class="section-title">Rekap Prosentase Harian</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-capitalize">Nama Indikator</label>
                                            <select class="form-control text-uppercase" name="unit_id">
                                                @foreach ($data_indikator as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama_indikator }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-capitalize">Bulan</label>
                                            <select class="form-control text-uppercase" name="unit_id">
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="text-capitalize">Tahun</label>
                                            <input type="year" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                    <a href="{{ back()->getTargetUrl() }}" class="btn btn-success">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
