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
            // Fetch random courses
            $randomCourses = Course::inRandomOrder()->take(10)->get(); // Fetch more than 6 to increase chances

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

        return view('home.user', [
            "pageName" => "Beranda | ",
            "incomingSchedule" => $incomingSchedule,
            "availableCourses" => $availableCourses,
        ]);
    }
}
