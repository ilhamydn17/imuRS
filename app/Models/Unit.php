<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\IndikatorMutu;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_unit',
    ];

    public $table = "units";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function indikator_mutu()
    {
        return $this->hasMany(IndikatorMutu::class);
    }
}
