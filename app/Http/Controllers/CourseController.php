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
        $course = Course::find($request->course_id);

        if ($course) {
            $course->course_availability = 0;
            $course->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 400);
    }

    public function activateCourse(Request $request) {
        $course = Course::find($request->course_id);
        if ($course) {
            $course->course_availability = 1;
            $course->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
