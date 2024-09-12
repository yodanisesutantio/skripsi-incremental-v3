<?php

namespace App\Http\Controllers;

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
        return view('home.user', [
            "pageName" => "Beranda | ",
        ]);
    }
}
