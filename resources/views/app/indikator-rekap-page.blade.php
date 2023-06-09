@extends('templates.root')
@section('title', 'Rekap Data')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Rekap Harian</h1>
        </div>

        <div class="section-body">
            @isset($dataIndikator)
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
                                            @foreach ($dataIndikator as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_indikator }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="text-capitalize">Bulan</label>
                                        <input class="form-control" type="month" id="bulan" name="bulan" required>
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
                                <div class="container mt-2 text-center">
                                    <h4 class="text-capitalize text-center mb-4">Rekap {{ $indikator_mutu->nama_indikator }} -
                                        [{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}]</h4>
                                    <table class="table table-sm table-bordered text-center">
                                        <tr>
                                            <th>Tanggal Input</th>
                                            <th class="text-capitalize">{{ $indikator_mutu->nama_numerator }}</th>
                                            <th class="text-capitalize">{{ $indikator_mutu->nama_denumerator }}</th>
                                            <th class="text-capitalize">prosentase</th>
                                        </tr>
                                        @forelse ($rekap as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_input)->format('d-m-Y') }}</td>
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
                                        <tr>
                                            <th colspan="3">
                                                Rata-rata
                                            </th>
                                            <th>{{ $avg }} %</th>
                                        </tr>
                                    </table>
                                    <a href="{{ back()->getTargetUrl() }}" class="btn btn-success">Kembali</a>
                                    <a href="{{ route('indikator-mutu.pdf', ['id' => $indikator_mutu->id, 'bulan' => $bulan]) }}"
                                        target="_blank"
                                        class="btn btn-info
                                            @if ($rekap->count() == 0) disabled @endif
                                        ">Download
                                        PDF
                                    </a>
                                    <a href="{{ route('indikator-mutu.exportExcel',['id' => $indikator_mutu->id, 'bulan' => $bulan]) }}" class="btn btn-warning">Export Excel</a>
                                    <a href="{{ route('indikator-mutu.chart',['indikator_id' => $indikator_mutu->id, 'tanggal' => $bulan]) }}" class="btn btn-primary">Lihat Grafik</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endisset
        </div>
    </section>
@endsection
