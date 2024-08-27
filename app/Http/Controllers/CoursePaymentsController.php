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
}
