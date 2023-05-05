@extends('templates.root')

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
                        <div class="alert alert-warning" role="alert">
                           Data Indikator Mutu Unit Belum Tersedia
                        </div>
                    @else
                        <table class="table table-hover">
                        @foreach ($indikator_mutu as $item)
                                <tr>
                                    <td class="font-weight-bold">{{ $indikator_mutu->firstItem() + $loop->index }}</td>
                                    <td>
                                        <a class="text-primary text-decoration-none hover font-weight-bolder text-uppercase"
                                            id="list-profile-list" href="{{ route('pengukuran-mutu.inputHarian', $item->id) }}"
                                            data-bs-toggle="list" role="tab" aria-controls="list-profile-list">
                                            {{ $item->nama_indikator }}
                                        </a>
                                    </td>
                                    <td>
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
                        </table>
                        {{ $indikator_mutu->links() }}
                        @endif

                </div>
            </div>
        </div>
    </section>
@endsection


{{--
    --}}
