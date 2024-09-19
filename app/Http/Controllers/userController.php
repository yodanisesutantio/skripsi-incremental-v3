<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\Enrollment; // Access Enrollment Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class userController extends Controller
{
    // User-Index Page Controller
    public function userIndex() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Find the enrollment ID by comparing student_id with the authenticated user's ID
        $enrollment = Enrollment::where('student_id', auth()->id())->first();
        $enrollment_id = $enrollment ? $enrollment->id : null; // Return null if not found

        $incomingSchedule = null; // Initialize to null
        // Only run the query if enrollment_id is not null
        if ($enrollment_id) {
            $incomingSchedule = CourseSchedule::where('enrollment_id', $enrollment_id)
                ->where('start_time', '>', now()) // Filter for upcoming schedules
                ->orderBy('start_time', 'asc') // Order by start time
                ->first(); // Get the first upcoming schedule
        }

        // Localize the startLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
        if ($incomingSchedule) {
            $incomingSchedule->formattedStartDate = Carbon::parse($incomingSchedule->start_time)->translatedFormat('d F Y');
            $incomingSchedule->formattedStartTime = Carbon::parse($incomingSchedule->start_time)->translatedFormat('H:i');
            $incomingSchedule->formattedEndTime = Carbon::parse($incomingSchedule->end_time)->translatedFormat('H:i');
        }

        // Initialize an empty collection for available courses
        $availableCourses = collect();

        // Keep fetching random courses until we have 6 available ones
        while ($availableCourses->count() < 6) {
            // Fetch random courses as Recommendation
            $randomCourses = Course::inRandomOrder()->take(3)->get(); // Fetch more than 6 to increase chances

            // Filter courses based on availability and enrollment
            $filteredCourses = $randomCourses->filter(function ($course) {
                $activeEnrollmentsCount = $course->enrollments->filter(function ($enrollment) {
                    return $enrollment->schedule->contains(function ($schedule) {
                        return $schedule->end_time > now();
                    });
                })->count();

                // Check if the course is available and not filled
                return $course->course_availability === 1 && $activeEnrollmentsCount < $course->course_quota;
            });

            // Merge the filtered courses into the availableCourses collection
            $availableCourses = $availableCourses->merge($filteredCourses);

            // If we have more than 6, slice it to keep only the first 6
            if ($availableCourses->count() > 6) {
                $availableCourses = $availableCourses->take(6);
            }
        }

        // Fetch Random Driving School to use as Recommendation
        $randomDrivingSchool = User::where('role', 'admin')
            ->where('availability', 1) // Check if availability is 1
            ->inRandomOrder()
            ->take(4) // Limit to 4 driving schools
            ->get();

        return view('home.user', [
            "pageName" => "Beranda | ",
            "incomingSchedule" => $incomingSchedule,
            "availableCourses" => $availableCourses,
            "randomDrivingSchool" => $randomDrivingSchool,
        ]);
    }

    // User-Profile Page Controller
    public function userProfile() {
        return view('profile.user-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    // User-Profile/Edit Page Controller
    public function editProfilePage() {
        return view('profile.edit-user-profile', [
            "pageName" => "Edit Profil | ",
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
            'age' => 'nullable|integer|min:18|max:70',
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
            'age.integer' => 'Masukkan angka yang valid',
            'age.min' => 'Usia minimal yang diizinkan adalah 18 tahun',
            'age.max' => 'Usia maksimal yang diizinkan adalah 70 tahun',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());
        // Immediately update this attribute as per request
        $user->update($request->only(['fullname', 'username', 'description', 'age', 'phone_number']));

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
        }     

        // Format phone number to +62 and remove non-numeric characters
        $cleanedPhoneNumber = preg_replace('/\D/', '', $request['phone_number']); // Remove non-numeric characters
        $user->phone_number = preg_replace('/^(0|62)/', '+62', $cleanedPhoneNumber);

        // Save new User data
        $user->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Profil berhasil diperbarui!');
        // Redirect user to List of Course Page
        return redirect()->intended('/user-profile');
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
        // Redirect user to profile page
        return redirect()->intended('/user-profile');
    }

    public function deleteAccountPermanently() {
        // Find the desired course
        $user = User::findOrFail(auth()->id());

        // Check if the user has any upcoming schedules
        $hasUpcomingSchedule = Enrollment::where('student_id', auth()->id())
            ->whereHas('schedule', function ($query) {
                $query->where('start_time', '>', now());
            })->exists();

        if ($hasUpcomingSchedule) {
            session()->flash('error', 'Anda masih memiliki kursus berlangsung, Silahkan coba lagi jika kursus anda sudah selesai!');
            return redirect('/user-profile');
        }
    
        // Delete the thumbnail from storage
        if ($user->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $user->hash_for_profile_picture);
        }

        // Delete the chosen user
        $user->delete();
        // Redirect the admin to List of Instructor Page
        return redirect('/');
    }

    // Course Registration Form Page Controller
    public function courseRegistrationForm($course_name, $course_id) {
        // Find the enrollment data for this student
        $course = Course::findOrFail($course_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        return view('student-page.course-registration-form', [
            "pageName" => "Form Pendaftaran Kursus | ",
            "course" => $course,
        ]);
    }

    public function courseProgressPage($student_fullname, $enrollment_id) {        
        // Find the enrollment data for this student
        $enrollment = Enrollment::with(['schedule', 'coursePayment'])->find($enrollment_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the current date and time
        $now = now();

        // Check if the course is completed
        $isCourseCompleted = $enrollment->schedule->every(function ($schedule) use ($now) {
            return $schedule->end_time < $now; // All meetings have ended
        });

        if (!$isCourseCompleted) {
            $upcomingSchedule = $enrollment->schedule->filter(function ($schedule) use ($now) {
                return $schedule->start_time >= $now; 
            })->first(); // Find the first / closest upcoming schedule

            // Get the current meeting number if an upcoming schedule exists
            $currentMeetingNumber = $upcomingSchedule ? $upcomingSchedule->meeting_number : null;
        } else {
            if ($enrollment->schedule->isEmpty()) {
                $currentMeetingNumber = 1; // Or set to a specific value if needed
            } else {
                $currentMeetingNumber = $enrollment->course->course_length + 1; // Or set to a specific value if needed
            }
        }

        // Get new collection of the real schedules
        $courseSchedules = $enrollment->schedule;
        // Run through every real schedules
        foreach ($courseSchedules as $courseSchedule) {
            // Then check if there's proposed schedule
            $proposedSchedule = $courseSchedule->proposedSchedule;
            // Check if the proposed schedule is all agreed. If do, update the real schedule based on the proposed schedule. After update, delete the agreed proposed schedule
            if ($proposedSchedule && $proposedSchedule->instructor_decision == 1 && $proposedSchedule->student_decision == 1) {
                $courseSchedule->start_time = $proposedSchedule->start_time;
                $courseSchedule->end_time = $proposedSchedule->end_time;
                $courseSchedule->instructor_id = $proposedSchedule->instructor_id;
                $courseSchedule->save();
                $proposedSchedule->delete();
            } 
            // When the proposed schedule is not getting agreed, but the next current schedule is under the 24 hours, cancel that proposed schedule
            elseif ($proposedSchedule && $courseSchedule->start_time < $now->addHours(24)) {
                $proposedSchedule->delete();
            }
        }

        // Format the schedule dates
        foreach ($enrollment->schedule as $schedule) {
            $schedule->formatted_date = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('l, d F Y');
            $schedule->formatted_time = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('H:i');
        }

        return view('student-page.user-course-progress', [
            'pageName' => "Detail Progress Kursus Siswa | ",
            'enrollment' => $enrollment,
            'currentMeetingNumber' => $currentMeetingNumber,
        ]);
    }
}
