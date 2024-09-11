<?php

namespace App\Http\Controllers;

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel

class CourseController extends Controller
{
    // Deactivate Course Logic Handler
    public function deactivateCourse(Request $request) {
        // Find the desired course by matching the incoming requested ID with ID from Course Tables
        $course = Course::find($request->course_id);

        // If course is found, do this data transaction
        if ($course) {
            // change the course_availability attribute value to 0
            $course->course_availability = 0;
            // Save the changes
            $course->save();
    
            // Return successful response to JSON
            return response()->json(['success' => true]);
        }
    
        // Return failed response to JSON
        return response()->json(['success' => false], 400);
    }

    // Activate Course Logic Handler
    public function activateCourse(Request $request) {
        // Find the desired course by matching the incoming requested ID with ID from Course Tables
        $course = Course::find($request->course_id);

        // If course is found, do this data transaction
        if ($course) {
            // change the course_availability attribute value to 0
            $course->course_availability = 1;
            // Save the changes
            $course->save();

            // Return successful response to JSON
            return response()->json(['success' => true]);
        }

        // Return failed response to JSON
        return response()->json(['success' => false], 400);
    }

    // Create new course logic handler
    public function createCourseLogic(Request $request) {
        // Validation Rules
        $request->validate([
            'course_thumbnail' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'course_name' => ['required', 'max:255'],
            'course_description' => ['required', 'max:255'],
            'course_quota' => ['required', 'integer', 'min:1', 'max:999'],
            'course_length' => ['required', 'integer', 'min:1', 'max:20'],
            'course_duration' => ['required', 'integer', 'min:45', 'max:120'],
            'course_price' => ['required', 'min:11', 'max:255'],
            'car_type' => ['required', 'min:1'],
            'can_use_own_car' => ['required', 'boolean'],
            'instructor_ids' => 'required|array|min:1',
            'instructor_ids.*' => 'exists:users,id',
        ],
        
        // Validation Error Messages
        [
            'course_thumbnail.mimes' => 'Format yang didukung adalah .jpg, .png, atau .webp',
            'course_thumbnail.max' => 'Ukuran file maksimal adalah 2 MB',
            'course_name.required' => 'Kolom ini harus diisi',
            'course_name.max' => 'Nama Kursus Terlalu Panjang',
            'course_description.required' => 'Kolom ini harus diisi',
            'course_description.max' => 'Deskripsi Kursus Terlalu Panjang',
            'course_quota.required' => 'Kolom ini harus diisi',
            'course_quota.integer' => 'Masukkan angka saja',
            'course_quota.min' => 'Kuota Kursus Minimal adalah 1',
            'course_quota.max' => 'Kuota Kursus Maksimal adalah 999',
            'course_length.required' => 'Kolom ini harus diisi',
            'course_length.integer' => 'Masukkan angka saja',
            'course_length.min' => 'Jumlah Pertemuan Kursus Minimal adalah 1',
            'course_length.max' => 'Jumlah Pertemuan Kursus Maksimal adalah 20',
            'course_duration.required' => 'Anda harus memilih salah satu opsi',
            'course_price.required' => 'Kolom ini harus diisi',
            'course_price.min' => 'Harga Kursus Terlalu Kecil',
            'course_price.max' => 'Harga Kursus Terlalu Besar',
            'car_type.required' => 'Anda harus memilih salah satu opsi',
            'car_type.min' => 'Anda harus memilih salah satu opsi',
            'can_use_own_car.required' => 'Anda harus memilih salah satu opsi',
            'instructor_ids.required' => 'Anda harus memilih salah satu instruktur',
        ]);

        // Remove any non-numerical characters
        $coursePrice = preg_replace('/\D/', '', $request->input('course_price'));

        // Check if there's any uploaded course_thumbnail
        $fileName = null;
        if ($request->hasFile('course_thumbnail')) {
            $file = $request->file('course_thumbnail');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('classOrCourse_thumbnail', $fileName);
        }

        // Create a new Course in the Course Tables
        $course = new Course();        
        // instead of the file being stored in database, we save the filename of the file from Laravel Storage
        $course->course_thumbnail = $fileName;
        // assign the value of the course_name attribute as per request
        $course->course_name = $request['course_name'];
        // assign the value of the course_description attribute as per request
        $course->course_description = $request['course_description'];
        // assign the value of the course_quota attribute as per request
        $course->course_quota = $request['course_quota'];
        // assign the value of the course_length attribute as per request
        $course->course_length = $request['course_length'];
        // assign the value of the course_duration attribute as per request
        $course->course_duration = $request['course_duration'];
        // assign the value of the course_price attribute as the formatted request
        $course->course_price = $coursePrice;
        // assign the value of the car_type attribute as per request
        $course->car_type = $request['car_type'];
        // assign the value of the can_use_own_car attribute as per request
        $course->can_use_own_car = $request['can_use_own_car'];
        // assign the value of the admin_id attribute by the currently authenticated user
        $course->admin_id = Auth::id();
        // Save the new array of data to Course Tables
        $course->save();

        // Create a new array data in CourseInstructor Tables
        if ($request->has('instructor_ids')) {
            foreach ($request->input('instructor_ids') as $instructorId) {
                DB::table('course_instructors')->insert([
                    // Assign the value of course_id attribute with the new added course
                    'course_id' => $course->id,
                    // Assign the value of instructor_id from the chosen instructors
                    'instructor_id' => $instructorId,
                ]);
            }
        }

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Kelas Kursus Berhasil Ditambahkan');
        // Redirect user to List of Course        
        return redirect()->intended('/admin-manage-course');
    }

