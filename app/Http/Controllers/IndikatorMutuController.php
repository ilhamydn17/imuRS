<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostGrafikRequest;
use Carbon\Carbon;
use App\Models\Unit;
use App\Models\AverageBulan;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreIndikatorMutuRequest;
use App\Http\Requests\UpdateIndikatorMutuRequest;
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
        $indikator_mutu = IndikatorMutu::with(['pengukuran_mutu'])->where('unit_id',$user_data->unit->id)->paginate(5);
        return view('app.indikator-index-page', compact(['indikator_mutu', 'user_data']));
    }

    /**
     * Menampilkan view untuk form membuat input baru
     */
    public function create()
    {
        $data_unit = Unit::all();
        return view('app.indikator-create-page', compact('data_unit'));
    }

    /**
     * Menyimpan data indikator mutu yang baru ke database
     */
    public function store(StoreIndikatorMutuRequest $request)
    {
        IndikatorMutu::create($request->validated());
        return redirect()->route('indikator-mutu.index')->with('success', 'Indikator Mutu berhasil ditambahkan');
    }

    /**
     * Menampilkan view untuk form pencarian data rekap harian
     */
    public function showRekap(){
        $data_indikator = auth()->user()->unit->indikator_mutu;
        return view('app.indikator-rekap-page', compact('data_indikator'));
    }

     /**
     * Mengembalikan data hasil rekap
     */
    public function getRekap(Request $request){
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');
        $indikatorMutu = $request->input('indikator_mutu_id');
        $rekap = PengukuranMutu::with('indikator_mutu')->where('tanggal_input', 'like', "%{$bulan}%")->where('indikator_mutu_id','=',$indikatorMutu)->get();
        $indikator_mutu = IndikatorMutu::find($indikatorMutu);
        return view('app.indikator-rekap-page', compact(['rekap', 'indikator_mutu']));
    }
}
