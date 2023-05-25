@extends('templates.root')
@section('title', 'Tambah Indikator')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kategori Indikator Mutu Unit</h1>
        </div>

        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Input Kategori Baru</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('indikator-mutu.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Unit</label>
                                    <input type="text" value="{{ $data_unit->nama_unit }}"
                                        class="form-control text-uppercase" readonly>
                                    <input type="hidden" name="unit_id" value="{{ $data_unit->id }}">
                                </div>
                                <div class="form-group">
                                    <label>Nama Indikator Mutu</label>
                                    <input type="text" class="form-control text-uppercase" name="nama_indikator"
                                        autocomplete="off" required>
                                    @error('nama_indikator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Numerator</label>
                                    <input type="text" class="form-control text-capitalize" name="nama_numerator"
                                        autocomplete="off" required>
                                    @error('nama_numerator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama Denumerator</label>
                                    <input type="text" class="form-control text-capitalize" name="nama_denumerator"
                                        autocomplete="off" required>

                                    @error('nama_denumerator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
