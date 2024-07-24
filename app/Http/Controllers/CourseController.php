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
        // dd($request->all());
        $request->validate([
            'course_availability' => 'required|boolean',
        ]);

        $user = auth()->user();

        $course = Course::find($request->course_id);
        $course->course_availability = $request->course_availability;
        $course->save();

        return redirect()->intended('/admin-manage-course');
    }

    public function activateCourse(Request $request) {
        // dd($request->all());
        $request->validate([
            'course_availability' => 'required|boolean',
        ]);

        $user = auth()->user();

        $course = Course::find($request->course_id);
        $course->course_availability = $request->course_availability;
        $course->save();

        return redirect()->intended('/admin-manage-course');
    }
}
