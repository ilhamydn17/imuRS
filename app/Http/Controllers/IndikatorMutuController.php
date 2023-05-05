<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\IndikatorMutu;
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
        // mengambil data indikator_mutu(bersifat many) dari unit(relasi dengan user) yang telah login
        $indikator_mutu = $user_data->unit->indikator_mutu()->paginate(5);
        // get units data after login and pass to vieww
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
}