    // Edit Course Logic Handler
    public function editCourseLogic(Request $request, $username, $course_name) {
        // Validation Rules
        $request->validate([
            'course_thumbnail' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'course_name' => ['required', 'max:255'],
            'course_description' => ['required', 'max:255'],
            'course_quota' => ['required', 'integer', 'min:1', 'max:999'],
            'course_length' => ['required', 'integer', 'min:1', 'max:20'],
            'course_duration' => ['required', 'integer', 'min:45', 'max:120'],
            'course_price' => ['required', 'min:11', 'max:255'],
            'car_type' => ['required', 'min:1'],
            'can_use_own_car' => ['required', 'boolean'],
            'instructor_ids' => 'required|array|min:1',
            'instructor_ids.*' => 'exists:users,id',
        ],
        
        // Validation Error Messages
        [
            'course_thumbnail.mimes' => 'Format yang didukung adalah .jpg, .png, atau .webp',
            'course_thumbnail.max' => 'Ukuran file maksimal adalah 2 MB',
            'course_name.required' => 'Kolom ini harus diisi',
            'course_name.max' => 'Nama Kursus Terlalu Panjang',
            'course_description.required' => 'Kolom ini harus diisi',
            'course_description.max' => 'Deskripsi Kursus Terlalu Panjang',
            'course_quota.required' => 'Kolom ini harus diisi',
            'course_quota.integer' => 'Masukkan angka saja',
            'course_quota.min' => 'Kuota Kursus Minimal adalah 1',
            'course_quota.max' => 'Kuota Kursus Maksimal adalah 999',
            'course_length.required' => 'Kolom ini harus diisi',
            'course_length.integer' => 'Masukkan angka saja',
            'course_length.min' => 'Jumlah Pertemuan Kursus Minimal adalah 1',
            'course_length.max' => 'Jumlah Pertemuan Kursus Maksimal adalah 20',
            'course_duration.required' => 'Anda harus memilih salah satu opsi',
            'course_price.required' => 'Kolom ini harus diisi',
            'course_price.min' => 'Harga Kursus Terlalu Kecil',
            'course_price.max' => 'Harga Kursus Terlalu Besar',
            'car_type.required' => 'Anda harus memilih salah satu opsi',
            'car_type.min' => 'Anda harus memilih salah satu opsi',
            'can_use_own_car.required' => 'Anda harus memilih salah satu opsi',
            'instructor_ids.required' => 'Anda harus memilih salah satu instruktur',
        ]);

        // Remove any non-numerical characters
        $coursePrice = preg_replace('/\D/', '', $request->input('course_price'));

        // Find the chosen course to be edited that is owned by the owner/admin
        $course = Course::whereHas('admin', function ($query) use ($username) {
            $query->where('username', $username);
        })->where('course_name', $course_name)->firstOrFail();

        // Check if admin uploaded a new course_thumbnail
        if ($request->hasFile('course_thumbnail')) {
            // assign the uploaded file to $file variable
            $file = $request->file('course_thumbnail');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('classOrCourse_thumbnail', $fileName);
            // instead of the file updated in database, we save the filename of the file from Laravel Storage
            $course->course_thumbnail = $fileName;
        }

        // Update the course data
        $course->fill([
            // assign the value of the course_name attribute as per request
            'course_name' => $request->input('course_name'),
            // assign the value of the course_description attribute as per request
            'course_description' => $request->input('course_description'),
            // assign the value of the course_quota attribute as per request
            'course_quota' => $request->input('course_quota'),
            // assign the value of the course_length attribute as per request
            'course_length' => $request->input('course_length'),
            // assign the value of the course_duration attribute as per request
            'course_duration' => $request->input('course_duration'),
            // assign the value of the course_price attribute as the formatted request
            'course_price' => $coursePrice,
            // assign the value of the car_type attribute as per request
            'car_type' => $request->input('car_type'),
            // assign the value of the can_use_own_car attribute as per request
            'can_use_own_car' => $request->input('can_use_own_car'),
        ]);

        // Update the selected course with the new data
        $course->save();

        // Fetch the current instructor IDs for the course
        $currentInstructorIds = DB::table('course_instructors')
            ->where('course_id', $course->id) // Match the course_id from course_instructors tables with the selected course_id
            ->pluck('instructor_id') // Only fetch the instructor_id attribute
            ->toArray(); // Collect it in an array

        // Get the new instructor IDs from the request
        $newInstructorIds = $request->input('instructor_ids', []);

        // Determine which instructors to add and which to remove
        $instructorsToAdd = array_diff($newInstructorIds, $currentInstructorIds);
        $instructorsToRemove = array_diff($currentInstructorIds, $newInstructorIds);

        // Add new instructors
        foreach ($instructorsToAdd as $instructorId) {
            DB::table('course_instructors')->insert([
                // Assign the value of course_id attribute with the new added course
                'course_id' => $course->id,
                // Assign the value of instructor_id from the chosen instructors
                'instructor_id' => $instructorId,
            ]);
        }

        // Remove instructors that are no longer selected
        foreach ($instructorsToRemove as $instructorId) {
            DB::table('course_instructors')
                ->where('course_id', $course->id)
                ->where('instructor_id', $instructorId)
                ->delete();
        }

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Kelas ' . $course->course_name . ' berhasil diperbarui');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/admin-manage-course');
    }

    // Delete Course Logic Handler
    public function deleteCourse($id)
    {
        // Find the desired course
        $course = Course::findOrFail($id);
    
        // Delete the thumbnail from storage
        if ($course->course_thumbnail) {
            Storage::delete('course_thumbnail/' . $course->course_thumbnail);
        }

        // Delete the chosen course
        $course->delete();

        // Check if the user has any remaining classes
        $remainingCourses = Course::where('admin_id', auth()->id())->count();

        // When they had no more instructors, generate this flash message via Toastr
        if ($remainingCourses == 0) {
            session()->flash('warning', 'Anda sudah tidak memiliki Kelas Kursus lagi!');
        } 
        
        // If they still had at least more than 1 instructors, generate this flash message via Toastr
        else {
            session()->flash('success', 'Kelas Kursus Berhasil Dihapus');
        }
        // Redirect the admin to List of Instructor Page
        return redirect()->intended('/admin-manage-course');
    }
}
