<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\AverageBulan;
use Illuminate\Http\Request;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreIndikatorMutuRequest;
use App\Http\Requests\UpdateIndikatorMutuRequest;

class IndikatorMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mendapatkan data user yang telah berhasil login
         $user_data = auth()->user();
        // mengambil data indikator_mutu (bersifat many) dari unit(relasi dengan user) yang telah login
        $indikator_mutu = IndikatorMutu::with(['unit','pengukuran_mutu'])->where('unit_id',$user_data->unit->id)->paginate(5);
        // get units data after login and pass to view
        return view('app.indikator-index-page', compact(['indikator_mutu', 'user_data']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_unit = Unit::all();
        return view('app.indikator-create-page', compact('data_unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndikatorMutuRequest $request)
    {
        IndikatorMutu::create($request->validated());
        return redirect()->route('indikator-mutu.index')->with('success', 'Indikator Mutu berhasil ditambahkan');
    }

    /**
     * Rekapitulasi indikator mutu
     */
    public function showRekap(){
        $data_indikator = auth()->user()->unit->indikator_mutu;
        return view('app.indikator-rekap-page', compact('data_indikator'));
    }

    public function getRekap(Request $request){
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');
        $indikatorMutu = $request->input('indikator_mutu_id');
        $rekap = PengukuranMutu::where('tanggal_input', 'like', "%{$bulan}%")->where('indikator_mutu_id','=',$indikatorMutu)->get();
        $indikator_mutu = IndikatorMutu::find($indikatorMutu);
        return view('app.indikator-rekap-page', compact(['rekap', 'indikator_mutu']));

    }

    // public function runRekapBulanan(){
    //     $jumlahHari = Carbon::now()->subMonth()->daysInMonth;
    //     $bulan = Carbon::now()->subMonth()->month;
    //     $bulanTahun = Carbon::now()->subMonth()->format('Y-m');
    //     $avgLastRecord = AverageBulan::latest()->value('tanggal');
    //     // PENGECEKAN KONDISI TERLEBIH DAHULU SEBELUM MENGHITUNG RATA2 PERBULAN
    //     if(PengukuranMutu::whereMonth('tanggal_input', $bulan)->count() === $jumlahHari && $avgLastRecord != $bulanTahun) {
    //         // DERET BLOK YANG AKAN DIJALANKAN KETIKA TELAH MEMENUHI KONDISI
    //         $prosentaseHarian = PengukuranMutu::whereMonth('tanggal_input', $bulan)->get(['prosentase']);
    //         $avgBulan = $prosentaseHarian->avg('prosentase');
    //         AverageBulan::create([
    //             'tanggal'=> Carbon::now()->subMonth()->format('Y-m'),
    //             'avgBulan'=>$avgBulan
    //         ]);
    //     }
    // }

}
