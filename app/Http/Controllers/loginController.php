<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Http\RedirectResponse; // Use RedirectResponse Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\Session; // Use Session Method by Laravel

class loginController extends Controller
{
    // Login Page Controller
    public function loginPage() {
        return view('/login', [
            'pageName' => "Login | "
        ]);
    }

    // Authentication Controller, Login Logic Handler
    public function authenticate(Request $request): RedirectResponse {
        // Validation Rules
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ],
        
        // Validation Error messages
        [
            'username.required' => 'Kolom ini harus diisi',
            'password.required' => 'Kolom ini harus diisi',
        ]);

        // Authentication Logic
        if (Auth::attempt($credentials)) {
            // Get the User data for this current user
            $user = Auth::user();
            // Get the User Role from the User data 
            $role = $user->role; 
          
            // Create a Session
            $request->session()->regenerate(); 
            // Generate a flash message via Toastr after login successful
            $request->session()->flash('success', 'Login Berhasil');
          
            // Redirect User to the designated dashboard. If their role is Admin, go to admin-index, if their role is Instructor, go to instructor-index, if their role is user(student), then go to user-index
            return redirect()->intended('/' . $role . '-index');
        }

        // If authentication failed, return this error message
        return back()->withErrors([
            'username' => 'Periksa kembali username anda',
            'password' => 'Periksa kembali password anda',
        ])->onlyInput('username'); // Give the value of the username input field back, but leave the password input blank
    }

    // Logout Logic Handler
    public function logout() {
        // $message = 'Logout Berhasil!';

        // Calls logout method from Auth by Laravels
        Auth::logout();
        // Invalidate current users session
        request()->session()->invalidate();
        // Generate new token to make it impossible, even if users tried to go back using the back button of the browser
        request()->session()->regenerateToken();

        // Redirect to landing page
        return redirect('/');
    }

    // Register Page Controller
    public function registerPage() {
        return view('/register', [
            'pageName' => "Daftar Akun | "
        ]);
    }

    // Register Logic
    public function registerAccount(Request $request): RedirectResponse {
        // Validation Rules
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
            'age' => 'required|integer|between:18,70',
            'phone_number' => 'required|max:20',
            'username' => 'required|max:255|unique:users,username,',
            'password' => 'required|min:5|max:255|confirmed',
            'password_confirmation' => 'required|min:5|max:255',
        ],

        // Validation Error messages
        [
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'age.required' => 'Kolom ini harus diisi',
            'age.integer' => 'Masukkan angka yang valid',
            'age.between' => 'Usia Minimal 18 Tahun dan Maksimal 70 Tahun',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Kolom ini harus diisi',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.required' => 'Kolom ini harus diisi',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        // Format phone number to +62
        $validatedData['phone_number'] = preg_replace('/^(0|62)/', '+62', $validatedData['phone_number']);

        // Create User
        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'age' => $validatedData['age'],
            'phone_number' => $validatedData['phone_number'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'user', // Set default role
        ]);

        // Authenticate User
        Auth::login($user);
        // Redirect to user index
        return redirect('/user-index')->with('success', 'Registrasi Berhasil, Selamat Datang di Kemudi!');
    }
}