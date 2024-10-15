<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Http\RedirectResponse; // Use RedirectResponse Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\Session; // Use Session Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

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
            'identifier' => ['required'],
            'password' => ['required']
        ],
        
        // Validation Error messages
        [
            'identifier.required' => 'Kolom ini harus diisi',
            'password.required' => 'Kolom ini harus diisi',
        ]);

        // Check if the input is a valid phone number format
        if (preg_match('/^[0-9]{10,15}$/', $credentials['identifier'])) {
            // Normalize the phone number to start with +62
            $phone_number = preg_replace('/^(0|62)/', '+62', $credentials['identifier']);
            
            // If it's a phone number, attempt login using phone number
            $user = User::where('phone_number', $phone_number)->first();
        } else {
            // Otherwise, attempt login using the username
            $user = User::where('username', $credentials['identifier'])->first();
        }

        // If a user is found, attempt authentication
        if ($user && Auth::attempt(['username' => $user->username, 'password' => $credentials['password']])) {
            // Get the User data and role
            $role = $user->role;

            // Regenerate session and redirect
            $request->session()->regenerate();
            $request->session()->flash('success', 'Login Berhasil');
            return redirect()->intended('/' . $role . '-index');
        }

        // If authentication failed, return this error message
        return back()->withErrors([
            'identifier' => 'Periksa kembali username atau nomor WhatsApp anda',
            'password' => 'Periksa kembali password anda',
        ])->onlyInput('identifier'); // Give the value of the username input field back, but leave the password input blank
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
            'fp_question' => 'required|max:255',
            'fp_answer' => 'required|max:255',
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
            'fp_question.required' => 'Kolom ini harus diisi',
            'fp_question.max' => 'Pertanyaan Terlalu Panjang',
            'fp_answer.required' => 'Kolom ini harus diisi',
            'fp_answer.max' => 'Jawaban Terlalu Panjang',
        ]);

        // Format phone number to +62
        $validatedData['phone_number'] = preg_replace('/\D/', '', $validatedData['phone_number']);
        $validatedData['phone_number'] = preg_replace('/^(0|62)/', '+62', $validatedData['phone_number']);

        // Check if a duplicate phone number exists
        $duplicatePhoneNumber = User::where('phone_number', $validatedData['phone_number'])->exists();

        // If a duplicate is found
        if ($duplicatePhoneNumber) {
            return redirect()->back()->withErrors(['phone_number' => 'No. Whatsapp sudah terdaftar'])->onlyInput('fullname', 'age', 'username', 'fp_question', 'fp_answer');
        }

        // Create User
        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'age' => $validatedData['age'],
            'phone_number' => $validatedData['phone_number'],
            'username' => $validatedData['username'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'user', // Set default role
            'fp_question' => $validatedData['fp_question'],
            'fp_answer' => Crypt::encryptString($validatedData['fp_answer']),
        ]);

        // dd($user);

        // Authenticate User
        Auth::login($user);
        // Redirect to user index
        return redirect('/user-index')->with('success', 'Registrasi Berhasil, Selamat Datang di Kemudi!');
    }
}