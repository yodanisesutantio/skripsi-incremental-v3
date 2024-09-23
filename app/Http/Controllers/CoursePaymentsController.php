<?php

namespace App\Http\Controllers;

use App\Models\CoursePayment; // Access Course Payment Tables
use Illuminate\Http\Request; // Use Request Method by Laravel

class CoursePaymentsController extends Controller
{
    public function verifyPaymentLogic(Request $request, $coursePayment_id) {
        // Validation Rules
        $request->validate([
            'paymentStatus' => 'required|boolean',
        ]);

        // Find the desired Course Payment
        $coursePayment = CoursePayment::findOrFail($coursePayment_id);

        // Change the paymentStatus as per request
        $coursePayment->paymentStatus = $request->paymentStatus;
        // Save new data to User Tables
        $coursePayment->save();

        $student_real_name = $coursePayment->enrollment->student_real_name; // Adjust this line based on your relationships
        $enrollment_id = $coursePayment->enrollment_id; // Adjust this line based on your model

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Verifikasi Pembayaran Berhasil!');
        // Redirect owner/admin to List of Course Page
        return redirect(url('/admin-course-progress/' . $student_real_name . '/' . $enrollment_id));
    }

    public function sendPaymentReceipt(Request $request, $student_real_name, $enrollment_id) {
        // Validation Rules
        $this->validate($request, [
            'paymentFile' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
        ],
        
        // Validation Error Message
        [
            'paymentFile.required' => 'Silahkan Pilih File untuk Diunggah',
            'paymentFile.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'paymentFile.max' => 'Ukuran gambar maksimal adalah 2 MB',
        ]);

        // dd($request);

        // Check if the incoming request has an uploaded license
        $fileName = null;
        if ($request->hasFile('paymentFile')) {
            // assign the uploaded file to $file variable
            $file = $request->file('paymentFile');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('paymentFile', $fileName);
        }

        // If User already have uploaded the payment Receipt, then replace them
        $existingPaymentReceipt = CoursePayment::where('enrollment_id', $enrollment_id)->first();
        if ($existingPaymentReceipt) {
            // Update the existing payment receipt
            $existingPaymentReceipt->paymentFile = $fileName; // Update the file name
            $existingPaymentReceipt->save(); // Save the changes
        }
        
        // If non existed, create new
        else {
            // Create a new Instructor Certificate in the same named Tables
            $paymentReceipt = new CoursePayment();      
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            $paymentReceipt->enrollment_id = $enrollment_id;
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            $paymentReceipt->paymentFile = $fileName;
            // Save the new array of data to InstructorCertificate Tables
            $paymentReceipt->save();
        }        

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Bukti Pembayaran Berhasil Diunggah!');
        // Redirect user to List of Instructor Certificate        
        return redirect(url('/user-course-progress/' . $student_real_name . '/' . $enrollment_id));
    }
}
