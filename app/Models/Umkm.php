<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = "umkm";
    protected $guarded = [];

    protected $fillable = [
        'nama_umkm',
        'pemilik',
        'jenis_produk',
        'omset',
        'asset',
        'no_hp',
        'is_active',
        'kegiatan_usaha',
        'alamat',
        'kecamatan',
        'longtitude',
        'lattitude',
        'norma_omset',
        'norma_asset'
    ];
}
