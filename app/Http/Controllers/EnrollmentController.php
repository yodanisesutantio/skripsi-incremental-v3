<?php

namespace App\Http\Controllers;

use App\Models\Enrollment; // Access Enrollment Tables
use Illuminate\Http\Request; // Use Request Method by Laravel

class EnrollmentController extends Controller
{
    public function deleteStudent(Request $request)
    {
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
        ]);

        // dd($request);

        $enrollment = Enrollment::findOrFail($request->enrollment_id);
        $enrollment->delete();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Siswa berhasil dihapus!');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/admin-course/active-student-list');
    }
}
