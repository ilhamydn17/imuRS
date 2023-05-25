<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Hasil Rekapitulasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>

    <div class="container p-4">
        <div class="row">
            <div class="col">
                <h2 class="text-capitalize text-center">Rekap Harian {{ $indikator_mutu->nama_indikator }} - [{{ \Carbon\Carbon::parse($bulan)->format('F Y') }}]</h2>
                <h4 class="text-center">Unit {{ $nama_unit }}</h4>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <table class="table table-bordered text-center" border style="border-collapse:collapse">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Input</th>
                            <th scope="col" class="text-capitalize">{{ $indikator_mutu->nama_numerator }}</th>
                            <th scope="col" class="text-capitalize">{{ $indikator_mutu->nama_denumerator }}</th>
                            <th scope="col">Prosentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($data_rekap) --}}
                        @foreach ($data_rekap as $item)
                            <tr>
                                <td scope="row">{{ $item->tanggal_input }}</td>
                                <td>{{ $item->numerator }}</td>
                                <td>{{ $item->denumerator }}</td>
                                <td>{{ $item->prosentase }} %</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Rata-rata</th>
                            <th>{{ $avg }} %</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>
