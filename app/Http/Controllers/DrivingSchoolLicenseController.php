<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use App\Models\DrivingSchoolLicense; // Access DrivingSchoolLicense Tables
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Http\Request; // Use Request Method by Laravel

class DrivingSchoolLicenseController extends Controller
{
    // Create a New Driving School License Logic Handler
    public function drivingSchoolLicenseCreate(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'licensePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startLicenseDate' => 'required',
            'endLicenseDate' => 'required',
        ],
        
        // Validation Error Message
        [
            'licensePath.required' => 'Silahkan Pilih File untuk Diunggah',
            'licensePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'licensePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startLicenseDate.required' => 'Kolom ini harus diisi',
            'endLicenseDate.required' => 'Kolom ini harus diisi',
        ]);

        // Check if the incoming request has an uploaded license
        $fileName = null;
        if ($request->hasFile('licensePath')) {
            // assign the uploaded file to $file variable
            $file = $request->file('licensePath');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('drivingSchoolLicense', $fileName);
        }

        // Create a new Driving School License in the same named Tables
        $newLicense = new DrivingSchoolLicense();      
        // instead of the file being stored in database, we save the filename of the file from Laravel Storage
        $newLicense->licensePath = $fileName;
        // assign the value of the startLicenseDate attribute as per request
        $newLicense->startLicenseDate = $request['startLicenseDate'];
        // assign the value of the endLicenseDate attribute as per request
        $newLicense->endLicenseDate = $request['endLicenseDate'];
        // assign the value of the admin_id attribute by the currently authenticated user
        $newLicense->admin_id = Auth::id();
        // Save the new array of data to DrivingSchoolLicense Tables
        $newLicense->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Izin Kursus Berhasil Ditambahkan, Admin Sistem Akan Memvalidasi Izin Anda Terlebih Dahulu!');
        // Redirect user to List of Driving School License        
        return redirect()->intended('/admin-driving-school-license');
    }

    // Driving School License Delete Logic Handler
    public function drivingSchoolLicenseDelete($id, Request $request)
    {
        // find the desired license match the incoming ID with the ID from DrivingSchoolLicense Tables
        $license = DrivingSchoolLicense::findOrFail($id);
    
        // Delete the thumbnail from storage
        if ($license->licensePath) {
            Storage::delete('drivingSchoolLicense/' . $license->licensePath);
        }

        // Delete the desired DrivingSchoolLicense
        $license->delete();
        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Izin Kursus berhasil dihapus!');
        // Redirect Admin to List of Driving School License
        return redirect()->intended('/admin-driving-school-license');
    }

    // Create a New Driving School License Logic Handler
    public function newDrivingSchoolLicense(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'licensePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startLicenseDate' => 'required',
            'endLicenseDate' => 'required',
        ],
        
        // Validation Error Message
        [
            'licensePath.required' => 'Silahkan Pilih File untuk Diunggah',
            'licensePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'licensePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startLicenseDate.required' => 'Kolom ini harus diisi',
            'endLicenseDate.required' => 'Kolom ini harus diisi',
        ]);

        // Check if the incoming request has an uploaded license
        $fileName = null;
        if ($request->hasFile('licensePath')) {
            // assign the uploaded file to $file variable
            $file = $request->file('licensePath');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('drivingSchoolLicense', $fileName);
        }

        // Create a new Driving School License in the same named Tables
        $newLicense = new DrivingSchoolLicense();      
        // instead of the file being stored in database, we save the filename of the file from Laravel Storage
        $newLicense->licensePath = $fileName;
        // assign the value of the startLicenseDate attribute as per request
        $newLicense->startLicenseDate = $request['startLicenseDate'];
        // assign the value of the endLicenseDate attribute as per request
        $newLicense->endLicenseDate = $request['endLicenseDate'];
        // assign the value of the admin_id attribute by the currently authenticated user
        $newLicense->admin_id = Auth::id();
        // Save the new array of data to DrivingSchoolLicense Tables
        $newLicense->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Izin Kursus Berhasil Ditambahkan, Admin Sistem Akan Memvalidasi Izin Anda Terlebih Dahulu!');
        // Redirect user to List of Driving School License        
        return redirect()->intended('/user-profile');
    }
}
