<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $data = DB::table('users')->where('id', $user_id)->get();

        return view('profile.index', compact('data'), [
            'title' => 'Profile'
        ]);
    }

    public function changepassword(Request $request)
    {
        // dd($request);
        $id = $request->idUser;

        $request->validate([
            'oldPassword' => 'required|string',
            'newPassword' => 'required|string',
            'confirmPassword' => 'required|string'
        ]);

        $auth = DB::table('users')->find($id);

        $newPassword = preg_replace("/[^a-zA-Z0-9]/", "", $request->newPassword);
        $confirmPassword = preg_replace("/[^a-zA-Z0-9]/", "", $request->confirmPassword);

        $data = strlen($newPassword);
        $data2 = strlen($confirmPassword);

        if ($data < 6 && $data2 < 6) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'info' => 'Password harus berisi minimal 6 karakter'
                ]);
        }

        // The passwords matches
        if (!Hash::check($request->get('oldPassword'), $auth->password)) {;
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'info' => 'Password Lama Tidak Benar'
                ]);
        }

        // Current password and new password same
        if (strcmp($request->get('oldPassword'), $request->newPassword) == 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'info' => 'Password baru sama dengan password lama'
                ]);
        }

        if ($request->newPassword != $request->confirmPassword) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'info' => 'Password baru dan konfirmasi password tidak sama'
                ]);
        }

        $user =  User::find($auth->id);
        $user->password =  Hash::make($request->newPassword);
        $output = $user->save();
        if ($output == true) {
            return redirect()->route('profile')->with(['message' => 'Anda Berhasil Memperbarui Password']);
        } else {
            return redirect()->back()->withInput()->with(['error' => 'Anda Gagal Memperbarui Password']);
        }
    }
}
