<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\AveragePerbulan;
use App\Models\PengukuranMutu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class IndikatorMutu extends Model
{
    // use HasUuids
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = "indikator_mutu";

    protected $timestamp = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pengukuran_mutu(){
        return $this->hasMany(PengukuranMutu::class);
    }

    public function average_bulan(){
        return $this->hasMany(AveragePerbulan::class);
    }


}
