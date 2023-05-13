<?php

namespace App\Models;

use App\Models\IndikatorMutu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AverageBulan extends Model
{
    use HasFactory;

    protected $table = "avg_bulan";

    protected $dates = ['tanggal'];

    protected $fillable = ['tanggal', 'avgBulan'];

    public $timestamps = false;

    public function indikator_mutu(){
        return $this->belongsTo(IndikatorMutu::class);
    }

}
