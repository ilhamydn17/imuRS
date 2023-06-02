<?php

namespace App\Http\Controllers;

use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use App\Http\Requests\StorePengukuranMutuRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PengukuranMutuController extends Controller
{

    /**
     * Displays the view for daily input form
     *
     * @param int $id The id of the indikator_mutu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inputHarian($id)
    {

        // Get today's date
        $today = Carbon::now()->format('Y-m-d');

        // Find the current indikatorMutu for the authenticated user's unit
        $currentIndikatorMutu = auth()->user()->unit->indikator_mutu->find($id);

         // Check if input has already been done for today's date and the given indikator_mutu
        if(PengukuranMutu::where('tanggal_input',$today)->where('indikator_mutu_id',$id)->exists()){
            Alert::error('Gagal', 'Input Harian Sudah Dilakukan');
            return redirect()->back();
        }

        // Display the daily input page with the current indikator mutu
        return view('app.pengukuranMutu-input-page', compact('currentIndikatorMutu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengukuranMutuRequest $request)
    {
        // Get the numerator value from the request
        $numerator = $request->input('numerator');

        // Get the denumerator value from the request
        $denumerator = $request->input('denumerator');

        // Validate the numerator and denumerator
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

        // Update the status column in the indikator mutu table to 1
        IndikatorMutu::where('id', $request->indikator_mutu_id)->update([
            'status' => 1,
        ]);

        // Display a success message and return to the indikator mutu index page
        Alert::success('Berhasil', 'Input Berhasil Ditambahkan');
        return redirect()->route('indikator-mutu.index');
    }

}
