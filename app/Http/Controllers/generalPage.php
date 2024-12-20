<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\course; // Access Course Tables
use App\Models\SearchHistory; // Access Course Tables
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel
use Illuminate\Http\Request; // Use Request Method by Laravel

class generalPage extends Controller
{
    public function landing() {
        return view('landing', [
            "pageName" => "Selamat Datang di "
        ]);
    }

    public function forgotPasswordPage() {
        return view('forgot-password', [
            "pageName" => "Lupa Password | "
        ]);
    }
    public function forgotPasswordUsername($username) {
        $user = User::where('username', $username)->first();

        // If the username does not exist, redirect back with an error message
        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Username tidak ditemukan']);
        }

        return view('forgot-password-challenge', [
            "pageName" => "Lupa Password | ",
            "user" => $user
        ]);
    }
    public function forgotPasswordPhoneNumber($phone_number) {
        $user = User::where('phone_number', $phone_number)->first();

        // If the phone_number does not exist, redirect back with an error message
        if (!$user) {
            return redirect()->back()->withErrors(['phone_number' => 'No. Whatsapp tidak ditemukan']);
        }

        return view('forgot-password-challenge', [
            "pageName" => "Lupa Password | ",
            "user" => $user
        ]);
    }

    public function passwordChallenge(Request $request, $username) {
        // Validation Rules
        $request->validate([
            'fp_answer' => 'required',
        ],
        
        // Validation Error Messages
        [
            'fp_answer.required' => 'Kolom ini harus diisi',
        ]);

        $user = User::where('username', $username)->first();

        try {
            // Decrypt the stored answer
            $correctAnswer = Crypt::decryptString($user->fp_answer);
        } catch (\Exception $e) {
            // Handle the decryption error
            return redirect()->back()->withErrors(['fp_answer' => 'Unable to validate answer.']);
        }

        // If the fp_answer is wrong, redirect back with errors
        if ($request->fp_answer !== $correctAnswer) {
            return redirect()->back()->withErrors(['fp_answer' => 'Jawaban Salah. Coba lagi!']);
        }

        return redirect()->route('reset-password', ['username' => $username]);
    }

    public function resetPasswordForm($username) {
        $user = User::where('username', $username)->first();

        return view('reset-password', [
            "pageName" => "Lupa Password | ",
            "user" => $user
        ]);
    }

    public function about() {
        return view('about-app', [
            "pageName" => "Tentang Aplikasi |  "
        ]);
    }

    public function contact() {
        return view('contact-us', [
            "pageName" => "Hubungi Kami | "
        ]);
    }

    public function appIntro() {
        return view('app-intro', [
            "pageName" => "Selamat Datang di "
        ]);
    }

    public function tamu() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');
        // Initialize an empty collection for available courses
        $availableCourses = collect();

        // Keep fetching random courses until we have 6 available ones
        while ($availableCourses->count() < 6) {
            // Fetch random courses as Recommendation
            $randomCourses = course::inRandomOrder()->take(3)->get(); // Fetch more than 6 to increase chances

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

        return view('home.tamu', [
            "pageName" => "Beranda Tamu | ",
            "availableCourses" => $availableCourses,
            "randomDrivingSchool" => $randomDrivingSchool,
        ]);
    }

    // Search Page Controller
    public function searchPage() {
        $userSearchHistory = auth()->check()
            ? SearchHistory::where('user_id', auth()->id())->get()
            : collect(); // Return an empty collection for guests

        return view('search', [
            "pageName" => "Pencarian | ",
            "userSearchHistory" => $userSearchHistory,
        ]);
    }

    // Search Results Page Controller
    public function searchResult(Request $request) {
        // Catch the entered Search Query
        $searchQuery = $request->input('searchQuery');

        // Find the closest Course that has the same name as the entered Search Query
        $courseResults = course::where('course_name', 'LIKE', "%{$searchQuery}%")
            ->where('course_availability', 1) // Check if course is available
            ->whereHas('admin', function($query) {
                $query->where('availability', 1); // Check if admin is available
            })
            ->where(function ($subQuery) { // Renamed to $subQuery
                $subQuery->doesntHave('enrollments') // Include courses with no enrollments
                          ->orWhere(function ($enrollmentQuery) { // Renamed to $enrollmentQuery
                              $enrollmentQuery->whereHas('enrollments', function ($scheduleQuery) {
                                  $scheduleQuery->whereHas('schedule', function ($timeQuery) {
                                      $timeQuery->where('end_time', '>', now());
                                  });
                              })
                              ->havingRaw('COUNT(enrollments.id) < course_quota'); // Check if active students are less than course quota
                          });
            })
            ->get();

        // dd($courseResults);
        
        // Find the closest Driving School that has the same name as the entered Search Query
        $drivingSchoolResults = User::where('role', 'admin')
            ->where('availability', 1)
            ->where(function ($adminQuery) use ($searchQuery) {
                $adminQuery->where('fullname', 'LIKE', "%{$searchQuery}%") // Match admin name
                           ->orWhereHas('courses', function ($courseQuery) use ($searchQuery) {
                               $courseQuery->where('course_name', 'LIKE', "%{$searchQuery}%"); // Match course name
                           });
            })
            ->get();

        // dd($drivingSchoolResults);

        // Check if the searching process returning a result, if no, return user
        if ($courseResults->isEmpty() && $drivingSchoolResults->isEmpty()) {
            session()->flash('warning', 'Hasil Tidak Ditemukan. Coba cari dengan kata kunci lain');
            return redirect()->back();
        }

        // Check if the search query already exists for the user
        $existingSearch = SearchHistory::where('user_id', auth()->check() ? auth()->id() : null)
            ->where('searchQuery', $searchQuery)
            ->first();

        // Only create a new search history if it doesn't exist
        if (!$existingSearch) {
            SearchHistory::create([
                'user_id' => auth()->check() ? auth()->id() : null, // Store the ID of the logged-in user or null for guests
                'searchQuery' => $searchQuery
            ]);
        }

        return view('search-result', [
            "pageName" => "Hasil Pencarian | ",
            "searchQuery" => $searchQuery,
            "courseResults" => $courseResults,
            "drivingSchoolResults" => $drivingSchoolResults,
        ]);
    }

    // To delete the Search History by clicking the X icon beside the Search History Query
    public function deleteSearchHistoryItem($id) {
        // Find the search history item by ID
        $searchHistory = SearchHistory::find($id);

        // Check if the item exists and belongs to the authenticated user
        if ($searchHistory && ($searchHistory->user_id === auth()->id() || is_null($searchHistory->user_id))) {
            $searchHistory->delete(); // Delete the item
            return response()->json(['success' => true, 'message' => 'Search history deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Search history not found.'], 404);
    }

    public function courseDetailsPage($course_name, $course_id) {
        $classProperties = course::find($course_id);

        // Fetch instructors related to the course
        $instructorArray = $classProperties->courseInstructors;

        // Fetch similar courses based on course_length or similar course_price, limited to 5
        $offered = course::where('id', '!=', $classProperties->id) // Exclude the current course
            ->where('course_availability', 1) // Check if course is available
            ->whereHas('admin', function($query) {
                $query->where('availability', 1); // Check if admin is available
            })
            ->where(function($query) use ($classProperties) {
                $query->where('course_length', $classProperties->course_length)
                      ->orWhere('course_price', '<=', $classProperties->course_price * 1.5)
                      ->orWhere('course_price', '>=', $classProperties->course_price * 0.6);
            })
            ->take(5) // Limit to 5 results
            ->get();

        return view('course-details', [
            "pageName" => "Detail Kelas | ",
            "classProperties" => $classProperties,
            "instructorArray" => $instructorArray,
            "offered" => $offered,
        ]);
    }

    public function drivingSchoolCoursePage($admin_username) {
        // Fetch the driving school by username instead of ID
        $drivingSchool = User::where('username', $admin_username)->first();

        // Localize the date and time to Indonesian
        Carbon::setLocale('id');

        // Format the open and close hours to be written as 08:00
        $formattedOpenHours = Carbon::parse($drivingSchool->open_hours_for_admin)->locale('id')->translatedFormat('H:i');
        $formattedCloseHours = Carbon::parse($drivingSchool->close_hours_for_admin)->locale('id')->translatedFormat('H:i');

        // Display all Course that are Active and is owned by the owner/admin
        $course = course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->get();

        // Display only Manual Course that are Active and is owned by the owner/admin
        $courseManual = course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where(function($query) {
            $query->where('car_type', 'Manual')->orWhere('car_type', 'Both');
        })->get();

        // Display only Matic Course that are Active and is owned by the owner/admin
        $courseMatic = course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where(function($query) {
            $query->where('car_type', 'Automatic')->orWhere('car_type', 'Both');
        })->get();

        // Display only Quick Course that are Active and is owned by the owner/admin
        $courseQuick = course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where('course_length', '<', 4)->get();

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

        return view('driving-school-course-list', [
            "pageName" => $drivingSchool->fullname,
            "drivingSchool" => $drivingSchool,
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
}
