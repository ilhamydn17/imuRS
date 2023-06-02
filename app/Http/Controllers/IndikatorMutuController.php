<?php

namespace App\Http\Controllers;

use App\Exports\IndikatorMutuExport;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use App\Models\AveragePerbulan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
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
        // Mengambil data user yang telah login
        $user_data = auth()->user();

        // Mengambil data indikator_mutu (bersifat many) dari unit(relasi dengan user) yang telah login
        $indikator_mutu = IndikatorMutu::where(
            'unit_id',
            $user_data->unit->id
        )->paginate(5);

        // Mengambil tanggal hari ini
        $today = now()->toDatestring();

        // Mengambiil tanggal hari kemarin
        $yesterday = now()->subDays()->toDateString();

        // Apakah input kemarin telah dilakukan (status = 1) atau belum (status = 0) dengan menghitung jumlah data yang ada
        $cekInputKemarin =  IndikatorMutu::where('status',1)
        ->where('unit_id', $user_data->unit->id)
        ->whereHas('pengukuran_mutu',function ($query) use ($yesterday){$query->whereDate('tanggal_input', $yesterday);})->count();

        // Apakah input hari ini telah dilakukan (status = 1) atau belum (status = 0) dengan menghitung jumlah data yang ada
        $cekInputHariIni = IndikatorMutu::with('pengukuran_mutu')
        ->where('status',1)
        ->where('unit_id',$user_data->unit->id)
        ->whereHas('pengukuran_mutu',function ($query) use ($today) {$query->whereDate('tanggal_input', $today);})->count();

        // Melakukan pengecekan untuk mengupdate nilai kolom status pada tabel indikator_mutu
        if ($cekInputKemarin > 0 && $cekInputHariIni == 0) {
            IndikatorMutu::where('unit_id', $user_data->unit->id)->update([
                'status' => 0,
            ]);
        }

        return view('app.indikator-index-page',compact(['indikator_mutu', 'user_data', 'today']));
    }

    /**
     * Menampilkan view untuk form membuat input baru
     */
    public function create()
    {
        // Mengambil data unit
        $data_unit = auth()->user()->unit;

        // Mengembalikan view untuk form input data yang baru
        return view('app.indikator-create-page', compact('data_unit'));
    }

    /**
     * Menyimpan data indikator mutu yang baru ke database
     */
    public function store(StoreIndikatorMutuRequest $request)
    {
        // Jika data gagal disimpan, maka akan muncul alert error
        if (!IndikatorMutu::create($request->validated())) {
            Alert::error('Gagal', 'Data Indikator Mutu Gagal Ditambahkan');
        }

        // Jika data berhasil disimpan, maka akan muncul alert success
        Alert::success(
            'Berhasil',
            'Data Indikator Mutu Berhasil Ditambahkan'
        );
        return redirect()->route('indikator-mutu.index');
    }

    /**
     * Menampilkan view untuk form penyajian data rekap harian
     */
    public function showRekap()
    {
        // Mengembalikan view untuk form penyajian data rekap harian
        $data_indikator = auth()->user()->unit->indikator_mutu;
        return view('app.indikator-rekap-page', compact('data_indikator'));
    }

    /**
     * Mengembalikan data hasil rekap
     */
    public function getRekap(Request $request)
    {
        // Mengambil data bulan dari request
        $bulan = $request->input('bulan');

        // Mengambil data indikator_mutu_id dari request
        $indikator_mutu_id = $request->input('indikator_mutu_id');

        // Mengambil data rekap berdasarkan bulan dan indikator_mutu_id
        $rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%{$bulan}%")
            ->where('indikator_mutu_id', '=', $indikator_mutu_id)
            ->orderBy('tanggal_input')->get();
        $avg = $rekap->avg('prosentase');

        // Memasukkan nilai average perbulan ke database
        $this->insertOrUpdateAveragePerbulan($indikator_mutu_id, $bulan, $avg);

        // Mengambil data indikator_mutu berdasarkan indikator_mutu_id
        $indikator_mutu = IndikatorMutu::find($indikator_mutu_id);

        return view('app.indikator-rekap-page', compact(['rekap', 'indikator_mutu', 'bulan', 'avg']));
    }

    /**
     * Insert or update data for rata-rata prosentase perbulan.
     *
     * @param int $indikator_mutu_id The ID of the indikator_mutu.
     * @param string $bulan The month/year string in format 'YYYY-MM'.
     * @param float $avg_value The average value to be inserted or updated.
     * @return void
     */
    private function insertOrUpdateAveragePerbulan($indikator_mutu_id, $bulan, $avg_value) {
        // Check if data for the given indikator_mutu_id and month/year exists.
        $existing_data = AveragePerbulan::where('indikator_mutu_id', $indikator_mutu_id)
                                        ->where('bulan', $bulan)
                                        ->first();
        if ($existing_data) {
            // If data exists, update the existing record with new average value.
            $existing_data->avg_value = $avg_value;
            $existing_data->save();
        } else {
            // If data does not exist, create a new record with the given values.
            AveragePerbulan::create([
                'indikator_mutu_id' => $indikator_mutu_id,
                'bulan' => $bulan,
                'avg_value' => $avg_value,
            ]);
        }
    }

    /**
     * Menampilkan grafik rekap data selama setahun
     */
    public function showChart($indikator_id, $tanggal)
    {
        // pisah antara tahun dan bulan pada vaiabel $tanggal
        $tahun = substr($tanggal, 0, 4);

        // Memasukkan data dari eloquent AveragePerbulan ke dalam array
        $nama_indikator = IndikatorMutu::find($indikator_id)->nama_indikator;
        $dataAvgPerbulan = [];
        $tahunList= [];
        $query = AveragePerbulan::where('indikator_mutu_id', $indikator_id)
            ->where('bulan', 'like', "{$tahun}-%")
            ->orderBy('bulan', 'asc')->get();
        foreach ($query as $data) {
            $dataAvgPerbulan[] = $data->avg_value;
            $tahunList[] = $data->bulan;
        }

        $chart = LarapexChart::lineChart()
            ->setTitle($nama_indikator)
            ->setSubtitle('Tahun ' . $tahun)
            ->addData('Prosentase', $dataAvgPerbulan)
            ->setXAxis($tahunList)
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

        $pdf = Pdf::loadView('app.indikator-rekap-pdf-page', compact(['data_rekap','indikator_mutu','avg','bulan','nama_unit',]))->setPaper('a4', 'potrait');

        return $pdf->stream('rekap-indikator-mutu.pdf');
    }

    public function exportExcel($id, $tanggal)
    {
        return Excel::download(new IndikatorMutuExport($id, $tanggal), 'Rekap_'.$tanggal.'.xlsx');
    }

}
