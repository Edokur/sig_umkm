<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DatagisController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        // dd($locations);

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
                    'nama_pemilik' => $location->nama_pemilik,
                    'nama_usaha' => $location->nama_usaha,
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
                'nama_pemilik' => $locationarray->nama_pemilik,
                'nama_usaha' => $locationarray->nama_usaha,
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

        return view('data_gis.index', [
            'title' => 'UMKM GIS',
            'geoJson' => $geoJson,
            'geoArray' => $geoArray
        ]);
    }
}
