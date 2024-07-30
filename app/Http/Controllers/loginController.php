<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function index() {
        return view('/login', [
            'pageName' => "Login | "
        ]);
    }

    public function authenticate(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ],[
            'username.required' => 'Kolom ini harus diisi',
            'password.required' => 'Kolom ini harus diisi',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $role = $user->role;
          
            $request->session()->regenerate();
            $request->session()->flash('success', 'Login Berhasil');
          
            return redirect()->intended('/' . $role . '-index');
        }

        return back()->withErrors([
            'username' => 'Periksa kembali username anda',
            'password' => 'Periksa kembali password anda',
        ])->onlyInput('username');
    }

    public function logout() {
        // $message = 'Logout Berhasil!';
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}