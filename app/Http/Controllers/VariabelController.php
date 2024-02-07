<?php

namespace App\Http\Controllers;

use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariabelController extends Controller
{
    public function index()
    {
        $data = DB::table('variabel')->get();

        return view('data_variabel.index', compact('data'), [
            'title' => 'Variabel Penilaian'
        ])->with('i');
    }

    public function create()
    {

        return view('data_variabel.create', [
            'title' => 'Variabel Penilaian',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_variabel' => 'required',
        ]);

        $variabel = new Variabel();
        $variabel->nama_variabel = $request->input('nama_variabel');
        $variabel->save();

        return redirect()->route('data_variabel')->with('message', 'Data Berhasil Ditambahkan');
    }

    public function delete(Request $request)
    {
        $id_variabel = $request->id_variabel;

        //delete
        try {
            $data = DB::table('variabel')->where('id', $id_variabel)->delete();
            return redirect()->route('data_variabel')->with('message', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('data_variabel')->with('error', 'Data Gagal Dihapus');
        }

        //softdelete
        // try {
        //     $data = DB::table('cluster')->where('id', $id_variabel)->update(['is_active' => '0']);
        //     return redirect()->route('data_umkm')->with('message', 'Data Berhasil Dihapus');
        // } catch (\Throwable $th) {
        //     return redirect()->route('data_umkm')->with('error', 'Data Gagal Dihapus');
        // }
    }

    public function edit($id)
    {
        $data = DB::table('variabel')->where('id', $id)->get();

        return view('data_variabel.edit', [
            'title' => 'Variabel Penilaian',
            'variabels' => $data,
        ]);
    }

    public function update(Request $request)
    {
        $id_variabel = $request->id_variabel;
        $request->validate([
            'nama_variabel' => 'required',
        ]);

        try {
            $data = DB::table('variabel')
                ->where('id', $id_variabel)
                ->update([
                    'nama_variabel' => $request->input('nama_variabel'),
                ]);
            return redirect()->route('data_variabel')->with('message', 'Data Berhasil Diperbarui');
        } catch (\Throwable $th) {
            return redirect()->route('data_variabel')->with('error', 'Data Gagal Diperbarui');
        }
    }
}
