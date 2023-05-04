<?php

namespace App\Http\Controllers;

use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePengukuranMutuRequest;
use App\Http\Requests\UpdatePengukuranMutuRequest;

class PengukuranMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       // get data from PengukuranMutu model
       $datas = DB::table('pengukuran_mutu')->where('indikator_mutu_id', 1)->whereMonth('tanggal_input', 5)->get();
       $labels = [];
       $data = [];
       foreach ($datas as $item) {
           $labels[] = $item->tanggal_input;
           $data[] = $item->prosentase;
       }
       return view('app.monitoring-page',compact('labels','data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $cur_indikator = IndikatorMutu::find($id);
        return view('app.input-page');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengukuranMutuRequest $request)
    {
        //get value of numerator from request
        $numerator = $request->input('numerator');
        //get value of denumerator from request
        $denumerator = $request->input('denumerator');

        // return error if denumerator smaller than numerator
        if ($denumerator < $numerator) {
            return redirect()->route('indikator-menu.index')->with('error', 'Data Gagal Diinput! periksa kembali inputan');
        }

        // count the percentage from numerator and denumerator
        $percentage = $numerator / $denumerator * 100;
        // set the value of percentage to request
        $request->merge(['prosentase' => $percentage]);
        // store all data to database in tabel PengukuranMutu
        PengukuranMutu::create($request->all());

        return redirect()->route('indikator-menu.index')->with('success', 'Data Berhasil Diinput!');;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cur_indikator = IndikatorMutu::find($id);
        // check if data already inputted and date is today
        if( $cur_indikator->pengukuran_mutu->count() > 0 && $cur_indikator->pengukuran_mutu->last()->tanggal_input == now()->format('Y-m-d')) return back()->with('error', 'Data telah diinput');
        return view('app.input-page', compact('cur_indikator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengukuranMutu $pengukuranMutu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePengukuranMutuRequest $request, PengukuranMutu $pengukuranMutu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengukuranMutu $pengukuranMutu)
    {
        //
    }
}
