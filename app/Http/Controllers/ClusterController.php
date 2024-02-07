<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClusterController extends Controller
{
    public function index()
    {
        $data = DB::table('cluster')->get();

        return view('data_cluster.index', compact('data'), [
            'title' => 'Data Cluster'
        ])->with('i');
    }

    public function create()
    {

        return view('data_cluster.create', [
            'title' => 'Data UMKM',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required',
        ]);

        $cluster = new Cluster();
        $cluster->nama_cluster = $request->input('nama_cluster');
        $cluster->save();

        return redirect()->route('data_cluster')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function delete(Request $request)
    {
        $id_cluster = $request->id_cluster;

        //delete
        try {
            $data = DB::table('cluster')->where('id', $id_cluster)->delete();
            return redirect()->route('data_cluster')->with('message', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('data_cluster')->with('error', 'Data Gagal Dihapus');
        }

        //softdelete
        // try {
        //     $data = DB::table('cluster')->where('id', $id_cluster)->update(['is_active' => '0']);
        //     return redirect()->route('data_umkm')->with('message', 'Data Berhasil Dihapus');
        // } catch (\Throwable $th) {
        //     return redirect()->route('data_umkm')->with('error', 'Data Gagal Dihapus');
        // }
    }

    public function edit($id)
    {
        // dd($request);
        $data = DB::table('cluster')->where('id', $id)->get();

        return view('data_cluster.edit', [
            'title' => 'Data Cluster',
            'clusters' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $id_cluster = $request->id_cluster;
        $request->validate([
            'nama_cluster' => 'required',
        ]);

        try {
            $data = DB::table('cluster')
                ->where('id', $id_cluster)
                ->update([
                    'nama_cluster' => $request->input('nama_cluster'),
                ]);
            return redirect()->route('data_cluster')->with('message', 'Data Berhasil Diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('data_cluster')->with('error', 'Data Gagal Diperbarui');
        }
    }
}
