<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengukuranMutu extends Model
{
    // use HasUuids;
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'pengukuran_mutu';

    public function indikator_mutu()
    {
        return $this->belongsTo(IndikatorMutu::class);
    }


}
