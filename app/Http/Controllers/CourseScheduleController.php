<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use App\Models\courseSchedule; // Access Course Schedule Tables
use App\Models\enrollment; // Access Enrollment Tables

class CourseScheduleController extends Controller
{
    // Admin Update schedule logic controller
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
            $existingSchedule = courseSchedule::where(function ($query) use ($instructor_id, $start_time, $end_time) {
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
            $newSchedule = courseSchedule::find($course_schedule_id);
            $newSchedule->instructor_id = $instructor_id;
            $newSchedule->start_time = $start_time;
            $newSchedule->end_time = $end_time;
            $newSchedule->save();
        }

        $request->session()->flash('success', 'Jadwal berhasil diubah. Informasikan perubahan ini ke Instruktur dan Siswa Bersangkutan');
        return redirect(url('/admin-course-progress/' . $newSchedule->enrollment->student_real_name . '/' . $newSchedule->enrollment->id));
    }

    // Test Schedule Controller
    // public function testSchedule1(Request $request) {
    //     $request->ins_id = 6;
    //     $request->stime = '2024-08-11 08:00:00';
    //     $request->etime = '2024-08-11 09:30:00';

    //     $existingSchedule = courseSchedule::where(function ($query) use ($request) {
    //         $query->where('instructor_id', $request->ins_id)
    //               ->where(function ($q) use ($request) {
    //                   $q->whereBetween('start_time', [$request->stime, $request->etime])
    //                     ->orWhereBetween('end_time', [$request->stime, $request->etime])
    //                     ->orWhere(function ($q) use ($request) {
    //                         $q->where('start_time', '<=', $request->stime)
    //                           ->where('end_time', '>=', $request->etime);
    //                     });
    //               });
    //     })->first();

    //     if ($existingSchedule) {
    //         dd('gagal'); // Iki ganti return error
    //     }

    //     $schedule = courseSchedule::find(1);
    //     $schedule->enrollment_id = 1;
    //     $schedule->course_id = 1;
    //     $schedule->instructor_id = $request->ins_id;
    //     $schedule->start_time = $request->stime;
    //     $schedule->end_time = $request->etime;
    //     $schedule->meeting_number = 4;
    //     $schedule->theoryStatus = 0;
    //     $schedule->quizStatus = 0;
    //     $schedule->save();

    //     dd('sukses'); // Iki ganti success
    // }

