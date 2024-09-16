<?php

namespace App\Http\Controllers;

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
}
