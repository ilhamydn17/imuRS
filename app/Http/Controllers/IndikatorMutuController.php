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

        $today = Carbon::now()->format('Y-m-d');

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

        //insert average perbulan to database
        try {
            $this->insertAveragePerbulan($indikator_mutu_id, $bulan, $avg);
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Data Average Perbulan Gagal Ditambahkan');
        }

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
