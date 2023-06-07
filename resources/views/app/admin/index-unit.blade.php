@extends('templates.root')
@section('title', 'Data Unit')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Unit RSAU</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body mt-4">
                    <a href="{{ route('unit.create') }}" class="btn btn-primary mb-2 me-2 float-end">Tambah Data Unit</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Unit</th>
                                <th scope="col">Kode Identitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $item)
                                <tr>
                                    <th scope="row">{{ $units->firstItem() + $loop->index }}</th>
                                    <td>{{ $item->nama_unit }}</td>
                                    <td>{{ $item->code_identity }}</td>
                                </tr>
                            @empty
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
                            @endforelse
                        </tbody>
                    </table>
                    {{ $units->links()  }}
                </div>
            </div>
        </div>
    </section>
@endsection
