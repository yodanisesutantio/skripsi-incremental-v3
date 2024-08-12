<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\InstructorCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class instructorController extends Controller
{
    // Deactivate Instructor Logic Handler
    public function deactivateInstructor(Request $request) {
        // find the Instructor by matching the user_id with the incoming request from User Tables
        $user = User::find($request->user_id);

        // If user is found, do this data transaction
        if ($user) {
            // Change the availability attribute value to 0
            $user->availability = 0;
            // Save the new data
            $user->save();
    
            // Return success response to JSON
            return response()->json(['success' => true]);
        }
    
        // Return failed response to JSON when no user is found
        return response()->json(['success' => false], 400);
    }

    // Activate Instructor Logic Handler
    public function activateInstructor(Request $request) {
        // find the Instructor by matching the user_id with the incoming request from User Tables
        $user = User::find($request->user_id);

        // If user is found, do this data transaction
        if ($user) {
            // Change the availability attribute value to 0
            $user->availability = 1;
            // Save the new data
            $user->save();

            // Return success response to JSON
            return response()->json(['success' => true]);
        }

        // Return failed response to JSON when no user is found
        return response()->json(['success' => false], 400);
    }

    // Create new Instructor Form Logic Handler
    public function createInstructorLogic(Request $request) {
        // Validation Rules
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
        ],
        
        // Validation Error Messages
        [
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

        // Replace 0 or 62 from the first 2 number of the inputted phone_number with +62, so it is easier to add wa.me/ link
        $request['phone_number'] = preg_replace('/^(0|62)/', '+62', $request->input('phone_number'));

        // Detect if the incoming request has an uploaded profile picture
        if ($request->hasFile('hash_for_profile_picture')) {
            // assign the uploaded file to $file variable
            $file = $request->file('hash_for_profile_picture');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('profile_pictures', $fileName);
        }
        
        // Create a new Instructor Data in User Tables
        $user = User::create([
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            'hash_for_profile_picture' => $fileName,
            // assign the value of the fullname attribute as per request
            'fullname' => $request->fullname,
            // assign the value of the username attribute as per request
            'username' => $request->username,
            // assign the value of the password attribute as per request but, we crypted it first
            'password' => bcrypt($request->password),
            // assign the value of the age attribute as per request
            'age' => $request->age,
            // assign the value of the description attribute as per request
            'description' => $request->description,
            // assign the value of the phone_number as it is already formatted from the request
            'phone_number' => $request->phone_number,
            // set the value of availability attribute to 0 by default, since sys_admin need to validate it first
            'availability' => 0,
            // assign the value of the admin_id attribute by the currently authenticated user
            'admin_id' => Auth()->id(),
        ]);
        
        // Save the new array of data to User Tables
        $user->save();


        // Detect if the incoming request has an uploaded certificate
        if ($request->hasFile('certificatePath')) {
            // assign the uploaded file to $fileCertificate variable
            $fileCertificate = $request->file('certificatePath');
            // rename the filename to store it inside the database
            $certificateFile = time() . '.' . $fileCertificate->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $fileCertificate->storeAs('instructor_certificate', $certificateFile);
        }

        // Create a new Instructor Certificate Data in InstructorCertificate Tables
        $certificate = InstructorCertificate::create([
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            'certificatePath' => $certificateFile,
            // assign the value of the startCertificateDate attribute as per request
            'startCertificateDate' => $request->startCertificateDate,
            // assign the value of the endCertificateDate attribute as per request
            'endCertificateDate' => $request->endCertificateDate,
            // assign the value of the instructor_id attribute from the newly added instructor above
            'instructor_id' => $user->id,
        ]);

        // Save the new array of data to InstructorCertificate Tables
        $certificate->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        session()->flash('success', 'Instruktur Berhasil Ditambahkan!');
        // Redirect user to List of Instructor Page
        return redirect()->intended('/admin-manage-instructor');
    }

    // Delete Instructor Logic Handler
    public function deleteInstructor($id) {
        // Find the instructor data by matching the incoming ID with the ID from User Tables
        $instructor = User::findOrFail($id);
    
        // Delete the thumbnail from storage
        if ($instructor->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $instructor->hash_for_profile_picture);
        }

        // Then Delete the data
        $instructor->delete();

        // Check if the owner/admin has any remaining instructors
        $remainingInstructors = User::where('admin_id', auth()->id())->count();

        // When they had no more instructors, generate this flash message via Toastr
        if ($remainingInstructors == 0) {
            session()->flash('warning', 'Anda sudah tidak memiliki Instruktur lagi!');
        } 
        
        // If they still had at least more than 1 instructors, generate this flash message via Toastr
        else {
            session()->flash('success', 'Instruktur Berhasil Dihapus');
        }
        // Redirect the admin to List of Instructor Page
        return redirect()->intended('/admin-manage-instructor');
    }
}
