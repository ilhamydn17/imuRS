<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use App\Models\AveragePerbulan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreIndikatorMutuRequest;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class IndikatorMutuController extends Controller
{
    /**
     * Halaman pertama yang ditampilkan saat user berhasil login
     */
    public function index()
    {
        // Mendapatkan data user yang telah berhasil login
        $user_data = auth()->user();
        // Mengambil data indikator_mutu (bersifat many) dari unit(relasi dengan user) yang telah login
        $indikator_mutu = IndikatorMutu::where(
            'unit_id',
            $user_data->unit->id
        )->paginate(5);

        //tanggal hari ini
        $today = Carbon::now()->format('Y-m-d');

        //tanggal kemarin
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        // dd($yesterday);

        if (
            // jika data indikator mutu kemarin sudah diisi maka update nilai kolom status menjadi 0
            IndikatorMutu::with('pengukuran_mutu')->where('status',
                1)->where('unit_id',
                    $user_data->unit->id)->whereHas('pengukuran_mutu',
                    function ($query) use ($yesterday) {
                        $query->where('tanggal_input', $yesterday);
                    })->exists()
                    &&
                    // jika data indikator mutu hari ini belum diisi maka update nilai kolom status menjadi 0
                    !IndikatorMutu::with('pengukuran_mutu')->where('status',
                        1)->where('unit_id',
                            $user_data->unit->id)->whereHas('pengukuran_mutu',
                            function ($query) use ($today) {
                                $query->where('tanggal_input', $today);
                            })->exists()
        ) {
            // update semua kolom status menjadi 0
            IndikatorMutu::where('unit_id', $user_data->unit->id)->update([
                'status' => 0,
            ]);
        }

        return view(
            'app.indikator-index-page',
            compact(['indikator_mutu', 'user_data', 'today'])
        );
    }

    /**
     * Menampilkan view untuk form membuat input baru
     */
    public function create()
    {
        $data_unit = auth()->user()->unit;
        return view('app.indikator-create-page', compact('data_unit'));
    }

    /**
     * Menyimpan data indikator mutu yang baru ke database
     */
    public function store(StoreIndikatorMutuRequest $request)
    {
        if (IndikatorMutu::create($request->validated())) {
            Alert::success(
                'Berhasil',
                'Data Indikator Mutu Berhasil Ditambahkan'
            );
        } else {
            Alert::error('Gagal', 'Data Indikator Mutu Gagal Ditambahkan');
        }

        return redirect()->route('indikator-mutu.index');
    }

    /**
     * Menampilkan view untuk form penyajian data rekap harian
     */
    public function showRekap()
    {
        $data_indikator = auth()->user()->unit->indikator_mutu;
        return view('app.indikator-rekap-page', compact('data_indikator'));
    }

    /**
     * Mengembalikan data hasil rekap
     */
    public function getRekap(Request $request)
    {
        $bulan = $request->input('bulan');
        $indikator_mutu_id = $request->input('indikator_mutu_id');
        $rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%{$bulan}%")
            ->where('indikator_mutu_id', '=', $indikator_mutu_id)
            ->get();
        $avg = $rekap->avg('prosentase');

        // Memasukkan nilai average perbulan ke database
        $this->insertAveragePerbulan($indikator_mutu_id, $bulan, $avg);

        $indikator_mutu = IndikatorMutu::find($indikator_mutu_id);

        return view(
            'app.indikator-rekap-page',
            compact(['rekap', 'indikator_mutu', 'bulan', 'avg'])
        );
    }

    /**
     * Insert data rata-rata prosentase perbulan
     */
    private function insertAveragePerbulan(
        $indikator_mutu_id,
        $bulan,
        $avgValue
    ) {
        if (
            AveragePerbulan::where('indikator_mutu_id', $indikator_mutu_id)
                ->where('tanggal', $bulan)
                ->exists()
        ) {
            AveragePerbulan::where('indikator_mutu_id', $indikator_mutu_id)
                ->where('tanggal', $bulan)
                ->update([
                    'avg_value' => $avgValue,
                ]);
        } else {
            AveragePerbulan::create([
                'indikator_mutu_id' => $indikator_mutu_id,
                'tanggal' => $bulan,
                'avg_value' => $avgValue,
            ]);
        }
    }

    /**
     * Menampilkan grafik rekap data selama setahun
     */
    public function showChart($indikator_id, $tanggal)
    {
        // pisah antara tahun dan bulan pada vaiabel $tanggal
        $tanggal = substr($tanggal, 0, 4);

        // Memasukkan data dari eloquent AveragePerbulan ke dalam array
        $nama_indikator = IndikatorMutu::find($indikator_id)->nama_indikator;
        $dataAvgPerbulan = [];
        $tahun = [];
        $query = AveragePerbulan::where('indikator_mutu_id', $indikator_id)
            ->where('tanggal', 'like', "{$tanggal}-%")
            ->get();
        foreach ($query as $data) {
            $dataAvgPerbulan[] = $data->avg_value;
            $tahun[] = $data->tanggal;
        }

        $chart = LarapexChart::lineChart()
            ->setTitle($nama_indikator)
            ->setSubtitle('Tahun ' . $tanggal)
            ->addData('Prosentase rata-rata', $dataAvgPerbulan)
            ->setXAxis($tahun)
            ->setStroke(3)
            ->setGrid(true);

        return view('app.indikator-grafik-page', compact('chart'));
    }

    /**
     * Eksport data rekap ke dalam bentuk PDF
     */
    public function exportPDF($indikator_mutu_id, $bulan)
    {
        $indikator_mutu = IndikatorMutu::find($indikator_mutu_id);
        $nama_unit = auth()
            ->user()
            ->unit->where('id', $indikator_mutu->unit_id)
            ->first()->nama_unit;
        $data_rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%$bulan%")
            ->where('indikator_mutu_id', $indikator_mutu_id)
            ->get();
        $avg = $data_rekap->avg('prosentase');

        $pdf = Pdf::loadView(
            'app.indikator-rekap-pdf-page',
            compact([
                'data_rekap',
                'indikator_mutu',
                'avg',
                'bulan',
                'nama_unit',
            ])
        )->setPaper('a4', 'potrait');
        return $pdf->stream('rekap-indikator-mutu.pdf');

        // return view('app.indikator-rekap-pdf-page', compact(['data_rekap', 'indikator_mutu','avg','bulan','nama_unit']));
    }
}
