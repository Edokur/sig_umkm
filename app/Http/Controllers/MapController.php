<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class MapController extends Controller
{

    public function index()
    {
        $locations = Umkm::orderBy('created_at', 'desc')->get();

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'filter' => [
                    'klasifikasiFilter' => 'null',
                    'kategoriFilter' => 'null',
                    'kecamatanFilter' => 'null'
                ],
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
                'longtitude' => $locationarray->longtitude,
                'lattitude' => $locationarray->lattitude,
                'coordinates' => [$locationarray->longtitude, $locationarray->lattitude],
                'type' => 'point'
            ];
        }

        return view(
            'guest.location',
            [
                'geoJson' => $geoJson,
                'geoArray' => $geoArray,
                'filter' => null
            ]
        );
    }

    public function loadallLocations()
    {
        $locations = Umkm::orderBy('created_at', 'desc')->get();

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'filter' => [
                    'klasifikasiFilter' => 'null',
                    'kategoriFilter' => 'null',
                    'kecamatanFilter' => 'null'
                ],
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
        return response()->json(['geoJson' => $geoJson]);
    }

    public function filterLocations(Request $request)
    {
        $kecamatanFilter = $request->input('kecamatanFilter');
        $klasifikasiFilter = $request->input('klasifikasi_usaha');
        $kategoriFilter = $request->input('kategori');
        $searchUmkm = $request->input('searchUmkm');

        // Lakukan logika penyaringan data sesuai dengan parameter yang diterima
        $query = Umkm::query();

        // Periksa apakah klasifikasi_usaha diisi atau tidak
        if ($klasifikasiFilter) {
            $query->where('klasifikasi_usaha', $klasifikasiFilter);
        }

        // Periksa apakah jenis_produk diisi atau tidak
        if ($kategoriFilter) {
            $query->where('jenis_produk', $kategoriFilter);
        }

        // Periksa apakah kecamatan diisi atau tidak
        if ($kecamatanFilter) {
            $query->where('kecamatan', $kecamatanFilter);
        }

        // Periksa apakah searchUmkm diisi atau tidak
        if ($searchUmkm) {
            $query->where('nama_umkm', 'like', '%' . $searchUmkm . '%');
        }

        // Ambil data yang sudah disaring
        $filteredData = $query->get();

        // Format data sebagai GeoJSON
        $customLocations = [];
        foreach ($filteredData as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'filter' => [
                    'klasifikasiFilter' => $klasifikasiFilter,
                    'kategoriFilter' => $kategoriFilter,
                    'kecamatanFilter' => $kecamatanFilter,
                    'searchUmkm' => $searchUmkm,
                ],
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
                ],

            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();

        return response()->json(['geoJsonFilter' => $geoJson]);
    }

    public function test()
    {
        return view(
            'guest.test'
        );
    }
}
