<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\IndikatorMutu;
use App\Http\Requests\StoreIndikatorMutuRequest;
use App\Http\Requests\UpdateIndikatorMutuRequest;
use App\Models\AverageBulan;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class IndikatorMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mendapatkan data user yang telah berhasil login
        if (auth()->check()) {
            $user_data = auth()->user();
        }
        // mengambil data indikator_mutu(bersifat many) dari unit(relasi dengan user) yang telah login
        $indikator_mutu = $user_data->unit->indikator_mutu()->paginate(5);
        // get units data after login and pass to vieww
        return view(
            'app.indikator-page',
            compact(['indikator_mutu', 'user_data'])
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_unit = Unit::all();
        return view('app.create-indikator', compact('data_unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndikatorMutuRequest $request)
    {
        IndikatorMutu::create($request->validated());
        return redirect()
            ->route('indikator-menu.index')
            ->with('success', 'Indikator Mutu berhasil ditambahkan');
    }

    public function showChart()
    {

        $avgBulan = [];
        foreach (AverageBulan::all() as $avg) {
            $avgBulan[] = $avg->avgBulan;
        }

        $tanggal = [];
        foreach (AverageBulan::all() as $tgl) {
            $tanggal[] = $tgl->tanggal;
        }

        $chart = LarapexChart::lineChart()
            ->setTitle('Rata-rata Tahun 2023')
            ->setSubtitle('TES SUBTITLE')
            ->addData('Prosentase', $avgBulan)
            ->setXAxis($tanggal)
            ->setGrid(true);

        return view('app.monitoring-page', compact('chart'));
    }


}
