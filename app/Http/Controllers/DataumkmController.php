<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Imports\UmkmImport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataumkmController extends Controller
{
    public function index()
    {
        $data = DB::table('umkm')->where('is_active', 1)->get();

        return view('data_umkm.index', compact('data'), [
            'title' => 'Data UMKM'
        ])->with('i');
    }

    public function create()
    {
        $locations = Umkm::orderBy('created_at', 'desc')->get();

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
            'pemilik' => 'required',
            'nama_umkm' => 'required',
            'jenis_produk' => 'required',
            'no_hp' => 'required',
            'kecamatan' => 'required',
            'omset' => 'required',
            'asset' => 'required',
            'kegiatan_usaha' => 'required',
            'alamat' => 'required',
        ]);

        $omset = $request->input('omset');
        $asset = $request->input('asset');

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

        $umkm = new Umkm();
        $umkm->longtitude = $request->input('longtitude');
        $umkm->lattitude = $request->input('lattitude');
        $umkm->pemilik = $request->input('pemilik');
        $umkm->nama_umkm = $request->input('nama_umkm');
        $umkm->jenis_produk = $request->input('jenis_produk');
        $umkm->no_hp = '62' . $request->input('no_hp');
        $umkm->kecamatan = $request->input('kecamatan');
        $umkm->omset = $omset;
        $umkm->asset = $asset;
        $umkm->norma_omset = $norma_omset;
        $umkm->norma_asset = $norma_asset;
        $umkm->is_active = 1;
        $umkm->klasifikasi_usaha = NULL;
        $umkm->kegiatan_usaha = $request->input('kegiatan_usaha');
        $umkm->alamat = $request->input('alamat');
        $umkm->save();

        return redirect()->route('data_umkm')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function detail(Request $request)
    {
        $data = DB::table('umkm')->where('id', $request->id_umkm)->get();

        $customLocations = [];

        foreach ($data as $umkm) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$umkm->longtitude, $umkm->lattitude],
                    'type' => 'point'
                ],
                'properties' => [
                    'locationId' => $umkm->id,
                    'pemilik' => $umkm->pemilik,
                    'nama_umkm' => $umkm->nama_umkm,
                    'no_hp' => $umkm->no_hp,
                    'kegiatan_usaha' => $umkm->kegiatan_usaha,
                    'klasifikasi_usaha' => $umkm->klasifikasi_usaha,
                    'jenis_produk' => $umkm->jenis_produk,
                    'alamat' => $umkm->alamat,
                    'kecamatan' => $umkm->kecamatan,
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
            'umkms' => $data,
            'geoJson' => $geoJson
        ]);
    }

    public function delete(Request $request)
    {
        $id_umkm = $request->id_umkm;

        //delete
        // $data = DB::table('locations')->where('id', $id_umkm)->delete();

        //softdelete
        try {
            $data = DB::table('umkm')->where('id', $id_umkm)->update(['is_active' => '0']);
            return redirect()->route('data_umkm')->with('message', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('data_umkm')->with('error', 'Data Gagal Dihapus');
        }
    }

    public function edit($id)
    {
        $data = DB::table('umkm')->where('id', $id)->get();

        $customLocations = [];

        foreach ($data as $umkm) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$umkm->longtitude, $umkm->lattitude],
                    'type' => 'point'
                ],
                'properties' => [
                    'umkmId' => $umkm->id,
                    'pemilik' => $umkm->pemilik,
                    'nama_umkm' => $umkm->nama_umkm,
                    'no_hp' => $umkm->no_hp,
                    'kegiatan_usaha' => $umkm->kegiatan_usaha,
                    'klasifikasi_usaha' => $umkm->klasifikasi_usaha,
                    'jenis_produk' => $umkm->jenis_produk,
                    'alamat' => $umkm->alamat,
                    'kecamatan' => $umkm->kecamatan,
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
            'umkms' => $data,
            'geoJson' => $geoJson
        ]);
    }

    public function update(Request $request)
    {

        $id_umkm = $request->id_umkm;
        $request->validate([
            'longtitude' => 'required',
            'lattitude' => 'required',
            'pemilik' => 'required',
            'no_hp' => 'required',
            'nama_umkm' => 'required',
            'kegiatan_usaha' => 'required',
            'jenis_produk' => 'required',
            'omset' => 'required',
            'asset' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
        ]);

        $no_hp = $request->input('no_hp');

        $cut = substr($no_hp, 2);

        $use_noHp = '62' . $cut;

        $omset = $request->input('omset');
        $asset = $request->input('asset');

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

        try {
            $data = DB::table('umkm')
                ->where('id', $id_umkm)
                ->update([
                    'longtitude' => $request->input('longtitude'),
                    'lattitude' => $request->input('lattitude'),
                    'pemilik' => $request->input('pemilik'),
                    'no_hp' => $use_noHp,
                    'nama_umkm' => $request->input('nama_umkm'),
                    'kegiatan_usaha' => $request->input('kegiatan_usaha'),
                    'jenis_produk' => $request->input('jenis_produk'),
                    'alamat' => $request->input('alamat'),
                    'kecamatan' => $request->input('kecamatan'),
                    'omset' => $omset,
                    'asset' => $asset,
                    'norma_omset' => $norma_omset,
                    'norma_asset' => $norma_asset,

                ]);
            return redirect()->route('data_umkm')->with('message', 'Data Berhasil Diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('data_umkm')->with('error', 'Data Gagal Diperbarui');
        }
    }

    public function hasil()
    {
        $mikro = DB::table('umkm')->where('is_active', 1)->where('klasifikasi_usaha', 'like', '%Usaha Mikro%')->get();
        $kecil = DB::table('umkm')->where('is_active', 1)->where('klasifikasi_usaha', 'like', '%Usaha Kecil%')->get();
        $menengah = DB::table('umkm')->where('is_active', 1)->where('klasifikasi_usaha', 'like', '%Usaha Menengah%')->get();

        return view('data_umkm.hasil', [
            'title' => 'Laporan Hasil',
            'mikros' => $mikro,
            'kecils' => $kecil,
            'menengahs' => $menengah,
        ]);
    }

    public function import_excel(Request $request)
    {
        // validasi
        $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('admin_assets/file', $nama_file);

        try {
            // import data
            $file_location = public_path('/admin_assets/file/' . $nama_file);
            Excel::import(new UmkmImport, $file_location);
            return redirect()->route('data_umkm')->with('message', 'Data Umkm Berhasil Diimport!');
        } catch (\Throwable $th) {
            return redirect()->route('data_umkm')->with('error', 'Data Umkm Gagal Diimport!');
        }
    }
}
