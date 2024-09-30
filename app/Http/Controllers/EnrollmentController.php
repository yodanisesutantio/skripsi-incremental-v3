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

    public function newStudent(Request $request, $course_name, $course_id) {
        // Validation Rules
        $request->validate([
            'student_real_name' => ['required', 'max:255'],
            'student_gender' => ['required'],
            'student_birth_of_place' => ['required', 'max:255'],
            'student_birth_of_date' => ['required', 'date'],
            'student_occupation' => ['required', 'max:255'],
            'student_phone_number' => ['required', 'max:20'],
            'student_address' => ['required', 'max:255'],
            'student_education_level' => ['required'],
            'student_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'instructor_ids' => 'required|array|min:1',
            'instructor_ids.*' => 'exists:users,id',
        ],
        
        // Validation Error Messages
        [
            'student_real_name.required' => 'Kolom ini harus diisi',
            'student_real_name.max' => 'Nama Kursus Terlalu Panjang',
            'student_gender.required' => 'Anda harus memilih salah satu opsi',
            'student_birth_of_place.required' => 'Kolom ini harus diisi',
            'student_birth_of_place.max' => 'Nama Kursus Terlalu Panjang',
            'student_birth_of_date.required' => 'Kolom ini harus diisi',
            'student_occupation.required' => 'Kolom ini harus diisi',
            'student_occupation.max' => 'Data pada kolom pekerjaan terlalu panjang',
            'student_phone_number.required' => 'Kolom ini harus diisi',
            'student_phone_number.max' => 'Nomor Terlalu Panjang',
            'student_address.required' => 'Kolom ini harus diisi',
            'student_address.max' => 'Alamat Terlalu Panjang',
            'student_education_level.required' => 'Anda harus memilih salah satu opsi',
            'student_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'student_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'instructor_ids.required' => 'Anda harus memilih salah satu instruktur',
        ]);

        // Check if there's any uploaded course_thumbnail
        $fileName = null;
        if ($request->hasFile('student_profile_picture')) {
            $file = $request->file('student_profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('enrollment/profile_pictures', $fileName);
        }

        // Format phone number to +62 and remove non-numeric characters
        $cleanedPhoneNumber = preg_replace('/\D/', '', $request['student_phone_number']); // Remove non-numeric characters

        // Create a new Enrollment Data in the Enrollment Tables
        $enrollment = new Enrollment();
        $enrollment->course_id = $course_id;
        $enrollment->instructor_id = $request['instructor_ids'][0];
        $enrollment->student_id = auth()->id();
        $enrollment->student_real_name = $request['student_real_name'];
        $enrollment->student_gender = $request['student_gender'];
        $enrollment->student_birth_of_place = $request['student_birth_of_place'];
        $enrollment->student_birth_of_date = $request['student_birth_of_date'];
        $enrollment->student_occupation = $request['student_occupation'];
        $enrollment->student_phone_number = preg_replace('/^(0|62)/', '+62', $cleanedPhoneNumber);
        $enrollment->student_address = $request['student_address'];
        $enrollment->student_education_level = $request['student_education_level'];
        $enrollment->student_profile_picture = $fileName;
        $enrollment->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Pendaftaran Kursus Berhasil!');
        // Redirect user to User Course Progress        
        return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment->id));
    }
}
