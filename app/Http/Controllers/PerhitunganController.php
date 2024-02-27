<?php

namespace App\Http\Controllers;

use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        $data_cluster = DB::table('cluster')->get();
        $data_variabel = DB::table('variabel')->get();
        $umkm1 = DB::select('select id, nama_umkm, norma_omset, norma_asset from umkm where norma_omset = 1 and norma_asset = 1 order by RAND() LIMIT 1');
        $umkm2 = DB::select('select id, nama_umkm, norma_omset, norma_asset from umkm where norma_omset = 1 and norma_asset = 2 order by RAND() LIMIT 1');
        $umkm3 = DB::select('select id, nama_umkm, norma_omset, norma_asset from umkm where norma_omset = 2 and norma_asset = 3 order by RAND() LIMIT 1');

        $umkm = DB::select('select nama_umkm, norma_omset, norma_asset from umkm order by RAND()');

        $v_umkm = DB::select('select nama_umkm, norma_omset, norma_asset from umkm WHERE id NOT IN (' . $umkm1[0]->id . ', ' . $umkm2[0]->id . ', ' . $umkm3[0]->id . ') order by RAND()');

        $data = [];
        for ($i = 0; $i < count($umkm); $i++) {
            $data[] = ['nama_umkm' => $umkm[$i]->nama_umkm, $umkm[$i]->norma_omset, $umkm[$i]->norma_asset];
        }

        return view('data_kmeans.index', compact('data'), [
            'title' => 'Penilaian Kmeans',
            'clusters' => $data_cluster,
            'variabel' => $data_variabel,
            'v_umkm1' => $umkm1,
            'v_umkm2' => $umkm2,
            'v_umkm3' => $umkm3,
            'v_umkm' => $v_umkm,
        ])->with('i');
    }

    public function store(Request $request)
    {
        for ($i = 0; $i < count($request['class1']); $i++) {
            if (!empty($request['class1'][$i])) {
                $mikro = DB::table('umkm')->where('nama_umkm', 'like', '%' . $request['class1'][$i] . '%')->get();
                try {
                    $data = DB::table('umkm')
                        ->where('id', $mikro[0]->id)
                        ->update([
                            'klasifikasi_usaha' => 'Usaha Mikro',
                        ]);
                    // return redirect()->route('hasil')->with('message', 'Data Berhasil Diperbarui');
                } catch (\Throwable $th) {
                    // return redirect()->route('hasil')->with('error', 'Data Gagal Diperbarui');
                }
            }

            if (!empty($request['class2'][$i])) {
                $kecil = DB::table('umkm')->where('nama_umkm', 'like', '%' . $request['class2'][$i] . '%')->get();
                try {
                    $data = DB::table('umkm')
                        ->where('id', $kecil[0]->id)
                        ->update([
                            'klasifikasi_usaha' => 'Usaha Kecil',
                        ]);
                    // return redirect()->route('hasil')->with('message', 'Data Berhasil Diperbarui');
                } catch (\Throwable $th) {
                    // return redirect()->route('hasil')->with('error', 'Data Gagal Diperbarui');
                }
            }

            if (!empty($request['class3'][$i])) {
                $menengah = DB::table('umkm')->where('nama_umkm', 'like', '%' . $request['class3'][$i] . '%')->get();
                try {
                    $data = DB::table('umkm')
                        ->where('id', $menengah[0]->id)
                        ->update([
                            'klasifikasi_usaha' => 'Usaha Menengah',
                        ]);
                    // return redirect()->route('hasil')->with('message', 'Data Berhasil Diperbarui');
                } catch (\Throwable $th) {
                    // return redirect()->route('hasil')->with('error', 'Data Gagal Diperbarui');
                }
            }
        }

        return redirect()->route('hasil')->with('message', 'Data Berhasil Disimpan');
    }
}
