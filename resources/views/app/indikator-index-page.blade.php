@extends('templates.root')
@section('title', 'Input Harian')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Harian - {{ $user_data->unit->nama_unit }}</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Input Harian Indikator Mutu Unit - [{{ date('d F y') }}]</h2>
            <div class="row">
                <div class="col-md-12">
                    @if ($indikator_mutu->count() == 0)
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-warning alert-has-icon">
                                    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Warning</div>
                                        Data indikator mutu belum ada.
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header">
                        <h4>Data Indikator Mutu</h4>
                    </div>
                    <div class="card-body" style="margin-top:-30px">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col" class="text-capitalize">Nama Kategori</th>
                                    <th scope="col">Status</th>
                                    <th>Aksi</th>
                                </tr>
                            <tbody>
                                @foreach ($indikator_mutu as $item)
                                    <tr>
                                        <th scope="row">{{ $indikator_mutu->firstItem() + $loop->index }}</th>
                                        <td class="text-capitalize">{{ $item->nama_indikator }}</td>
                                        <td style="border-block: 2px">
                                            @if ($item->pengukuran_mutu->count() > 0 && $item->pengukuran_mutu->last()->tanggal_input == now()->format('Y-m-d'))
                                                <a href="#" class="btn btn-success" style="cursor:default">Terisi</a>
                                            @else
                                                <a href="#" class="btn btn-warning" style="cursor:default">Kosong</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->pengukuran_mutu->count() > 0 && $item->pengukuran_mutu->last()->tanggal_input == now()->format('Y-m-d'))
                                                <a href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                                    class="btn btn-primary disabled">Input</a>
                                            @else
                                                <a href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                                    class="btn btn-primary">Input</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $indikator_mutu->links() }}
                @endif

            </div>
        </div>
        </div>
    </section>
@endsection


{{--
    --}}
