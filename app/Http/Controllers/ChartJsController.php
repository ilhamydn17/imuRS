<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartJsController extends Controller
{
    public function index(){
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
}
