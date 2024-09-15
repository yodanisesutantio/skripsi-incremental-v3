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

        $instructorArray = User::query()->where('admin_id', $classProperties->admin->id)->orderBy('created_at', 'desc')->get();

        return view('course-details', [
            "pageName" => "Detail Kelas | ",
            "classProperties" => $classProperties,
            "instructorArray" => $instructorArray,
        ]);
    }
}
