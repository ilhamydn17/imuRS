<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndikatorMutu;

class AveragePerbulan extends Model
{
    use HasFactory;
    public $table = 'average_perbulan';
    protected $guarded = ['id'];

    public function indikator_mutu(){
        return $this->belongsTo(IndikatorMutu::class);
    }

}
