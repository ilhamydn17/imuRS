@extends('templates.root')
@section('title', 'Tambah Unit')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Unit Baru</h1>
        </div>

        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Buat Unit Baru</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('unit.store') }}" method="POST" class="need-validation">
                                @csrf
                                <div class="form-group">
                                    <label>Nama Unit</label>
                                    <input type="text"  class="form-control @error('nama_unit')
                                    is-invalid
                                  @enderror " name="nama_unit">
                                  @error('nama_unit')
                                  <div class="invalid-feedback">
                                      {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                                <div class="form-group">
                                    <label>Code Identity</label>
                                    <input type="text" class="form-control" name="code_identity" value="{{ Str::random(6) }}" readonly>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="{{ back()->getTargetUrl() }}" class="btn btn-success">Kembali</a>
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
