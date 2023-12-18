<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";
    protected $guarded = [];

    protected $fillable = [
        'nama_pemilik',
        'no_hp',
        'nama_usaha',
        'kegiatan_usaha',
        'jenis_produk',
        'alamat',
        'kecamatan',
        'long',
        'lat',
        'is_active'
    ];
    use HasFactory;
}
