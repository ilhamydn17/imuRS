<?php

namespace App\Jobs;

use App\Models\AverageBulan;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PengukuranMutu;
use Illuminate\Contracts\Queue\ShouldQueue;

class HitungProsentaseBulanan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(AverageBulan $avgBulan)
    {

    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Menghitung rata2 perbulan
        $jumlahHari = Carbon::now()->daysInMonth;
        $bulanIni = Carbon::now()->month;
        if(PengukuranMutu::whereMonth('tanggal_input', $bulanIni)->count() !== $jumlahHari) return;

        $prosentaseHarian = PengukuranMutu::whereMonth('tanggal_input', $bulanIni)->get(['prosentase']);
        $avgBulan = $prosentaseHarian->avg('prosentase');

        AverageBulan::create([
            'tanggal'=> Carbon::now()->subMonth()->format('Y-m'),
            'avg_perbulan'=>$avgBulan
        ]);
    }
}
