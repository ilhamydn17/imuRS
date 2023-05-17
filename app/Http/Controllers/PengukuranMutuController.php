<?php

namespace App\Http\Controllers;

use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePengukuranMutuRequest;
use RealRashid\SweetAlert\Facades\Alert;

class PengukuranMutuController extends Controller
{

    /**
     * Menampilkan view untuk form input harian
     */
    public function inputHarian($id)
    {
        $cur_indikator = auth()->user()->unit->indikator_mutu->find($id);
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

        // Mengembalikan ke halaman sebelumnya jika nilai numerator lebih besar dari nilai denumerator
        if ($denumerator < $numerator){
            Alert::error('Gagal', 'Numerator lebih besar dari Denumerator');
            return redirect()->route('indikator-mutu.index');
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
