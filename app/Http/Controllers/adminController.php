<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class adminController extends Controller
{
    public function index() {
        $view = 'home.admin';
    
        return view($view, [
            "pageName" => "Beranda | ",
        ]);
    }

    public function profile() {
        return view('profile.admin-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    public function editProfile() {
        $paymentMethod = PaymentMethod::where('admin_id', auth()->id())->get();
        return view('profile.edit-admin-profile', [
            "pageName" => "Edit Profil | ",
            "paymentMethod" => $paymentMethod,
        ]);
    }

    public function editAccountInfo(Request $request) {
        $this->validate($request, [
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . Auth::id(),
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20',
            'availability' => 'required|boolean',
        ],[
            'hash_for_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'hash_for_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'description.max' => 'Deskripsi terlalu panjang',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
        ]);

        $user = User::find(Auth::id());
        $user->update($request->only(['fullname', 'username', 'description', 'phone_number', 'availability']));

        $fileName = null;
        if ($request->hasFile('hash_for_profile_picture')) {
            // Delete old pictures
            if ($user->hash_for_profile_picture && Storage::disk('public')->exists("profile_pictures/" . $user->hash_for_profile_picture)) {
                Storage::disk('public')->delete("profile_pictures/" . $user->hash_for_profile_picture);
            }

            $fileName = time() . '.' . $request->hash_for_profile_picture->getClientOriginalExtension();
            $request->hash_for_profile_picture->storeAs('profile_pictures', $fileName);

            $user->fill(['hash_for_profile_picture' => $fileName]);
            $user->save();            
        }     

        $user->save();

        $request->session()->flash('success', 'Profil berhasil diperbarui');

        return redirect()->intended('/admin-profile');
    }

    public function editPassword(Request $request) {
        $request->validate([
            'password' => 'nullable|min:5|max:255|confirmed',
            'password_confirmation' => 'nullable|min:5|max:255',
        ],[
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        $user = User::find(Auth::id());

        if ($request->has('password') && $request->has('password_confirmation') && !empty($request->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $request->session()->flash('success', 'Profil berhasil diperbarui');

        return redirect()->intended('/admin-profile');
    }
    
    public function checkAvailability(Request $request) {
        $request->validate([
            'availability' => 'required|boolean',
        ]);

        $user = auth()->user();

        if ($user->availability === 0) {
            $request->session()->flash('error', 'Anda sudah nonaktif');
            return redirect()->intended('/admin-profile');
        }

        $user->availability = $request->availability;
        $user->save();

        $request->session()->flash('success', 'Penonaktifan lembaga berhasil!');
        return redirect()->intended('/admin-profile');
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        // $request->session()->flash('success', 'Login Berhasil');

        Auth::logout();

        $user->delete();

        return redirect('/');
    }

    public function manageCourse() {
        $course = Course::where('admin_id', auth()->id())->get();
        return view('admin-page.manage-course', [
            "pageName" => "Daftar Kelas Anda | ",
            "course" => $course,
        ]);
    }

    public function createCoursePage() {
        return view('admin-page.create-course', [
            'pageName' => "Tambah Kelas Baru | "
        ]);
    }
}