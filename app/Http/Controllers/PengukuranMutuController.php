<?php

namespace App\Http\Controllers;

use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePengukuranMutuRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PengukuranMutuController extends Controller
{

    /**
     * Menampilkan view untuk form input harian
     */
    public function inputHarian($id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $cur_indikator = auth()->user()->unit->indikator_mutu->find($id);

        if(PengukuranMutu::where('tanggal_input',$today)->where('indikator_mutu_id',$id)->exists()){
            Alert::error('Gagal', 'Input Harian Sudah Dilakukan');
            return redirect()->back();
        }

        return view('app.pengukuranMutu-input-page', compact('cur_indikator'));
    }

    /**
     * Menyimpan data pengukuran mutu yang baru ke database
     */
    public function store(StorePengukuranMutuRequest $request)
    {
        // Mengambil nilai numerator dari request
        $numerator = $request->input('numerator');
        // Mengambil nilai demumerator dari request
        $denumerator = $request->input('denumerator');

        // validasi numerator dan denumerator
        if ($denumerator < $numerator){
            Alert::error('Gagal', 'Numerator lebih besar dari Denumerator');
            return redirect()->back();
        }else if(($numerator <= 0 && $denumerator <= 0) || ($numerator < 0 && $denumerator > 0)){
            Alert::error('Gagal', 'Pembagian dengan 0 tidak dapat dilakukan');
            return redirect()->back();
        }

        // count the percentage from numerator and denumerator
        $percentage = $numerator / $denumerator * 100;

        // set the value of percentage to request
        $request->merge(['prosentase' => $percentage]);
        // store all data to database in tabel PengukuranMutu
        PengukuranMutu::create($request->all());

        Alert::success('Berhasil', 'Input Berhasil Ditambahkan');
        return redirect()->route('indikator-mutu.index');
    }

}
