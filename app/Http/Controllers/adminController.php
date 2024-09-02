<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\DrivingSchoolLicense; // Access DrivingSchoolLicense Tables
use App\Models\InstructorCertificate; // Access DrivingSchoolLicense Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\Enrollment; // Access Enrollment Tables
use App\Models\PaymentMethod; // Access PaymentMethod Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class adminController extends Controller
{
    // Admin-Index Page Controller
    public function indexPage() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');
        
        // Check for incoming course schedules for the authenticated admin
        $incomingSchedule = CourseSchedule::whereHas('enrollment.course', function($query) {
            $query->where('admin_id', auth()->id());
        })
        ->where('start_time', '>=', now()) // Filter for upcoming schedules
        ->orderBy('start_time', 'asc') // Order by start time
        ->first(); // Get the first upcoming schedule

        // Localize the startLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
        $incomingSchedule->formattedStartDate = Carbon::parse($incomingSchedule->start_time)->translatedFormat('d F Y');
        $incomingSchedule->formattedStartTime = Carbon::parse($incomingSchedule->start_time)->translatedFormat('H:i');
        $incomingSchedule->formattedEndTime = Carbon::parse($incomingSchedule->end_time)->translatedFormat('H:i');

        // Fetch today's schedule from the course_schedule table
        $todaySchedule = CourseSchedule::whereDate('start_time', \Carbon\Carbon::today())->orderBy('start_time', 'asc')->get();

        foreach ($todaySchedule as $schedule) {
            $schedule->formattedStartTime = Carbon::parse($schedule->start_time)->translatedFormat('H:i');
            $schedule->formattedEndTime = Carbon::parse($schedule->end_time)->translatedFormat('H:i');
        }

        // Fetch schedules for the next 7 days
        $nextWeekSchedules = [];
        for ($i = 1; $i <= 6; $i++) {
            $nextWeekSchedules[$i] = CourseSchedule::whereDate('start_time', \Carbon\Carbon::today()->addDays($i))->get();

            // Format start and end times for each schedule
            foreach ($nextWeekSchedules[$i] as $schedule) {
                $schedule->formattedStartTime = Carbon::parse($schedule->start_time)->translatedFormat('H:i');
                $schedule->formattedEndTime = Carbon::parse($schedule->end_time)->translatedFormat('H:i');
            }
        }

        // dd($todaySchedule);
    
        return view('home.admin', [
            "pageName" => "Beranda | ",
            "incomingSchedule" => $incomingSchedule,
            "todaySchedule" => $todaySchedule,
            "nextWeekSchedules" => $nextWeekSchedules,
        ]);
    }

    // Admin-Course Page Controller
    public function coursePage() {
        $user = auth()->user();

        // Localize the date and time to Indonesian
        Carbon::setLocale('id'); 

        // Format the open and close hours to be written as 08:00
        $formattedOpenHours = Carbon::parse($user->open_hours_for_admin)->locale('id')->translatedFormat('H:i');
        $formattedCloseHours = Carbon::parse($user->close_hours_for_admin)->locale('id')->translatedFormat('H:i');

        // Display all Course that are Active and is owned by the owner/admin
        $course = Course::query()->where('course_availability', 1)->where('admin_id', auth()->id())->get();
        // Display only Manual Course that are Active and is owned by the owner/admin
        $courseManual = Course::query()->where('course_availability', 1)->where('admin_id', auth()->id())->where('car_type', 'Manual')->orwhere('car_type', 'Both')->get();
        // Display only Matic Course that are Active and is owned by the owner/admin
        $courseMatic = Course::query()->where('course_availability', 1)->where('admin_id', auth()->id())->where('car_type', 'Matic')->orwhere('car_type', 'Both')->get();
        // Display only Quick Course that are Active and is owned by the owner/admin
        $courseQuick = Course::query()->where('course_availability', 1)->where('admin_id', auth()->id())->where('course_length', '<', 4)->get();

        // Calculate the average of all of the active course_length
        $averageCourseLength = (int) $course->avg('course_length');

        // Get minimum course price
        $minCoursePrice = (int) $course->min('course_price');
        // Get maximum course price
        $maxCoursePrice = (int) $course->max('course_price'); 

        // Format minimum coursePrice, when it passes the million digits, change it to 'jt', below that write 'rb' instead
        $minCoursePrice = $minCoursePrice >= 1000000 ? number_format($minCoursePrice / 1000000, 1) . 'jt' : number_format($minCoursePrice / 1000) . 'rb';
        // Format minimum coursePrice, when it passes the million digits, change it to 'jt', below that write 'rb' instead
        $maxCoursePrice = $maxCoursePrice >= 1000000 ? number_format($maxCoursePrice / 1000000, 1) . 'jt' : number_format($maxCoursePrice / 1000) . 'rb';

        return view('admin-page.admin-course', [
            "pageName" => "Halaman Kursus Anda | ",
            "formattedOpenHours" => $formattedOpenHours,
            "formattedCloseHours" => $formattedCloseHours,
            "course" => $course,
            "courseManual" => $courseManual,
            "courseMatic" => $courseMatic,
            "courseQuick" => $courseQuick,
            "averageCourseLength" => $averageCourseLength,
            "minCoursePrice" => $minCoursePrice,
            "maxCoursePrice" => $maxCoursePrice,
        ]);
    }

    // Admin-Profile Page Controller
    public function profilePage() {
        return view('profile.admin-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    // Admin-Driving-School-License Page Controller
    public function drivingSchoolLicensePage() {
        // Assign the current authenticated user ID to $adminId
        $adminId = auth()->id();
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');
    
        // Get today's date and localized it to Indonesian
        $today = Carbon::today();
    
        // Collect every drivingschoollicense that are owned by this owner/admin and sort it from the latest added license
        $drivingSchoolLicenses = DrivingSchoolLicense::where('admin_id', $adminId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Set a default value to detect if admin/owner has an active license
        $hasActiveLicense = false;    

        // Run through the drivingschoollicense collection
        foreach ($drivingSchoolLicenses as $license) {
            // Localize the startLicenseDate to Indonesian
            $startDate = Carbon::parse($license->startLicenseDate);
            // Localize the endLicenseDate to Indonesian
            $endDate = Carbon::parse($license->endLicenseDate);
    
            // Avoid license that has licenseStatus of "Belum Divalidasi"
            if ($license->licenseStatus !== 'Belum Divalidasi') {
                // If today's date is between the startLicenseDate and endLicenseDate 
                if ($startDate->lte($today) && $endDate->gt($today)) {
                    // Change the licenseStatus to "Aktif"
                    $license->licenseStatus = 'Aktif';
                    // change the $hasActiveLicense to true, since we has an active license
                    $hasActiveLicense = true;
                } 
                
                // if today's date is way past the endLicenseDate
                elseif ($endDate->lt($today)) {
                    // Change the licenseStatus to "Tidak Berlaku"
                    $license->licenseStatus = 'Tidak Berlaku';
                }

                // Update the license data
                $license->save();
            }
    
            // Localize the startLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
            $license->formattedStartDate = Carbon::parse($license->startLicenseDate)->locale('id')->translatedFormat('d M Y');
            // Localize the endLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
            $license->formattedEndDate = Carbon::parse($license->endLicenseDate)->locale('id')->translatedFormat('d M Y');
        }
    
        // Update user availability based on license status
        $user = User::find($adminId);
        // If admin/owner has active license and current user availability is 0, activate admin/owner by changing the user availability to 1
        if ($hasActiveLicense && $user->availability === 0) {
            $user->availability = true;
            $user->save();
        } 
        
        // If admin/owner has no active license and current user availability is 1, deactivate admin/owner by changing the user availability to 0
        elseif (!$hasActiveLicense && $user->availability === 1) {
            $user->availability = false;
            $user->save();
        }
    
        // Find the first drivingschoollicense that has licenseStatus of "Aktif"
        $activeDrivingSchoolLicense = $drivingSchoolLicenses->firstWhere('licenseStatus', 'Aktif');
    
        return view('admin-page.driving-school-license', [
            "pageName" => "Izin Penyelenggaraan Kursus Anda | ",
            "activeLicense" => $activeDrivingSchoolLicense,
            "licenses" => $drivingSchoolLicenses,
        ]);
    }

    // Admin-Driving-School-License/Create Page Controller
    public function drivingSchoolLicenseForm() {
        return view('admin-page.create-driving-school-license', [
            "pageName" => "Unggah Izin Penyelenggaraan Kursus Baru | ",
        ]);
    }

    // Admin-Profile/Edit Page Controller
    public function editProfilePage() {
        // Collect every payment method that are owned by this admin/owner
        $paymentMethod = PaymentMethod::where('admin_id', auth()->id())->get();

        // Run through every payment method in every collection, then decrypt it
        foreach ($paymentMethod as $methodOfPayment) {
            $methodOfPayment->payment_address = Crypt::decryptString($methodOfPayment->payment_address);
        }

        // Check for active driving school licenses
        $hasActiveLicense = DrivingSchoolLicense::where('admin_id', auth()->id())
            ->where('licenseStatus', 'Aktif')
            ->exists();

        return view('profile.edit-admin-profile', [
            "pageName" => "Edit Profil | ",
            "paymentMethod" => $paymentMethod,
            "hasActiveLicense" => $hasActiveLicense,
        ]);
    }

    // Edit Account Information Logic Handler
    public function editAccountInfo(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . Auth::id(),
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20',
            'availability' => 'required|boolean',
            'open_hours_for_admin' => 'required|date_format:H:i',
            'close_hours_for_admin' => 'required|date_format:H:i',
        ],
        
        // Validation Error Messages
        [
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
            'open_hours_for_admin.required' => 'Jam buka harus diisi',
            'close_hours_for_admin.required' => 'Jam tutup harus diisi',
            'open_hours_for_admin.date_format' => 'Format jam buka tidak valid',
            'close_hours_for_admin.date_format' => 'Format jam tutup tidak valid',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());
        // Immediately update this attribute as per request
        $user->update($request->only(['fullname', 'username', 'description', 'phone_number', 'availability', 'open_hours_for_admin', 'close_hours_for_admin']));

        // Check if users uploaded new profile picture
        $fileName = null;
        if ($request->hasFile('hash_for_profile_picture')) {
            // Delete old pictures
            if ($user->hash_for_profile_picture && Storage::disk('public')->exists("profile_pictures/" . $user->hash_for_profile_picture)) {
                Storage::disk('public')->delete("profile_pictures/" . $user->hash_for_profile_picture);
            }

            // rename the file name to store it inside the database
            $fileName = time() . '.' . $request->hash_for_profile_picture->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $request->hash_for_profile_picture->storeAs('profile_pictures', $fileName);

            // instead of the file updated in database, we save the filename of the file from Laravel Storage
            $user->fill(['hash_for_profile_picture' => $fileName]);
            $user->save();            
        }     

        // Save new User data
        $user->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Profil berhasil diperbarui!');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/admin-profile');
    }

    // Edit Password Logic Handler
    public function editPassword(Request $request) {
        // Validation Rules
        $request->validate([
            'password' => 'nullable|min:5|max:255|confirmed',
            'password_confirmation' => 'nullable|min:5|max:255',
        ],
        
        // Validation Error Messages
        [
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());

        // When users creating new password, do this
        if ($request->has('password') && $request->has('password_confirmation') && !empty($request->password)) {
            // Crypt the new password
            $user->password = bcrypt($request->password);
            // Save the new password to User Tables
            $user->save();
        }

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Password berhasil diubah!');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/admin-profile');
    }
    
    // Change Admin/Owner Availability
    public function changeAvailability(Request $request) {
        // Validation Rules
        $request->validate([
            'availability' => 'required|boolean',
        ]);

        // Find the User data by matching it with the current authenticated user
        $user = auth()->user();

        // When users availability is already false, do this
        if ($user->availability === 0) {
            // Generate a flash message via Toastr to let user know that the process is failed
            $request->session()->flash('error', 'Anda sudah nonaktif');
            // Redirect owner/admin to List of Course Page
            return redirect()->intended('/admin-profile');
        }

        // Change the availability as per request
        $user->availability = $request->availability;
        // Save new data to User Tables
        $user->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Penonaktifan lembaga berhasil!');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/admin-profile');
    }

    // I'll do this later, make sure that we are not deleting an entire data, just, instructor data and their course data, keep the account data
    public function destroy(Request $request)
    {
        // Check for enrollments related to the authenticated user's courses
        $enrollments = Enrollment::whereHas('course', function($query) {
            $query->where('admin_id', auth()->id());
        })->get();

        // Check if any student has an incoming schedule
        $hasIncomingSchedules = $enrollments->some(function($enrollment) {
            return $enrollment->schedule->some(function($schedule) {
                return $schedule->end_time > now(); // Check each schedule's end_time
            });
        });

        if (!$hasIncomingSchedules) {
            $user = Auth::user();
            // Store old user data
            $fullname = $user->fullname;
            $username = $user->username;
            $phone_number = $user->phone_number;

            // Delete the old user
            Auth::logout();
            $user->delete();

            // Create a new user with the same details but different role
            $newUser = User::create([
                'fullname' => $fullname,
                'username' => $username,
                'password' => bcrypt('12345678'),
                'phone_number' => $phone_number,
                'role' => 'user',
            ]);

            // Log in the new user
            Auth::login($newUser);
            $request->session()->flash('success', 'Data Kursus berhasil dihapus. Sekarang anda adalah pengguna umum!');
            return redirect('/user-profile'); // Redirect to user profile
        }

        else {
            $request->session()->flash('error', 'Anda masih memiliki Siswa Aktif! Selesaikan semua kursus dengan Siswa, kemudian Coba Lagi.');
            return redirect()->intended('/admin-profile');
        }

    }

    // Admin-Manage-Course Page Controller
    public function manageCoursePage() {
        // Collect every course that are owned by this owner/admin and sort it from the latest
        $course = Course::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        // Find the User data by matching it with the current authenticated user
        $user = auth()->user();
        return view('admin-page.manage-course', [
            "pageName" => "Daftar Kelas Anda | ",
            "course" => $course,
            "user" => $user,
        ]);
    }

    // Admin-Manage-Course/Create Page Controller
    public function createCoursePage() {
        // Collect every Instructors that are owned by this owner/admin and sort it from the latest, so admin/owner can assigned them to the new added course
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();

        return view('admin-page.create-course', [
            'pageName' => "Tambah Kelas Baru | ",
            'instructors' => $instructors
        ]);
    }

    // Admin-Manage-Course/Edit Page Controller
    public function editCoursePage($username, $course_name) {
        // Get the desired Course that are owned by this owner/admin
        $course = Course::whereHas('admin', function ($query) use ($username) {
            $query->where('username', $username);
        })->where('course_name', $course_name)->firstOrFail();

        // Fetch the course instructors for the current course
        $courseInstructors = DB::table('course_instructors')
                            ->where('course_id', $course->id)
                            ->pluck('instructor_id')
                            ->toArray();

        // Collect every Instructors that are owned by this owner/admin and sort it from the latest, so admin/owner can assigned them to the new added course
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();
        
        return view('admin-page.edit-course', [
            'pageName' => "Edit Kelas | ",
            'course' => $course,
            'instructors' => $instructors,
            'courseInstructors' => $courseInstructors,
        ]);
    }

    // Admin-Manage-Instructor Page Controller
    public function manageInstructorPage() {        
        // Collect every Instructors that are owned by this owner/admin and sort it from the latest
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();

        $today = now()->toDateString();

        // Initialize an array to hold certificates for each instructor
        $instructorCertificates = [];

        // Loop through each instructor
        foreach ($instructors as $instructor) {
            // Get the instructor's ID
            $instructorId = $instructor->id;

            // Fetch the instructor's certificates
            $certificates = instructorCertificate::where('instructor_id', $instructorId)->get();

            // Store the certificates in the array with the instructor ID as the key
            $instructorCertificates[$instructorId] = $certificates;

            // Initialize hasActive for this instructor
            $hasActive = false;

            // Check each certificate for the current instructor
            foreach ($certificates as $certificate) {
                if ($today >= $certificate->startCertificateDate && $today <= $certificate->endCertificateDate) {
                    if ($certificate->certificateStatus !== 'Belum Divalidasi') {
                        $certificate->certificateStatus = 'Aktif';
                        $hasActive = true; // Set hasActive to true if there's an active certificate
                    }
                } elseif ($today > $certificate->endCertificateDate) {
                    $certificate->certificateStatus = 'Tidak Berlaku';
                }
                $certificate->save(); // Save the updated certificate status
            }

            // Update instructor availability if no active certificates
            if (!$hasActive) {
                $instructor->availability = 0; // Set availability to 0 if no active certificates
                $instructor->save(); // Save the updated instructor availability
            } 
            // Update instructor availability immediately if they have an active certificates
            elseif ($hasActive) {
                $instructor->availability = 1; // Set availability to 1 if we detect active certificates
                $instructor->save(); // Save the updated instructor availability
            }
            
        }

        return view('admin-page.manage-instructor', [
            "pageName" => "Daftar Instruktur Anda | ",
            "instructors" => $instructors,
        ]);
    }

    // Admin-Manage-Instructor/Create Page Controller
    public function createInstructorPage() {
        return view('admin-page.create-instructor', [
            'pageName' => "Tambah Instruktur Baru | "
        ]);
    }

    // Admin-Course/Active-Student-List Page Controller
    public function activeStudentPage() {
        // Find the active student by searching Enrollment Tables that the Course is owned by this admin/owner
        $activeEnrolledStudent = Enrollment::query()->whereHas('course', function($query) {
            $query->where('admin_id', auth()->id());
        })
        ->with('schedule')->get(); // Load schedules with the enrollment

        $now = now(); // Get current date and time

        // Run through every active student schedules
        foreach ($activeEnrolledStudent as $activeStudent) {
            // Ensure schedules are loaded
            if ($activeStudent->schedule->isNotEmpty()) {
                // Collect the upcoming schedule by run through every schedule this student has
                $upcomingSchedule = $activeStudent->schedule->filter(function ($schedule) use ($now) {
                    // Let's say student has 5 meetings in total. If current date and time is passed the first and second meetings. Skip it, only return upcoming schedule.
                    return $schedule->start_time >= $now; 
                })->first(); // Find the first / closest upcoming schedule
                
                // Get the meeting number if an upcoming schedule exists
                $activeStudent->meeting_number = $upcomingSchedule ? $upcomingSchedule->meeting_number : null;

                // Get the next course date if an upcoming schedule exists
                if ($upcomingSchedule) {
                    // Localize the date and time to Indonesian
                    Carbon::setLocale('id'); 
                    // Localize next_course_date in Indonesian and format it to be written as "15 Agustus 2024"
                    $activeStudent->next_course_date = Carbon::parse($upcomingSchedule->start_time)->locale('id')->translatedFormat('d F Y'); 

                    // Localize course_time in Indonesian and format it to be written as "08:00 - 09:30 WIB"
                    $activeStudent->course_time = Carbon::parse($upcomingSchedule->start_time)->format('H:i') . ' - ' . Carbon::parse($upcomingSchedule->end_time)->format('H:i') . ' WIB'; // Format the time

                } 
                
                // Display nothing when there's no upcoming schedules
                else {
                    $activeStudent->next_course_date = null; 
                    $activeStudent->course_time = null; 
                }
            } 
            
            // Display nothing when there's schedules exist
            else {
                $activeStudent->meeting_number = null; 
                $activeStudent->next_course_date = null; 
                $activeStudent->course_time = null; 
            }
        }

        return view('admin-page.admin-active-student', [
            'pageName' => "Daftar Siswa Aktif | ",
            'activeEnrolledStudent' => $activeEnrolledStudent,
        ]);
    }

    // Admin-Course-Progress Page Controller
    public function courseProgressPage($student_fullname, $enrollment_id) {        
        // Find the enrollment data for this student
        $enrollment = Enrollment::with(['schedule', 'coursePayment'])->find($enrollment_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the current date and time
        $now = now();

        $upcomingSchedule = $enrollment->schedule->filter(function ($schedule) use ($now) {
            // Let's say student has 5 meetings in total. If current date and time is passed the first and second meetings. Skip it, only return upcoming schedule.
            return $schedule->start_time >= $now; 
        })->first(); // Find the first / closest upcoming schedule

        // Get the current meeting number if an upcoming schedule exists
        $currentMeetingNumber = $upcomingSchedule ? $upcomingSchedule->meeting_number : null;

        // Format the schedule dates
        foreach ($enrollment->schedule as $schedule) {
            $schedule->formatted_date = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('l, d F Y');
            $schedule->formatted_time = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('H:i');
        }

        return view('admin-page.admin-course-progress', [
            'pageName' => "Detail Progress Kursus Siswa | ",
            'enrollment' => $enrollment,
            'currentMeetingNumber' => $currentMeetingNumber,
        ]);
    }

    public function registrationForm($student_real_name, $enrollment_id) {
        // Find the enrollment data for this student
        $enrollment = Enrollment::findOrFail($enrollment_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        return view('admin-page.admin-course-registration-form', [
            'pageName' => "Formulir Pendaftaran Kursus | ",
            'enrollment' => $enrollment
        ]);
    }

    public function paymentVerification($student_real_name, $enrollment_id) {
        // Find the enrollment data for this student
        $enrollment = Enrollment::findOrFail($enrollment_id);

        if (!$enrollment->coursePayment) {
            // Generate a flash message via Toastr to let user know that the process is successful
            session()->flash('info', 'Siswa belum mengunggah bukti pembayaran. Silahkan coba lagi nanti!');
            // Redirect owner/admin to List of Course Page
            return redirect(url('/admin-course-progress/' . $student_real_name . '/' . $enrollment_id));
        }

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        return view('admin-page.admin-course-payment-verification', [
            'pageName' => "Verifikasi Bukti Pembayaran | ",
            'enrollment' => $enrollment
        ]);
    }

    public function newScheduleForm($course_schedule_id) {
        $schedule = CourseSchedule::findOrFail($course_schedule_id);

        // Collect every Instructors that are owned by this owner/admin and sort it from the latest, so admin/owner can assigned them to the new added course
        $instructors = User::query()->where('admin_id', auth()->id())->orderBy('created_at', 'desc')->get();

        $openTime = \Carbon\Carbon::parse(auth()->user()->open_hours_for_admin);
        $closeTime = \Carbon\Carbon::parse(auth()->user()->close_hours_for_admin);
        $courseDuration = $schedule->course->course_duration;

        // Get start and end time from schedule
        $startTime = \Carbon\Carbon::parse($schedule->start_time);
        $endTime = \Carbon\Carbon::parse($schedule->end_time);

        $availableSlots = [];

        while ($openTime->lessThan($closeTime)) {
            $endOptionTime = $openTime->copy()->addMinutes($courseDuration);
    
            if ($endOptionTime->greaterThan($closeTime)) {
                break; // Exit the loop if it exceeds
            }
    
            // Skip lunch break
            if ($openTime->between('11:30', '13:30', true) || $endOptionTime->between('11:30', '13:30', true)) {
                $openTime->addMinutes($courseDuration);
                continue;
            }
    
            // Add the slot to available slots
            $availableSlots[] = [
                'start' => $openTime->format('H:i'),
                'end' => $endOptionTime->format('H:i'),
            ];
    
            $openTime->addMinutes($courseDuration);
        }

        return view('admin-page.admin-course-new-schedule', [
            'pageName' => "Ajukan Jadwal Baru | ",
            'schedule' => $schedule,
            'instructors' => $instructors,
            'availableSlots' => $availableSlots,
        ]);
    }
}