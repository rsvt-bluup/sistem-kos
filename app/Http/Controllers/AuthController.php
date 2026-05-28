<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            session([
                'login' => true,
                'admin' => $admin->username
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->forget('login');
        session()->forget('admin');

        session()->flush();

        return redirect()->route('login');
    }
}
