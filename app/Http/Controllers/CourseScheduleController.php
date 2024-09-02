<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseSchedule; // Access User Tables

class CourseScheduleController extends Controller
{
    public function testSchedule1(Request $request) {

        $request->ins_id = 6;
        $request->stime = '2024-08-11 08:00:00';
        $request->etime = '2024-08-11 09:30:00';

        $existingSchedule = CourseSchedule::where(function ($query) use ($request) {
            $query->where('instructor_id', $request->ins_id)
                  ->where(function ($q) use ($request) {
                      $q->whereBetween('start_time', [$request->stime, $request->etime])
                        ->orWhereBetween('end_time', [$request->stime, $request->etime])
                        ->orWhere(function ($q) use ($request) {
                            $q->where('start_time', '<=', $request->stime)
                              ->where('end_time', '>=', $request->etime);
                        });
                  });
        })->first();

        if ($existingSchedule) {
            dd('gagal'); // Iki ganti return error
        }

        $schedule = CourseSchedule::find(1);
        $schedule->enrollment_id = 1;
        $schedule->course_id = 1;
        $schedule->instructor_id = $request->ins_id;
        $schedule->start_time = $request->stime;
        $schedule->end_time = $request->etime;
        $schedule->meeting_number = 4;
        $schedule->theoryStatus = 0;
        $schedule->quizStatus = 0;
        $schedule->save();

        dd('sukses'); // Iki ganti success
    }
}
