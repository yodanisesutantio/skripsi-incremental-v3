<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InstructorCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class instructorController extends Controller
{
    public function deactivateInstructor(Request $request) {
        $user = User::find($request->user_id);

        if ($user) {
            $user->availability = 0;
            $user->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 400);
    }

    public function activateInstructor(Request $request) {
        $user = User::find($request->user_id);
        if ($user) {
            $user->availability = 1;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function createInstructorLogic(Request $request) {
        $this->validate($request, [
            'certificatePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startCertificateDate' => 'required',
            'endCertificateDate' => 'required',
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'age' => 'nullable|integer|min:18|max:99',
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20|unique:users',
            'password' => 'required|min:5|max:255|confirmed',
            'password_confirmation' => 'required|min:5|max:255',
        ],[
            'certificatePath.required' => 'Silahkan pilih Sertifikat Instruktur untuk diunggah',
            'certificatePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'certificatePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startCertificateDate.required' => 'Kolom ini harus diisi',
            'endCertificateDate.required' => 'Kolom ini harus diisi',
            'hash_for_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'hash_for_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'age.min' => 'Usia minimal adalah 18 Tahun',
            'age.max' => 'Usia maksimal adalah 99 Tahun',
            'description.max' => 'Deskripsi terlalu panjang',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
            'password.required' => 'Kolom ini harus diisi',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.required' => 'Ketik Ulang Password Anda',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        $request['phone_number'] = preg_replace('/^(0|62)/', '+62', $request->input('phone_number'));

        $fileName = null;
        if ($request->hasFile('hash_for_profile_picture')) {
            $file = $request->file('hash_for_profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_picture', $fileName);
        }
        
        $user = User::create([
            'hash_for_profile_picture' => $fileName,
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'age' => $request->age,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'availability' => 0,
            'admin_id' => Auth()->id(),
        ]);
        
        $user->save();

        session()->flash('success', 'Instruktur Berhasil Ditambahkan!');
        return redirect()->intended('/admin-manage-instructor');
    }

    public function deleteInstructor($id) {
        $instructor = User::findOrFail($id);
    
        // Optionally, delete the thumbnail from storage
        if ($instructor->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $instructor->hash_for_profile_picture);
        }

        $instructor->delete();

        // Check if the user has any remaining instructors
        $remainingInstructors = User::where('admin_id', auth()->id())->count();

        if ($remainingInstructors == 0) {
            session()->flash('warning', 'Anda sudah tidak memiliki Instruktur lagi!');
        } else {
            session()->flash('success', 'Instruktur Berhasil Dihapus');
        }

        return redirect()->intended('/admin-manage-instructor');
    }
}
