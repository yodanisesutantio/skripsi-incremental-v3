<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use App\Models\InstructorCertificate; // Access InstructorCertificate Tables
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Http\Request; // Use Request Method by Laravel

class InstructorCertificateController extends Controller
{
    // Create a New Instructor Certificate Logic Handler
    public function instructorCertificateCreate(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'certificatePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startCertificateDate' => 'required',
            'endCertificateDate' => 'required',
        ],
        
        // Validation Error Message
        [
            'certificatePath.required' => 'Silahkan Pilih File untuk Diunggah',
            'certificatePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'certificatePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startCertificateDate.required' => 'Kolom ini harus diisi',
            'endCertificateDate.required' => 'Kolom ini harus diisi',
        ]);

        // Check if the incoming request has an uploaded license
        $fileName = null;
        if ($request->hasFile('certificatePath')) {
            // assign the uploaded file to $file variable
            $file = $request->file('certificatePath');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('instructor_certificate', $fileName);
        }

        // Create a new Instructor Certificate in the same named Tables
        $newCertificate = new InstructorCertificate();      
        // instead of the file being stored in database, we save the filename of the file from Laravel Storage
        $newCertificate->certificatePath = $fileName;
        // assign the value of the startCertificateDate attribute as per request
        $newCertificate->startCertificateDate = $request['startCertificateDate'];
        // assign the value of the endCertificateDate attribute as per request
        $newCertificate->endCertificateDate = $request['endCertificateDate'];
        // assign the value of the instructor_id attribute by the currently authenticated user
        $newCertificate->instructor_id = Auth::id();
        // Save the new array of data to InstructorCertificate Tables
        $newCertificate->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Sertifikat Berhasil Ditambahkan, Admin Sistem Akan Memvalidasi Sertifikat Anda Terlebih Dahulu!');
        // Redirect user to List of Instructor Certificate        
        return redirect()->intended('/instructor-certificate');
    }
}
