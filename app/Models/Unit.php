<?php

namespace App\Models;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\IndikatorMutu;

class Unit extends Model
{
    // HasUuids
    use HasFactory;

   protected $fillable=[
        'user_id',
        'code_identity',
        'nama_unit',
    ];

    public $table = "unit";

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function indikator_mutu()
    {
        return $this->hasMany(IndikatorMutu::class);
    }
}
