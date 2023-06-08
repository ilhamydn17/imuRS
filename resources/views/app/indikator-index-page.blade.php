@extends('templates.root')
@section('title', 'Input Harian')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Harian - {{ $userData->unit->nama_unit }}</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Input Harian Indikator Mutu Unit - [{{ date('d F y') }}]</h2>
            <div class="row">
                <div class="col-md-12">
                    {{-- @if ($indikatorMutu->count() == 0)
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
                    @else --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Data Indikator Mutu</h4>
                        </div>
                        <div class="card-body" style="margin-top:-30px">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col" class="text-capitalize">Nama Kategori</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                <tbody>
                                    @forelse($indikatorMutu as $item)
                                        <tr>
                                            <th scope="row">{{ $indikatorMutu->firstItem() + $loop->index }}</th>
                                            <td class="text-capitalize">{{ $item->nama_indikator }}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    <span class="badge badge-danger">Belum Input</span>
                                                @else
                                                    <span class="badge badge-success">Sudah Input</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                                    class="btn btn-warning">Input</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-warning">
                                           Data indikator mutu belum ada.
                                        </div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ $indikatorMutu->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection


{{--
    --}}
