@extends('templates.root')
@section('title', 'Input Harian')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1 class="text-uppercase">{{ $currentIndikatorMutu->nama_indikator }}</h1>
        </div>

        <div class="section-body">
            <div class="row d-flex justify-content-center">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Input</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pengukuran-mutu.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="text-capitalize">{{ $currentIndikatorMutu->nama_numerator }} (numerator)</label>
                                    <input type="number" class="form-control @error('numerator')
                                        is-invalid
                                    @enderror" name="numerator" maxlength="100" required>
                                    @error('numerator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-capitalize">{{ $currentIndikatorMutu->nama_denumerator }} (denumerator)</label>
                                    <input type="number" class="form-control @error('denumerator')
                                        is-invalid
                                    @enderror" name="denumerator" maxlength="100" required>
                                    @error('denumerator')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    {{-- Input ini untuk mengisi kolom FK(indikator_mutu_id) yang ada di tabel pengukuran_mutu --}}
                                    <input type="hidden" value="{{ $currentIndikatorMutu->id }}" name="indikator_mutu_id" id="">
                                    {{-- Input ini untuk mengisi kolom tanggal_input yang ada di tabel pengukuran_mutu sesuai dengan tanggal saat input itu dilakukan--}}
                                    <input type="hidden" value="{{ date('Y-m-d') }}" name="tanggal_input" id="">
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                    <a href="{{ back()->getTargetUrl()}}" class="btn btn-success">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
