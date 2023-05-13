@extends('templates.root')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Rekap Harian</h1>
        </div>

        <div class="section-body">
            @isset($data_indikator)
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Cari Rekap Berdasar Bulan</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('indikator-mutu.getRekap') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="text-capitalize">Nama Indikator</label>
                                        <select class="form-control text-uppercase" name="indikator_mutu_id">
                                            @foreach ($data_indikator as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_indikator }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-capitalize">Bulan</label>
                                        <input type="month" id="bulan" name="bulan" required>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary mr-1" type="submit" id="showRekap">Tampilkan
                                            Rekap</button>
                                        <button class="btn btn-secondary" type="reset">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset

            @isset($rekap)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container mt-2">
                                    {{-- set format to diff for humans in Indonesian--}}

                                    {{-- <h4 class="text-capitalize text-center mb-4">Rekap {{ $indikator_mutu->nama_indikator }} - {{ \Carbon\Carbon::parse($rekap->first()->tanggal_input)->format('F Y') }}</h4> --}}
                                    <table class="table table-sm table-bordered table-hover text-center">
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <th class="text-capitalize">{{ $indikator_mutu->nama_numerator }}</th>
                                            <th class="text-capitalize">{{ $indikator_mutu->nama_denumerator }}</th>
                                            <th class="text-capitalize">prosentase</th>
                                        </tr>
                                        @forelse ($rekap as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d-m-Y')  }}</td>
                                                <td>{{ $item->numerator }}</td>
                                                <td>{{ $item->denumerator }}</td>
                                                <td>{{ $item->prosentase }} %</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-warning font-weight-bold">Data tidak ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </section>
@endsection
