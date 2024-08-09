<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DrivingSchoolLicense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DrivingSchoolLicenseController extends Controller
{
    public function drivingSchoolLicenseCreate(Request $request) {
        $this->validate($request, [
            'licensePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startLicenseDate' => 'required',
            'endLicenseDate' => 'required',
        ],[
            'licensePath.required' => 'Silahkan Pilih File untuk Diunggah',
            'licensePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'licensePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startLicenseDate.required' => 'Kolom ini harus diisi',
            'endLicenseDate.required' => 'Kolom ini harus diisi',
        ]);

        $fileName = null;
        if ($request->hasFile('licensePath')) {
            $file = $request->file('licensePath');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('drivingSchoolLicense', $fileName);
        }

        $newLicense = new DrivingSchoolLicense();        
        $newLicense->licensePath = $fileName;
        $newLicense->startLicenseDate = $request['startLicenseDate'];
        $newLicense->endLicenseDate = $request['endLicenseDate'];
        $newLicense->admin_id = Auth::id();
        $newLicense->save();

        $request->session()->flash('success', 'Izin Kursus Berhasil Ditambahkan, Admin Sistem Akan Memvalidasi Izin Anda Terlebih Dahulu!');

        return redirect()->intended('/admin-driving-school-license');
    }

    public function drivingSchoolLicenseDelete($id)
    {
        $license = DrivingSchoolLicense::findOrFail($id);
    
        // Optionally, delete the thumbnail from storage
        if ($license->licensePath) {
            Storage::delete('drivingSchoolLicense/' . $license->licensePath);
        }

        $license->delete();

        return redirect()->intended('/admin-driving-school-license');
    }
}
