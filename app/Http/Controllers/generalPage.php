<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use Illuminate\Http\Request; // Use Request Method by Laravel

class generalPage extends Controller
{
    public function landing() {
        return view('landing', [
            "pageName" => "Selamat Datang di "
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
        return view('home.tamu', [
            "pageName" => "Tamu | "
        ]);
    }

    public function courseDetailsPage($course_name, $course_id) {
        $classProperties = Course::find($course_id);

        // Fetch instructors related to the course
        $instructorArray = $classProperties->courseInstructors;

        // Fetch similar courses based on course_length or similar course_price, limited to 5
        $offered = Course::where('id', '!=', $classProperties->id) // Exclude the current course
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
        $course = Course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->get();

        // Display only Manual Course that are Active and is owned by the owner/admin
        $courseManual = Course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where(function($query) {
            $query->where('car_type', 'Manual')->orWhere('car_type', 'Both');
        })->get();

        // Display only Matic Course that are Active and is owned by the owner/admin
        $courseMatic = Course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where(function($query) {
            $query->where('car_type', 'Matic')->orWhere('car_type', 'Both');
        })->get();

        // Display only Quick Course that are Active and is owned by the owner/admin
        $courseQuick = Course::query()->where('course_availability', 1)->where('admin_id', $drivingSchool->id)->where('course_length', '<', 4)->get();

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
