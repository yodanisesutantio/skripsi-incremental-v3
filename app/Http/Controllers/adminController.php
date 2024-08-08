<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use App\Models\DrivingSchoolLicense;
use App\Models\Course;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class adminController extends Controller
{
    public function indexPage() {
        $view = 'home.admin';
    
        return view($view, [
            "pageName" => "Beranda | ",
        ]);
    }

    public function coursePage() {
        $course = Course::query()->where('admin_id', auth()->id())->get();
        $courseManual = Course::query()->where('admin_id', auth()->id())->where('car_type', 'Manual')->orwhere('car_type', 'Both')->get();
        $courseMatic = Course::query()->where('admin_id', auth()->id())->where('car_type', 'Matic')->orwhere('car_type', 'Both')->get();
        $courseQuick = Course::query()->where('admin_id', auth()->id())->where('course_length', '<', 4)->get();
        $averageCourseLength = (int) $course->avg('course_length'); // Calculate average and cast to integer

        $minCoursePrice = (int) $course->min('course_price'); // Get minimum course price
        $maxCoursePrice = (int) $course->max('course_price'); // Get maximum course price

        // Format prices
        $minCoursePrice = $minCoursePrice >= 1000000 ? number_format($minCoursePrice / 1000000, 1) . 'jt' : number_format($minCoursePrice / 1000) . 'rb';
        $maxCoursePrice = $maxCoursePrice >= 1000000 ? number_format($maxCoursePrice / 1000000, 1) . 'jt' : number_format($maxCoursePrice / 1000) . 'rb';

        return view('admin-page.admin-course', [
            "pageName" => "Halaman Kursus Anda | ",
            "course" => $course,
            "courseManual" => $courseManual,
            "courseMatic" => $courseMatic,
            "courseQuick" => $courseQuick,
            "averageCourseLength" => $averageCourseLength,
            "minCoursePrice" => $minCoursePrice,
            "maxCoursePrice" => $maxCoursePrice,
        ]);
    }

    public function profilePage() {
        return view('profile.admin-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    public function drivingSchoolLicensePage() {
        $adminId = auth()->id();
    
        $activeDrivingSchoolLicense = DrivingSchoolLicense::query()
            ->where('admin_id', $adminId)
            ->where('licenseStatus', 'Aktif')
            ->first();

        if ($activeDrivingSchoolLicense) {
            $activeDrivingSchoolLicense->formattedStartDate = Carbon::parse($activeDrivingSchoolLicense->startLicenseDate)->translatedFormat('d M Y');
            $activeDrivingSchoolLicense->formattedEndDate = Carbon::parse($activeDrivingSchoolLicense->endLicenseDate)->translatedFormat('d M Y');
        }
    
        $drivingSchoolLicenses = DrivingSchoolLicense::query()
            ->where('admin_id', $adminId)
            ->orderby('created_at', 'desc')
            ->get();

        if ($drivingSchoolLicenses->isNotEmpty()) {
            $drivingSchoolLicenses->each(function ($license) {
                $license->formattedEndDate = Carbon::parse($license->endLicenseDate)->translatedFormat('d M Y');
            });
        }
    
        return view('admin-page.driving-school-license', [
            "pageName" => "Izin Penyelenggaraan Kursus Anda | ",
            "activeLicense" => $activeDrivingSchoolLicense,
            "licenses" => $drivingSchoolLicenses,
        ]);
    }    

    public function drivingSchoolLicenseForm() {
        return view('admin-page.create-driving-school-license', [
            "pageName" => "Unggah Izin Penyelenggaraan Kursus Baru | ",
        ]);
    }

    public function editProfilePage() {
        $paymentMethod = PaymentMethod::where('admin_id', auth()->id())->get();

        foreach ($paymentMethod as $methodOfPayment) {
            $methodOfPayment->payment_address = Crypt::decryptString($methodOfPayment->payment_address);
        }

        return view('profile.edit-admin-profile', [
            "pageName" => "Edit Profil | ",
            "paymentMethod" => $paymentMethod,
        ]);
    }

    public function editAccountInfo(Request $request) {
        $this->validate($request, [
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . Auth::id(),
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20',
            'availability' => 'required|boolean',
        ],[
            'hash_for_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'hash_for_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'description.max' => 'Deskripsi terlalu panjang',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
        ]);

        $user = User::find(Auth::id());
        $user->update($request->only(['fullname', 'username', 'description', 'phone_number', 'availability']));

        $fileName = null;
        if ($request->hasFile('hash_for_profile_picture')) {
            // Delete old pictures
            if ($user->hash_for_profile_picture && Storage::disk('public')->exists("profile_pictures/" . $user->hash_for_profile_picture)) {
                Storage::disk('public')->delete("profile_pictures/" . $user->hash_for_profile_picture);
            }

            $fileName = time() . '.' . $request->hash_for_profile_picture->getClientOriginalExtension();
            $request->hash_for_profile_picture->storeAs('profile_pictures', $fileName);

            $user->fill(['hash_for_profile_picture' => $fileName]);
            $user->save();            
        }     

        $user->save();

        $request->session()->flash('success', 'Profil berhasil diperbarui!');

        return redirect()->intended('/admin-profile');
    }

    public function editPassword(Request $request) {
        $request->validate([
            'password' => 'nullable|min:5|max:255|confirmed',
            'password_confirmation' => 'nullable|min:5|max:255',
        ],[
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        $user = User::find(Auth::id());

        if ($request->has('password') && $request->has('password_confirmation') && !empty($request->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $request->session()->flash('success', 'Password berhasil diubah!');

        return redirect()->intended('/admin-profile');
    }
    
    public function changeAvailability(Request $request) {
        $request->validate([
            'availability' => 'required|boolean',
        ]);

        $user = auth()->user();

        if ($user->availability === 0) {
            $request->session()->flash('error', 'Anda sudah nonaktif');
            return redirect()->intended('/admin-profile');
        }

        $user->availability = $request->availability;
        $user->save();

        $request->session()->flash('success', 'Penonaktifan lembaga berhasil!');
        return redirect()->intended('/admin-profile');
    }

    // I'll do this later, make sure that we are not deleting an entire data, just, instructor data and their course data, keep the account data
    public function destroy(Request $request)
    {
        $course = Course::where('admin_id', auth()->id())->get();
        if ($course->enrollments()->count() === 0) {
            $user = Auth::user();
            Auth::logout();
            $user->delete();
    
            return redirect('/');
        }

        $request->session()->flash('error', 'Anda masih memiliki Siswa Aktif! Selesaikan semua kursus dengan Siswa, kemudian Coba Lagi.');
        return redirect()->intended('/admin-profile');
    }

    public function manageCoursePage() {
        $course = Course::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        $user = auth()->user();
        return view('admin-page.manage-course', [
            "pageName" => "Daftar Kelas Anda | ",
            "course" => $course,
            "user" => $user,
        ]);
    }

    public function createCoursePage() {
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('admin-page.create-course', [
            'pageName' => "Tambah Kelas Baru | ",
            'instructors' => $instructors
        ]);
    }

    public function editCoursePage($username, $course_name) {
        $course = Course::whereHas('admin', function ($query) use ($username) {
            $query->where('username', $username);
        })->where('course_name', $course_name)->firstOrFail();

        // Fetch the course instructors for the current course
        $courseInstructors = DB::table('course_instructors')
                            ->where('course_id', $course->id)
                            ->pluck('instructor_id')
                            ->toArray();

        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        return view('admin-page.edit-course', [
            'pageName' => "Edit Kelas | ",
            'course' => $course,
            'instructors' => $instructors,
            'courseInstructors' => $courseInstructors,
        ]);
    }

    public function manageInstructorPage() {
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('admin-page.manage-instructor', [
            "pageName" => "Daftar Instruktur Anda | ",
            "instructors" => $instructors,
        ]);
    }

    public function createInstructorPage() {
        return view('admin-page.create-instructor', [
            'pageName' => "Tambah Instruktur Baru | "
        ]);
    }

    public function activeStudentPage() {
        return view('admin-page.active-student', [
            'pageName' => "Detail Progress Kursus Siswa | "
        ]);
    }

    public function courseProgressPage() {
        return view('admin-page.course-progress', [
            'pageName' => "Detail Progress Kursus Siswa | "
        ]);
    }

    public function courseProgressPage2() {
        return view('user-course-details', [
            'pageName' => "Detail Progress Kursus Siswa | "
        ]);
    }
}