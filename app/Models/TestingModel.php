<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\UuidInterface;

class TestingModel extends Model
{
    use HasFactory;

    protected $fillable =['nama_data'];

    public $table = 'testing_models';
    public $timestamps = false;
    public $primaryKey = 'guid';

    protected $casts = ['guid', 'uuid'];



}
