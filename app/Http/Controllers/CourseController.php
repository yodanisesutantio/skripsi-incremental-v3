<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function deactivateCourse(Request $request) {
        $course = Course::find($request->course_id);

        if ($course) {
            $course->course_availability = 0;
            $course->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 400);
    }

    public function activateCourse(Request $request) {
        $course = Course::find($request->course_id);
        if ($course) {
            $course->course_availability = 1;
            $course->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }

    public function createCourseLogic(Request $request) {
        $request->validate([
            'course_thumbnail' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'course_name' => ['required', 'max:255'],
            'course_description' => ['required', 'max:255'],
            'course_quota' => ['required', 'integer', 'min:1', 'max:999'],
            'course_length' => ['required', 'integer', 'min:1', 'max:20'],
            'course_price' => ['required', 'min:11', 'max:255'],
            'car_type' => ['required', 'min:1'],
            'can_use_own_car' => ['required', 'boolean'],
        ],[
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
            'course_price.required' => 'Kolom ini harus diisi',
            'course_price.min' => 'Harga Kursus Terlalu Kecil',
            'course_price.max' => 'Harga Kursus Terlalu Besar',
            'car_type.required' => 'Anda harus memilih salah satu opsi',
            'car_type.min' => 'Anda harus memilih salah satu opsi',
            'can_use_own_car.required' => 'Anda harus memilih salah satu opsi',
        ]);

        $coursePrice = preg_replace('/\D/', '', $request->input('course_price'));

        $fileName = null;
        if ($request->hasFile('course_thumbnail')) {
            $file = $request->file('course_thumbnail');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('classOrCourse_thumbnail', $fileName);
        }

        $course = new Course();        
        $course->course_thumbnail = $fileName;
        $course->course_name = $request['course_name'];
        $course->course_description = $request['course_description'];
        $course->course_quota = $request['course_quota'];
        $course->course_length = $request['course_length'];
        $course->course_price = $coursePrice;
        $course->car_type = $request['car_type'];
        $course->can_use_own_car = $request['can_use_own_car'];
        $course->admin_id = Auth::id();
        $course->save();

        $request->session()->flash('success', 'Kelas Kursus Berhasil Ditambahkan');

        return redirect()->intended('/admin-manage-course');
    }

    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);

        $activeStudentsCount = $course->enrollments()->count();
        if ($activeStudentsCount > 0) {
            session()->flash('warning', 'Anda Tidak Boleh Menghapus Kelas dengan Siswa Aktif');
            return redirect()->intended('/admin-manage-course');
        } else {
            // Optionally, delete the thumbnail from storage
            if ($course->course_thumbnail) {
                Storage::delete('course_thumbnail/' . $course->course_thumbnail);
            }

            $course->delete();

            session()->flash('success', 'Kelas Kursus Berhasil Dihapus');

            return redirect()->intended('/admin-manage-course');
        }
    }
}
