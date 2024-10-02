<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\CourseInstructor; // Access Course Instructor Tables
use App\Models\Enrollment; // Access Enrollment Tables
use App\Models\PaymentMethod; // Access PaymentMethod Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class systemController extends Controller
{
    public function systemIndex() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Access User Tables
        $user = User::where('id', '!=', Auth::id())->get();

        // dd($user);

        return view('home.sysAdmin', [
            "pageName" => "Daftar Pengguna | ",
            "user" => $user,
        ]);
    }

    public function resetPassword(Request $request, $id) {
        // Validate the request if necessary
        $request->validate([
            'password' => 'required|min:5|max:255',
        ]);

        // dd($request);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->save();
    
        $request->session()->flash('success', 'Password berhasil diatur ulang!');
        // Redirect back with a success message
        return redirect('/sysAdmin-index');
    }

    public function accountPage() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        return view('sysadmin-page.sysadminaccount', [
            "pageName" => "Daftar Pengguna | ",
        ]);
    }
}
