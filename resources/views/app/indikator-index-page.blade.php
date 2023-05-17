@extends('templates.root')
@section('title', 'Input Harian')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Input Harian - {{ $user_data->unit->nama_unit }}</h1>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @elseif ($message = Session::get('error'))
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @endif

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
                        <table class="table table-bordered">
                            <tbody>
                                @foreach ($indikator_mutu as $item)
                                    <tr>
                                        <th scope="row">{{ $indikator_mutu->firstItem() + $loop->index }}</th>
                                        <td class="text-capitalize">{{ $item->nama_indikator }}</td>
                                        <td style="border-block: 2px">
                                            @if ($item->pengukuran_mutu->count() > 0 && $item->pengukuran_mutu->last()->tanggal_input == now()->format('Y-m-d'))
                                                <a href="#" class="btn btn-warning disabled">Terisi</a>
                                            @else
                                                <a href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                                    class="btn btn-success btn">Input</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <table class="table table-hover">
                            @foreach ($indikator_mutu as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $indikator_mutu->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a class="text-primary text-decoration-none hover font-weight-bolder text-uppercase"
                                            id="list-profile-list"
                                            href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                            data-bs-toggle="list" role="tab" aria-controls="list-profile-list">
                                            {{ $item->nama_indikator }}
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success" data-toggle="tooltip"
                                            data-placement="left">
                                            masukkan
                                        </button>
                                        @if ($item->pengukuran_mutu->count() > 0 && $item->pengukuran_mutu->last()->tanggal_input == now()->format('Y-m-d'))
                                            <span class="badge bg-success rounded-full"><i
                                                    class="fa-solid fa-check"></i></i></span>
                                        @else
                                            <span class="badge bg-warning rounded-full"><i
                                                    class="fa-solid fa-times"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table> --}}
                {{ $indikator_mutu->links() }}
                @endif

            </div>
        </div>
        </div>
    </section>
@endsection


{{--
    --}}
