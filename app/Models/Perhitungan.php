<?php

namespace App\Models;

use App\Models\Centroid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perhitungan extends Model
{
    use HasFactory;

    protected $table = "perhitungan";
    protected $guarded = [];

    protected $fillable = [
        'nilai_mikro',
        'nilai_kecil',
        'nilai_menengah',
        'nilai_jarak',
    ];

    public function post()
    {
        return $this->belongsTo(Centroid::class);
    }
}
