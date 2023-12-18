<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $data_umkm = DB::table('locations')->where('is_active', 1)->get();
        $data_user = DB::table('users')->get();

        return view('dashboard', [
            'title' => 'Dashboard',
            'total_umkm' => count($data_umkm),
            'total_user' => count($data_user)
        ]);
    }
}
