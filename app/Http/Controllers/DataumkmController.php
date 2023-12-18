<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DataumkmController extends Controller
{
    public function index()
    {
        $data = DB::table('locations')->where('is_active', 1)->get();

        return view('data_umkm.index', compact('data'), [
            'title' => 'Data UMKM'
        ])->with('i');
    }

    public function create()
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        // dd($locations);

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$location->long, $location->lat],
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

        return view('data_umkm.create', [
            'title' => 'Data UMKM',
            'geoJson' => $geoJson
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'longtitude' => 'required',
            'lattitude' => 'required',
            'nama_pemilik' => 'required',
            'no_hp' => 'required',
            'nama_usaha' => 'required',
            'kegiatan_usaha' => 'required',
            'klasifikasi_usaha' => 'required',
            'jenis_produk' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
        ]);

        $location = new Location();
        $location->longtitude = $request->input('longtitude');
        $location->lattitude = $request->input('lattitude');
        $location->nama_pemilik = $request->input('nama_pemilik');
        $location->no_hp = '62' . $request->input('no_hp');
        $location->nama_usaha = $request->input('nama_usaha');
        $location->kegiatan_usaha = $request->input('kegiatan_usaha');
        $location->klasifikasi_usaha = $request->input('klasifikasi_usaha');
        $location->jenis_produk = $request->input('jenis_produk');
        $location->alamat = $request->input('alamat');
        $location->kecamatan = $request->input('kecamatan');
        $location->save();

        return redirect()->route('data_umkm')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function detail(Request $request)
    {
        $data = DB::table('locations')->where('id', $request->id_location)->get();

        $customLocations = [];

        foreach ($data as $location) {
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

        return view('data_umkm.detail', [
            'title' => 'Data UMKM',
            'locations' => $data,
            'geoJson' => $geoJson
        ]);
    }

    public function delete(Request $request)
    {
        $id_location = $request->id_location;

        //delete
        // $data = DB::table('locations')->where('id', $id_location)->delete();

        //softdelete
        try {
            $data = DB::table('locations')->where('id', $id_location)->update(['is_active' => '0']);
            return redirect()->route('data_umkm')->with('message', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('data_umkm')->with('error', 'Data Gagal Dihapus');
        }
    }

    public function edit($id)
    {
        // dd($request);
        $data = DB::table('locations')->where('id', $id)->get();

        $customLocations = [];

        foreach ($data as $location) {
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

        return view('data_umkm.edit', [
            'title' => 'Data UMKM',
            'locations' => $data,
            'geoJson' => $geoJson
        ]);
    }

    public function update(Request $request)
    {
        // dd($request);
        // dd('berhasil masuk controleer');
        $id_location = $request->id_location;
        // dd($id_location);
        $request->validate([
            'longtitude' => 'required',
            'lattitude' => 'required',
            'nama_pemilik' => 'required',
            'no_hp' => 'required',
            'nama_usaha' => 'required',
            'kegiatan_usaha' => 'required',
            'klasifikasi_usaha' => 'required',
            'jenis_produk' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
        ]);

        $no_hp = '62' . $request->input('no_hp');

        try {
            $data = DB::table('locations')
                ->where('id', $id_location)
                ->update([
                    'longtitude' => $request->input('longtitude'),
                    'lattitude' => $request->input('lattitude'),
                    'nama_pemilik' => $request->input('nama_pemilik'),
                    'no_hp' => $no_hp,
                    'nama_usaha' => $request->input('nama_usaha'),
                    'kegiatan_usaha' => $request->input('kegiatan_usaha'),
                    'klasifikasi_usaha' => $request->input('klasifikasi_usaha'),
                    'jenis_produk' => $request->input('jenis_produk'),
                    'alamat' => $request->input('alamat'),
                    'kecamatan' => $request->input('kecamatan')
                ]);
            return redirect()->route('data_umkm')->with('message', 'Data Berhasil Diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('data_umkm')->with('error', 'Data Gagal Diperbarui');
        }
    }
}
