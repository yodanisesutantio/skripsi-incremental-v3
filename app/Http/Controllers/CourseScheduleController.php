<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseSchedule; // Access User Tables
use App\Models\ProposedSchedule; // Access User Tables

class CourseScheduleController extends Controller
{
    public function proposeNewSchedule(Request $request, $course_schedule_id) {
        // Validation Rules and Error Message
        $request->validate([
            'course_date' => 'required|date',
            'course_time' => 'required',
            'instructor_ids' => 'required|array',
            'instructor_ids.*' => 'exists:users,id',
        ],[
            'course_date.required' => 'Silahkan Pilih Tanggal Kursus',
            'course_time.required' => 'Silahkan Pilih Salah Satu Opsi',
            'instructor_ids.required' => 'Silahkan Pilih Salah Satu Instruktur',
        ]);

        // Split course_time from for example : 09:30 - 11:00 into start_time : 09:30 and end_time 11:00
        list($start_time_str, $end_time_str) = explode(' - ', $request->course_time);

        // Since we assign $start_time and $end_time as datetime in the database, we should combine both the start_time and end_time with course_date so it will saved as 2024-11-09 09:30 for start_time and 2024-11-09 11:00 for end_time
        $start_time = \Carbon\Carbon::parse($request->course_date . ' ' . $start_time_str);
        $end_time = \Carbon\Carbon::parse($request->course_date . ' ' . $end_time_str);

        // When Users accidentally entered a schedule less than the current time, return error
        if ($start_time < now()->addHours(24) || $end_time < now()->addHours(24)) {
            $request->session()->flash('error', 'Pastikan jadwal baru berlangsung tidak kurang dari 24 jam');
            return redirect()->back();
        }

        // Find any conflicting schedule if any
        foreach ($request->instructor_ids as $instructor_id) {
            $existingSchedule = CourseSchedule::where(function ($query) use ($instructor_id, $start_time, $end_time) {
                $query->where('instructor_id', $instructor_id)
                    ->where(function ($q) use ($start_time, $end_time) {
                        $q->whereBetween('start_time', [$start_time, $end_time])
                            ->orWhereBetween('end_time', [$start_time, $end_time])
                            ->orWhere(function ($q) use ($start_time, $end_time) {
                                $q->where('start_time', '<=', $start_time)
                                    ->where('end_time', '>=', $end_time);
                            });
                    });
            })->first();
    
            // When there's a conflicting schedule, return error
            if ($existingSchedule) {
                $request->session()->flash('error', 'Instruktur ' . $existingSchedule->instructor->fullname . ' sudah memiliki kursus pada jam ' . $request->course_time . '. Silahkan Ubah Opsi Tanggal atau Jam Kursus');
                return redirect()->back();
            }
    
            // But when the requested schedule didn't have any conflict, update the courseSchedule
            $newSchedule = CourseSchedule::find($course_schedule_id);
            $newSchedule->instructor_id = $instructor_id;
            $newSchedule->start_time = $start_time;
            $newSchedule->end_time = $end_time;
            $newSchedule->save();
        }

        $request->session()->flash('success', 'Jadwal berhasil diubah. Informasikan perubahan ini ke Instruktur dan Siswa Bersangkutan');
        return redirect(url('/admin-course-progress/' . $newSchedule->enrollment->student_real_name . '/' . $newSchedule->enrollment->id));
    }

    // Test Schedule Controller
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
