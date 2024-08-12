<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Http\RedirectResponse; // Use RedirectResponse Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\Session; // Use Session Method by Laravel

class loginController extends Controller
{
    // Login Page Controller
    public function index() {
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
}