    // User/Student Choose New Schedule Logic Controller
    public function createNewSchedule(Request $request, $student_real_name, $enrollment_id) {
        // Validation Rules and Error Message
        $request->validate([
            'course_date.*' => 'required|date',
            'course_time.*' => 'required',
        ],[
            'course_date.*.required' => 'Silahkan Pilih Tanggal Kursus',
            'course_time.*.required' => 'Silahkan Pilih Salah Satu Opsi',
        ]);

        // dd($request);
    
        // Get the Enrollment Data
        $enrollmentData = enrollment::findOrFail($enrollment_id);
        // Fetch the instructor_id from Enrollment Data
        $instructor_id = $enrollmentData['instructor_id'];
        
        // Array to track selected schedules
        $selectedSchedules = [];
        // Prepare an array to hold new schedules
        $newSchedules = [];

        $current_time = \Carbon\Carbon::now();

        // Assuming course_time is also an array with the same length as course_date
        foreach ($request->course_date as $date_index => $course_date) {
            // Get the corresponding course time for the current date
            if (isset($request->course_time[$date_index])) {
                $course_time = $request->course_time[$date_index];

                // Split course_time into start_time and end_time
                list($start_time_str, $end_time_str) = explode(' - ', $course_time);
                $start_time = \Carbon\Carbon::parse($course_date . ' ' . $start_time_str);
                $end_time = \Carbon\Carbon::parse($course_date . ' ' . $end_time_str);

                // Calculate the minimum allowed start time (24 hours from now)
                $minimum_start_time = \Carbon\Carbon::now()->addHours(24);

                // Check for minimum schedule time
                if ($start_time < $minimum_start_time || $end_time < $minimum_start_time) {
                    $request->session()->flash('error', 'Pastikan jadwal baru berlangsung tidak kurang dari 24 jam');
                    return redirect()->back()->withInput();
                }

                // Check for duplicate schedules in the user's input
                $scheduleKey = $course_date . ' ' . $start_time_str . ' - ' . $end_time_str; // Unique key for the schedule
                if (in_array($scheduleKey, $selectedSchedules)) {
                    $request->session()->flash('error', 'Anda sudah memilih jadwal untuk tanggal ' . $course_date . ' pada jam ' . $course_time . '. Silahkan pilih waktu yang berbeda.');
                    return redirect()->back();
                }
                // Add the schedule to the selected schedules array
                $selectedSchedules[] = $scheduleKey;

                // Check for conflicting schedules
                $existingSchedule = courseSchedule::where('instructor_id', $instructor_id)
                    ->where(function ($query) use ($start_time, $end_time) {
                        $query->whereBetween('start_time', [$start_time, $end_time])
                            ->orWhereBetween('end_time', [$start_time, $end_time])
                            ->orWhere(function ($q) use ($start_time, $end_time) {
                                $q->where('start_time', '<=', $start_time)
                                    ->where('end_time', '>=', $end_time);
                            });
                    })->first();

                // If there's a conflict, return error
                if ($existingSchedule) {
                    $request->session()->flash('error', 'Instruktur ' . $existingSchedule->instructor->fullname . ' sudah memiliki kursus di tanggal ' . $course_date . ' pada jam ' . $course_time . '. Silahkan Ubah Opsi Tanggal atau Jam Kursus');
                    return redirect()->back()->withInput();
                }

                // Prepare the new schedule for later saving
                $newSchedules[] = [
                    'enrollment_id' => $enrollment_id,
                    'course_id' => $enrollmentData->course->id,
                    'instructor_id' => $instructor_id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'meeting_number' => $date_index + 1, // Use date_index + 1 for meeting number
                    'theoryStatus' => 0,
                    'quizStatus' => 0,
                ];
            }
        }

        // dd($newSchedules);

        // Use DB transaction to save all schedules
        DB::transaction(function () use ($newSchedules) {
            foreach ($newSchedules as $scheduleData) {
                $newSchedule = new CourseSchedule();
                $newSchedule->fill($scheduleData);
                $newSchedule->save();
            }
        });
    
        $request->session()->flash('success', 'Jadwal berhasil dibuat. Silahkan hubungi Admin Kursus untuk proses lebih lanjut.');
        return redirect(url('/user-course-progress/' . $student_real_name . '/' . $enrollment_id));
    }

    // The logic for handling logic after student arrive at the last slide of course theory
    public function markTheoryAsDone(Request $request, $enrollment_id, $meeting_number) {
        // Get the current schedules to later mark the Theory Status as done
        $currentSchedule = courseSchedule::where('enrollment_id', $enrollment_id)->where('meeting_number', $meeting_number)->first();

        // Update the theoryStatus
        if ($currentSchedule) {
            $currentSchedule->theoryStatus = 1;
            $currentSchedule->save();

            // Redirect student back to User Course Progress Page
            return redirect(url('/user-course-progress/' . $currentSchedule->enrollment->student_real_name . '/' . $enrollment_id));
        } else {
            session()->flash('error', 'Terjadi Kesalahan. Silahkan coba sekali lagi.');   
            return redirect()->back();
        }
    }

    // The logic for handling logic after student arrive at the last slide of course quiz
    public function markQuizAsDone(Request $request, $enrollment_id, $meeting_number) {
        // Get the current schedules to later mark the Quiz Status as done
        $currentSchedule = courseSchedule::where('enrollment_id', $enrollment_id)->where('meeting_number', $meeting_number)->first();

        // Update the theoryStatus
        if ($currentSchedule) {
            $currentSchedule->quizStatus = 1;
            $currentSchedule->save();

            // Redirect student back to User Course Progress Page
            return redirect(url('/user-course-progress/' . $currentSchedule->enrollment->student_real_name . '/' . $enrollment_id));
        } else {
            session()->flash('error', 'Terjadi Kesalahan. Silahkan coba sekali lagi.');   
            return redirect()->back();
        }
    }
}
