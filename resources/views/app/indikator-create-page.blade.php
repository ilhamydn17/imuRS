@extends('templates.root')
@section('title', 'Tambah Indikator')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Indikator Mutu Unit</h1>
        </div>

        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Input Indikator Mutu</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('indikator-mutu.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Unit</label>
                                    <select class="form-control" name="unit_id">
                                        @foreach ($data_unit as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Indikator Mutu</label>
                                    <input type="text" class="form-control text-uppercase" name="nama_indikator">
                                </div>
                                <div class="form-group">
                                    <label>Nama Numerator</label>
                                    <input type="text" class="form-control text-capitalize" name="nama_numerator">
                                </div>
                                <div class="form-group">
                                    <label>Nama Denumerator</label>
                                    <input type="text" class="form-control text-capitalize" name="nama_denumerator">
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
