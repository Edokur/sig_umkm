<?php

namespace App\Imports;

use App\Models\Umkm;
use App\Models\Cluster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class UmkmImport implements ToCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(Collection $rows)
    {

        $data = [];

        foreach ($rows as $row) {
            // dd($row);
            $omset = $row[6];
            $asset = $row[7];

            if ($omset > 0 && $omset <= 300000000) {
                $norma_omset = 1;
            } else if ($omset > 300000000 && $omset <= 2500000000) {
                $norma_omset = 2;
            } elseif ($omset > 2500000000 && $omset <= 50000000000) {
                $norma_omset = 3;
            }

            if ($asset > 0 && $asset <= 50000000) {
                $norma_asset = 1;
            } else if ($asset > 50000000 && $asset <= 500000000) {
                $norma_asset = 2;
            } elseif ($asset > 500000000 && $asset <= 10000000000) {
                $norma_asset = 3;
            }
            // dd($norma_asset, $norma_omset);
            $data[] = array(
                'longtitude' => $row[1],
                'lattitude' => $row[2],
                'nama_umkm' => $row[3],
                'pemilik' => $row[4],
                'jenis_produk' => $row[5],
                'omset' => $omset,
                'asset' => $asset,
                'no_hp' => $row[8],
                'kegiatan_usaha' => $row[9],
                'alamat' => $row[10],
                'kecamatan' => strtoupper($row[11]),
                'norma_omset' => $norma_omset,
                'norma_asset' => $norma_asset,
                'is_active' => 1,
                'klasifikasi_usaha' => Null,
            );
        }

        DB::table('umkm')->insert($data);
    }
}
