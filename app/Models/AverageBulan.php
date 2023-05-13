<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageBulan extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $table = 'avg_bulan';

    protected $fillable = [
        'tanggal',
        'avgBulan'
    ];
}
