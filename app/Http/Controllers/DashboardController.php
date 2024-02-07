<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $data_umkm = DB::table('umkm')->where('is_active', 1)->get();
        $data_user = DB::table('users')->get();

        $locations = Umkm::orderBy('created_at', 'desc')->get();

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$location->longtitude, $location->lattitude],
                    'type' => 'point'
                ],
                'properties' => [
                    'locationId' => $location->id,
                    'pemilik' => $location->pemilik,
                    'nama_umkm' => $location->nama_umkm,
                    'no_hp' => $location->no_hp,
                    'kegiatan_usaha' => $location->kegiatan_usaha,
                    'klasifikasi_usaha' => $location->klasifikasi_usaha,
                    'jenis_produk' => $location->jenis_produk,
                    'alamat' => $location->alamat,
                    'kecamatan' => $location->kecamatan,
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();

        // dd(json_decode($geoJson));
        $geoArray = [];
        foreach ($locations as $locationarray) {
            $geoArray[] = [
                'locationId' => $locationarray->id,
                'pemilik' => $locationarray->pemilik,
                'nama_umkm' => $locationarray->nama_umkm,
                'no_hp' => $locationarray->no_hp,
                'kegiatan_usaha' => $locationarray->kegiatan_usaha,
                'klasifikasi_usaha' => $locationarray->klasifikasi_usaha,
                'jenis_produk' => $locationarray->jenis_produk,
                'alamat' => $locationarray->alamat,
                'kecamatan' => $locationarray->kecamatan,
                'coordinates' => [$locationarray->longtitude, $locationarray->lattitude],
                'type' => 'point'
            ];
        }

        return view('dashboard', [
            'title' => 'Dashboard',
            'total_umkm' => count($data_umkm),
            'total_user' => count($data_user),
            'geoJson' => $geoJson,
            'geoArray' => $geoArray
        ]);
    }
}
