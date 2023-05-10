<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageBulan extends Model
{
    use HasFactory;

    protected $table = "avg_bulan";

    protected $dates = ['tanggal'];

    protected $fillable = ['tanggal', 'avg_perbulan'];
    public function getTanggalAtrribute($value)
    {
       return $this->attributes['tanggal']->format('Y-m');
    }
}
