<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

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

        Carbon::setLocale('id'); // This can be set in a service provider or at the start of your controller

        // Split course_time from for example : 09:30 - 11:00 into start_time : 09:30 and end_time 11:00
        list($start_time_str, $end_time_str) = explode(' - ', $request->course_time);

        // Since we assign $start_time and $end_time as datetime in the database, we should combine both the start_time and end_time with course_date so it will saved as 2024-11-09 09:30 for start_time and 2024-11-09 11:00 for end_time
        $start_time = \Carbon\Carbon::parse($request->course_date . ' ' . $start_time_str);
        $end_time = \Carbon\Carbon::parse($request->course_date . ' ' . $end_time_str);

        // When Users accidentally entered a schedule less than the current time, return error
        if ($start_time < now()->addHours(24) || $end_time < now()->addHours(24)) {
            $request->session()->flash('error', 'Jadwal berikutnya tidak bisa berlangsung kurang dari 24 jam. Silahkan coba lagi');
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
                $request->session()->flash('error', 'Instruktur ' . $existingSchedule->instructor->fullname . ' sudah memiliki kursus pada jam ' . $request->course_time . '. Mohon coba dengan tanggal dan jam yang berbeda');
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

    // // User/Student Choose New Schedule Logic Controller
    // public function createNewSchedule(Request $request, $student_real_name, $enrollment_id) {
    //     // Validation Rules and Error Message
    //     $request->validate([
    //         'course_date' => 'required|date',
    //         'course_time' => 'required',
    //     ],[
    //         'course_date.required' => 'Silahkan Pilih Tanggal Kursus',
    //         'course_time.required' => 'Silahkan Pilih Salah Satu Opsi',
    //     ]);

    //     // dd($request);
    
    //     // Get the Enrollment Data
    //     $enrollmentData = enrollment::findOrFail($enrollment_id);
    //     // Fetch the instructor_id from Enrollment Data
    //     $instructor_id = $enrollmentData['instructor_id'];
    //     // Get the course_length
    //     $courseLength = $enrollmentData->course->course_length;
    //     // dd($courseLength);
        
    //     $selectedDates = [];
    //     $currentDate = \Carbon\Carbon::parse($request->course_date);
    //     $i = 0;

    //     while ($i < $courseLength) {
    //         $selectedDates[] = $currentDate->copy();
    //         $currentDate->addWeek();
    //         $i++;
    //     }

    //     // dd($selectedDates);

    //     // Extract start and end times from course_time
    //     list($start_time_str, $end_time_str) = explode(' - ', $request->course_time);

    //     // Validate each selected date for overlapping schedules
    //     foreach ($selectedDates as $selectedDate) {
    //         // Create full datetime for start and end times
    //         $selectedStartTime = \Carbon\Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $start_time_str);
    //         $selectedEndTime = \Carbon\Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $end_time_str);

    //         // Check for existing schedules that overlap
    //         $existingSchedule = courseSchedule::where(function ($query) use ($instructor_id, $selectedStartTime, $selectedEndTime) {
    //             $query->where('instructor_id', $instructor_id)
    //                 ->where(function ($q) use ($selectedStartTime, $selectedEndTime) {
    //                     $q->whereBetween('start_time', [$selectedStartTime, $selectedEndTime])
    //                         ->orWhereBetween('end_time', [$selectedStartTime, $selectedEndTime])
    //                         ->orWhere(function ($q) use ($selectedStartTime, $selectedEndTime) {
    //                             $q->where('start_time', '<=', $selectedStartTime)
    //                                 ->where('end_time', '>=', $selectedEndTime);
    //                         });
    //                 });
    //         })->first();

    //         // When there's a conflicting schedule, return error
    //         if ($existingSchedule) {
    //             $request->session()->flash('error', 'Instruktur ' . $existingSchedule->instructor->fullname . ' sudah terjadwal pada pukul ' . $request->course_time . ' di ' . $selectedDate->format('d F Y') . '. Silakan pilih waktu atau tanggal lain.');
    //             return redirect()->back();
    //         }            
    //     }

    //     $meetingNumber = 1; // Initialize the meeting number counter
    //     // If no conflicts are found, insert new schedules
    //     foreach ($selectedDates as $selectedDate) {
    //         // Create full datetime for start and end times
    //         $selectedStartTime = \Carbon\Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $start_time_str);
    //         $selectedEndTime = \Carbon\Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $end_time_str);

    //         // Create a new course schedule entry
    //         $newSchedule = new courseSchedule();
    //         $newSchedule->enrollment_id = $enrollmentData->id;
    //         $newSchedule->course_id = $enrollmentData->course->id;
    //         $newSchedule->instructor_id = $instructor_id;
    //         $newSchedule->start_time = $selectedStartTime;
    //         $newSchedule->end_time = $selectedEndTime;
    //         $newSchedule->meeting_number = $meetingNumber;
    //         $newSchedule->theoryStatus = 0;
    //         $newSchedule->quizStatus = 0;

    //         // dd($newSchedule);
    //         $newSchedule->save();

    //         $meetingNumber++;
    //     }

    //     // Flash success message and redirect
    //     $request->session()->flash('success', 'Jadwal berhasil dibuat. Silahkan hubungi Admin Kursus untuk proses lebih lanjut.');
    //     return redirect(url('/user-course-progress/' . $student_real_name . '/' . $enrollment_id));
    
    //     $request->session()->flash('success', 'Jadwal berhasil dibuat. Silahkan hubungi Admin Kursus untuk proses lebih lanjut.');
    //     return redirect(url('/user-course-progress/' . $student_real_name . '/' . $enrollment_id));
    // }

    public function storeMeetingData(Request $request, $student_real_name, $enrollment_id, $meeting_number) {
        $request->validate([
            'course_date' => 'required|date',
            'course_time' => 'required',
        ], [
            'course_date.required' => 'Silahkan Pilih Tanggal Kursus',
            'course_time.required' => 'Silahkan Pilih Salah Satu Opsi',
        ]);

        Carbon::setLocale('id'); // This can be set in a service provider or at the start of your controller
        // Get the Enrollment Data
        $enrollmentData = enrollment::findOrFail($enrollment_id);
        // Fetch the instructor_id from Enrollment Data
        $instructor_id = $enrollmentData['instructor_id'];
        // Get the course_length
        $courseLength = $enrollmentData->course->course_length;
        // dd($request);

        // Extract start and end times from course_time
        list($start_time_str, $end_time_str) = explode(' - ', $request->course_time);

        $currentDate = \Carbon\Carbon::parse($request->course_date);

        // Create full datetime for start and end times
        $selectedStartTime = \Carbon\Carbon::parse($currentDate->format('Y-m-d') . ' ' . $start_time_str);
        $selectedEndTime = \Carbon\Carbon::parse($currentDate->format('Y-m-d') . ' ' . $end_time_str);

        // dd($selectedStartTime, $selectedEndTime);

        // Check for conflicts here (but don't store in database yet)
        $existingSchedule = courseSchedule::where(function ($query) use ($instructor_id, $selectedStartTime, $selectedEndTime) {
            $query->where('instructor_id', $instructor_id)
                ->where(function ($q) use ($selectedStartTime, $selectedEndTime) {
                    $q->whereBetween('start_time', [$selectedStartTime, $selectedEndTime])
                        ->orWhereBetween('end_time', [$selectedStartTime, $selectedEndTime])
                        ->orWhere(function ($q) use ($selectedStartTime, $selectedEndTime) {
                            $q->where('start_time', '<=', $selectedStartTime)
                                ->where('end_time', '>=', $selectedEndTime);
                        });
                });
        })->first();

        // When there's a conflicting schedule, return error
        if ($existingSchedule) {
            $request->session()->flash('error', 'Instruktur ' . $existingSchedule->instructor->fullname . ' sudah terjadwal pada pukul ' . $request->course_time . ' di ' . $currentDate->translatedFormat('d F Y') . '. Silakan pilih waktu atau tanggal lain.');
            return redirect()->back();
        }            

        // Store the selected meeting data in session
        session()->put("meeting_{$meeting_number}_date", $request->course_date);
        session()->put("meeting_{$meeting_number}_time", $request->course_time);

        // dd(session()->get("meeting_{$meeting_number}_date"), session()->get("meeting_{$meeting_number}_time"));

        // Redirect to the next meeting or confirmation page
        $nextMeetingNumber = $meeting_number + 1;

        if ($nextMeetingNumber > $courseLength) {
            return redirect()->route('schedule.confirmation', [
                'student_real_name' => $student_real_name,
                'enrollment_id' => $enrollment_id,
            ]);
        } else {
            return redirect()->route('schedule.form', [
                'student_real_name' => $student_real_name,
                'enrollment_id' => $enrollment_id,
                'meeting_number' => $nextMeetingNumber,
            ]);
        }
    }

    public function saveSchedule(Request $request, $student_real_name, $enrollment_id) {
        // Save all meeting data to the database
        $enrollment = Enrollment::findOrFail($enrollment_id);
        $course = $enrollment->course;

        // Retrieve the submitted meetings from the request
        $meetings = $request->input('meetings');

        // Save each meeting
        foreach ($meetings as $meetingNumber => $meetingData) {
            $newSchedule = new CourseSchedule();
            $newSchedule->enrollment_id = $enrollment_id;
            $newSchedule->course_id = $course->id;
            $newSchedule->instructor_id = $enrollment->instructor_id;

            // Parse date and time
            $newSchedule->start_time = Carbon::parse($meetingData['date'] . ' ' . $meetingData['start_time']);
            $newSchedule->end_time = Carbon::parse($meetingData['date'] . ' ' . $meetingData['end_time']);
            $newSchedule->meeting_number = $meetingNumber; // Convert to 1-based index
            $newSchedule->theoryStatus = 0;
            $newSchedule->quizStatus = 0;

            // dd($newSchedule);

            $newSchedule->save();
        }

        // Clear the session
        session()->forget('meeting_*');

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

    public function getAvailableSlots(Request $request) {
        \Log::info('Received request for available slots', [
            'enrollment_id' => 12,
            'start_date' => '2024-12-09',
        ]);
        
        // Fetch the enrollment record based on the enrollment ID
        $enrollment = Enrollment::find(12);
        $startDate = '2024-12-09';
        
        // Check if the enrollment exists
        if (!$enrollment) {
            return response()->json(['error' => 'Invalid enrollment ID'], 400);
        }
        
        // Get Open and Close Times
        $openTime = \Carbon\Carbon::parse($enrollment->course->admin->open_hours_for_admin);
        $closeTime = \Carbon\Carbon::parse($enrollment->course->admin->close_hours_for_admin);
        
        // Get Break Start and End Times
        $breakStart = \Carbon\Carbon::parse("11:30");
        $breakEnd = \Carbon\Carbon::parse("13:00");
        
        // Get Course Duration & Length
        $courseDuration = $enrollment->course->course_duration;
        $courseLength = $enrollment->course->course_length;
        
        // Calculate Course Dates
        $courseDates = [];
        $currentDate = \Carbon\Carbon::parse($startDate);
        for ($i = 0; $i < $courseLength; $i++) {
            $courseDates[] = $currentDate->copy();
            $currentDate->addWeek();
        }
        
        $availableTimeSlots = []; // To store unique available time slots

        // Generate slots for each course date
        foreach ($courseDates as $date) {
            // Fetch instructor's existing schedules for the date
            $instructorId = $enrollment->instructor_id;
            $existingSchedules = CourseSchedule::where('instructor_id', $instructorId)
                ->whereDate('start_time', $date->format('Y-m-d'))
                ->get();

            // Generate daily slots
            $currentTime = $openTime->copy();
            $dailySlots = [];

            while ($currentTime->lessThan($closeTime)) {
                $startSlot = $currentTime->copy();
                $endSlot = $startSlot->copy()->addMinutes($courseDuration);

                // Skip break time
                if (($startSlot->between($breakStart, $breakEnd)) || ($endSlot->between($breakStart, $breakEnd))) {
                    $currentTime = $breakEnd->copy();
                    continue;
                }

                // Check for conflicts
                $conflict = $existingSchedules->contains(function ($schedule) use ($startSlot, $endSlot) {
                    $scheduleStart = \Carbon\Carbon::parse($schedule->start_time);
                    $scheduleEnd = \Carbon\Carbon::parse($schedule->end_time);
                    return $startSlot->between($scheduleStart, $scheduleEnd) ||
                           $endSlot->between($scheduleStart, $scheduleEnd);
                });

                // If no conflict, add the time slot to daily slots
                if (!$conflict) {
                    $dailySlots[] = $startSlot->format('H:i') . " - " . $endSlot->format('H:i');
                }

                // Move to the next slot
                $currentTime = $endSlot;
            }

            // Merge daily slots into available time slots
            foreach ($dailySlots as $slot) {
                if (!in_array($slot, $availableTimeSlots)) {
                    $availableTimeSlots[] = $slot; // Store unique time slots
                }
            }
        }

        // Return only the unique available time slots
        return response()->json($availableTimeSlots);
    }
}
