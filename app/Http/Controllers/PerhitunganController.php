<?php

namespace App\Http\Controllers;

use App\Models\Perhitungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        // $data_cluster = DB::table('cluster')->get();
        // $data_variabel = DB::table('variabel')->get();
        // // $umkm = DB::table('umkm')->select('nama_umkm, norma_omset, norma_asset')->get();
        // $umkm = DB::select('select nama_umkm, norma_omset, norma_asset from umkm');;

        // $data = [
        //     ['nama_umkm' => 'Kutemo Store', 2, 3],
        //     ['nama_umkm' => 'Bunga Surga', 1, 1],
        //     ['nama_umkm' => 'Thai Dap', 1, 2],
        //     ['nama_umkm' => 'Yoguri', 2, 3],
        //     ['nama_umkm' => 'Rollade dan Galantin KITA', 1, 2],
        //     ['nama_umkm' => 'Tanesia Food / Ratumeal', 1, 2],
        //     ['nama_umkm' => 'Kios Bu Endang', 1, 2],
        //     ['nama_umkm' => 'Ayam geprek DARA Bumijo', 1, 1],
        //     ['nama_umkm' => 'BAKPIA POTRET DJOKDJA', 2, 3],
        //     ['nama_umkm' => 'KING Bedsheet dan Bedcover', 1, 2],
        //     ['nama_umkm' => 'PURNAMA PUTRA GROUP', 1, 2]
        // ];
        // // dd($data);

        // return view('data_kmeans.index', compact('data'), [
        //     'title' => 'Penilaian Kmeans',
        //     'clusters' => $data_cluster,
        //     'variabel' => $data_variabel,
        // ])->with('i');

        $data_cluster = DB::table('cluster')->get();
        $data_variabel = DB::table('variabel')->get();
        $umkm = DB::select('select nama_umkm, norma_omset, norma_asset from umkm');

        $data = [];
        for ($i = 0; $i < count($umkm); $i++) {
            $data[] = ['nama_umkm' => $umkm[$i]->nama_umkm, $umkm[$i]->norma_omset, $umkm[$i]->norma_asset];
        }

        return view('data_kmeans.index', compact('data'), [
            'title' => 'Penilaian Kmeans',
            'clusters' => $data_cluster,
            'variabel' => $data_variabel,
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
