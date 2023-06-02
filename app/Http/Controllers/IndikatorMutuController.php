<?php

namespace App\Http\Controllers;

use App\Exports\IndikatorMutuExport;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use App\Models\AveragePerbulan;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreIndikatorMutuRequest;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class IndikatorMutuController extends Controller
{
   /**
     * Display the first page after a user logs in
     */
    public function index()
    {
        // Get the authenticated user's data
        $userData = auth()->user();

        // Get the ID of the unit the user belongs to
        $unitId = $userData->unit->id;

        // Get a paginated list of quality indicators for the unit
        $indikatorMutu = IndikatorMutu::where('unit_id', $unitId)->paginate(5);

        // Get today's date and yesterday's date
        $today = now()->toDateString();
        $yesterday = now()->subDays()->toDateString();

        // Check if there were any quality measurements entered yesterday
        $cekInputKemarin = IndikatorMutu::where('status', 1)
                                        ->where('unit_id', $unitId)
                                        ->whereHas('pengukuran_mutu', function ($query) use ($yesterday) {
                                            $query->whereDate('tanggal_input', $yesterday);
                                        })->count();

        // Check if there are any quality measurements entered today
        $cekInputHariIni = IndikatorMutu::with('pengukuran_mutu')
                                        ->where('status', 1)
                                        ->where('unit_id', $unitId)
                                        ->whereHas('pengukuran_mutu', function ($query) use ($today) {
                                            $query->whereDate('tanggal_input', $today);
                                        })->count();

        // If there were quality measurements entered yesterday but none today, update the status of the quality indicators for the unit
        if ($cekInputKemarin > 0 && $cekInputHariIni == 0) {
            IndikatorMutu::where('unit_id', $unitId)->update([
                'status' => 0,
            ]);
        }

        // Return the view for the quality indicators index page, along with the data needed to display it
        return view('app.indikator-index-page', compact('indikatorMutu', 'userData', 'today'));
    }



    /**
     * Display the view for creating a new input.
     */
    public function create()
    {
        // Get the unit data.
        $unitData = auth()->user()->unit;

        // Return the view for creating a new input.
        return view('app.indikator-create-page', compact('unitData'));
    }


   /**
     * Stores new quality indicator data to the database.
     *
     * @param StoreIndikatorMutuRequest $request The incoming request.
     * @return \Illuminate\Http\RedirectResponse The redirect response.
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
     * Display the view for the daily summary data form.
     */
    public function showRekap()
    {
        // Mengembalikan view untuk form penyajian data rekap harian
        $dataIndikator = auth()->user()->unit->indikator_mutu;
        return view('app.indikator-rekap-page', compact('dataIndikator'));
    }

    /**
     * Returns the summary data of the metrics.
     *
     * @param  Request  $request  The request object.
     * @return \Illuminate\View\View
     */
    public function getRekap(Request $request)
    {
        // Get the month data from the request.
        $bulan = $request->input('bulan');

        // Get the indikator_mutu_id data from the request.
        $indikatorMutu_id = $request->input('indikator_mutu_id');

        // Get the rekap data based on the month and indikator_mutu_id.
        $rekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%{$bulan}%")
            ->where('indikator_mutu_id', '=', $indikatorMutu_id)
            ->orderBy('tanggal_input')->get();

        // Calculate the average of the percentage.
        $avg = $rekap->avg('prosentase');

        // Insert or update the average value per month to the database.
        $this->insertOrUpdateAveragePerbulan($indikatorMutu_id, $bulan, $avg);

        // Get the indikator_mutu data based on the indikator_mutu_id.
        $indikator_mutu = IndikatorMutu::find($indikatorMutu_id);

        // Return the view with the rekap, indikator_mutu, month, and average data.
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
        $existingData = AveragePerbulan::where('indikator_mutu_id', $indikator_mutu_id)
                                        ->where('bulan', $bulan)
                                        ->first();
        if ($existingData) {
            // If data exists, update the existing record with new average value.
            $existingData->avg_value = $avg_value;
            $existingData->save();
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
     * Displays a chart summarizing data for a year.
     *
     * @param int $indikator_id The ID of the indicator to display.
     * @param string $tanggal The date to display, in 'YYYY-MM' format.
     * @return \Illuminate\Contracts\View\View The view containing the chart.
     */
    public function showChart($indikator_id, $tanggal)
    {
        // Extract the year and month from the $tanggal variable.
        $tahun = substr($tanggal, 0, 4);

        // Retrieve data from the AveragePerbulan Eloquent model and store it in an array.
        $namaIndikator = IndikatorMutu::find($indikator_id)->nama_indikator;
        $dataAvgPerbulan = [];
        $tahunList= [];
        $query = AveragePerbulan::where('indikator_mutu_id', $indikator_id)
            ->where('bulan', 'like', "{$tahun}-%")
            ->orderBy('bulan', 'asc')->get();
        foreach ($query as $data) {
            $dataAvgPerbulan[] = $data->avg_value;
            $tahunList[] = $data->bulan;
        }

        // Create a line chart using the LarapexChart library.
        $chart = LarapexChart::lineChart()
            ->setTitle($namaIndikator)
            ->setSubtitle('Tahun ' . $tahun)
            ->addData('Prosentase', $dataAvgPerbulan)
            ->setXAxis($tahunList)
            ->setStroke(3)
            ->setGrid(true);

        // Return the view containing the chart.
        return view('app.indikator-grafik-page', compact('chart'));
    }


    /**
     * Export the summary data to PDF format.
     *
     * @param int $indikator_mutu_id ID of the quality indicator
     * @param string $bulan Month in string format (e.g. "January")
     *
     * @return \Illuminate\Http\Response
     */
    public function exportPDF($indikator_mutu_id, $bulan)
    {
        // Get the quality indicator based on its ID
        $indikatorMutu_id = IndikatorMutu::find($indikator_mutu_id);

        // Get the name of the unit associated with the quality indicator
        $namaUnit = auth()
            ->user()
            ->unit->where('id', $indikatorMutu_id->unit_id)
            ->first()->nama_unit;

        // Get the quality measurements with the specified month and quality indicator ID
        $dataRekap = PengukuranMutu::with('indikator_mutu')
            ->where('tanggal_input', 'like', "%$bulan%")
            ->where('indikator_mutu_id', $indikator_mutu_id)
            ->get();

        // Calculate the average quality measurement percentage
        $avg = $dataRekap->avg('prosentase');

        // Generate a PDF using the data and view
        $pdf = Pdf::loadView('app.indikator-rekap-pdf-page', compact(['data_rekap','indikator_mutu','avg','bulan','nama_unit',]))->setPaper('a4', 'potrait');

        // Stream the PDF to the response
        return $pdf->stream('rekap-indikator-mutu.pdf');
    }

    /**
     * Export data to excel
     *
     * @param int $id The ID of the data to export
     * @param string $tanggal The date to use in the file name
     *
     */
    public function exportExcel($id, $tanggal)
    {
        // Download an Excel file with the exported data
        return Excel::download(new IndikatorMutuExport($id, $tanggal), 'Rekap_'.$tanggal.'.xlsx');
    }

}
