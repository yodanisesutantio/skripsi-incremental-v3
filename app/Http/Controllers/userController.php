<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\CourseInstructor; // Access Course Instructor Tables
use App\Models\Enrollment; // Access Enrollment Tables
use App\Models\PaymentMethod; // Access PaymentMethod Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class userController extends Controller
{
    // User-Index Page Controller
    public function userIndex() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Find the enrollment ID by comparing student_id with the authenticated user's ID
        $enrollment = Enrollment::where('student_id', auth()->id())->first();
        $enrollment_id = $enrollment ? $enrollment->id : null; // Return null if not found

        $incomingSchedule = null; // Initialize to null
        // Only run the query if enrollment_id is not null
        if ($enrollment_id) {
            $incomingSchedule = CourseSchedule::where('enrollment_id', $enrollment_id)
                ->where('start_time', '>', now()) // Filter for upcoming schedules
                ->orderBy('start_time', 'asc') // Order by start time
                ->first(); // Get the first upcoming schedule
        }

        // Localize the startLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
        if ($incomingSchedule) {
            $incomingSchedule->formattedStartDate = Carbon::parse($incomingSchedule->start_time)->translatedFormat('d F Y');
            $incomingSchedule->formattedStartTime = Carbon::parse($incomingSchedule->start_time)->translatedFormat('H:i');
            $incomingSchedule->formattedEndTime = Carbon::parse($incomingSchedule->end_time)->translatedFormat('H:i');
        }

        // Initialize an empty collection for available courses
        $availableCourses = collect();

        // Keep fetching random courses until we have 6 available ones
        while ($availableCourses->count() < 6) {
            // Fetch random courses as Recommendation
            $randomCourses = Course::inRandomOrder()->take(3)->get(); // Fetch more than 6 to increase chances

            // Filter courses based on availability and enrollment
            $filteredCourses = $randomCourses->filter(function ($course) {
                $activeEnrollmentsCount = $course->enrollments->filter(function ($enrollment) {
                    return $enrollment->schedule->contains(function ($schedule) {
                        return $schedule->end_time > now();
                    });
                })->count();

                // Check if the course is available and not filled
                return $course->course_availability === 1 && $activeEnrollmentsCount < $course->course_quota;
            });

            // Merge the filtered courses into the availableCourses collection
            $availableCourses = $availableCourses->merge($filteredCourses);

            // If we have more than 6, slice it to keep only the first 6
            if ($availableCourses->count() > 6) {
                $availableCourses = $availableCourses->take(6);
            }
        }

        // Fetch Random Driving School to use as Recommendation
        $randomDrivingSchool = User::where('role', 'admin')
            ->where('availability', 1) // Check if availability is 1
            ->inRandomOrder()
            ->take(4) // Limit to 4 driving schools
            ->get();

        return view('home.user', [
            "pageName" => "Beranda | ",
            "incomingSchedule" => $incomingSchedule,
            "availableCourses" => $availableCourses,
            "randomDrivingSchool" => $randomDrivingSchool,
        ]);
    }

    // User-Profile Page Controller
    public function userProfile() {
        return view('profile.user-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    // User-Profile/Edit Page Controller
    public function editProfilePage() {
        return view('profile.edit-user-profile', [
            "pageName" => "Edit Profil | ",
        ]);
    }

    // Edit Account Information Logic Handler
    public function editAccountInfo(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users,username,' . Auth::id(),
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20',
            'age' => 'nullable|integer|min:18|max:70',
        ],
        
        // Validation Error Messages
        [
            'hash_for_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'hash_for_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'description.max' => 'Deskripsi terlalu panjang',
            'age.integer' => 'Masukkan angka yang valid',
            'age.min' => 'Usia minimal yang diizinkan adalah 18 tahun',
            'age.max' => 'Usia maksimal yang diizinkan adalah 70 tahun',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());
        // Immediately update this attribute as per request
        $user->update($request->only(['fullname', 'username', 'description', 'age', 'phone_number']));

        // Check if users uploaded new profile picture
        $fileName = null;
        if ($request->hasFile('hash_for_profile_picture')) {
            // Delete old pictures
            if ($user->hash_for_profile_picture && Storage::disk('public')->exists("profile_pictures/" . $user->hash_for_profile_picture)) {
                Storage::disk('public')->delete("profile_pictures/" . $user->hash_for_profile_picture);
            }

            // rename the file name to store it inside the database
            $fileName = time() . '.' . $request->hash_for_profile_picture->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $request->hash_for_profile_picture->storeAs('profile_pictures', $fileName);

            // instead of the file updated in database, we save the filename of the file from Laravel Storage
            $user->fill(['hash_for_profile_picture' => $fileName]);
        }     

        // Format phone number to +62 and remove non-numeric characters
        $cleanedPhoneNumber = preg_replace('/\D/', '', $request['phone_number']); // Remove non-numeric characters
        $user->phone_number = preg_replace('/^(0|62)/', '+62', $cleanedPhoneNumber);

        // Save new User data
        $user->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Profil berhasil diperbarui!');
        // Redirect user to List of Course Page
        return redirect()->intended('/user-profile');
    }

    // Edit Password Logic Handler
    public function editPassword(Request $request) {
        // Validation Rules
        $request->validate([
            'password' => 'nullable|min:5|max:255|confirmed',
            'password_confirmation' => 'nullable|min:5|max:255',
        ],
        
        // Validation Error Messages
        [
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());

        // When users creating new password, do this
        if ($request->has('password') && $request->has('password_confirmation') && !empty($request->password)) {
            // Crypt the new password
            $user->password = bcrypt($request->password);
            // Save the new password to User Tables
            $user->save();
        }

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Password berhasil diubah!');
        // Redirect user to profile page
        return redirect()->intended('/user-profile');
    }

    public function deleteAccountPermanently() {
        // Find the desired course
        $user = User::findOrFail(auth()->id());

        // Check if the user has any upcoming schedules
        $hasUpcomingSchedule = Enrollment::where('student_id', auth()->id())
            ->whereHas('schedule', function ($query) {
                $query->where('start_time', '>', now());
            })->exists();

        if ($hasUpcomingSchedule) {
            session()->flash('error', 'Anda masih memiliki kursus berlangsung, Silahkan coba lagi jika kursus anda sudah selesai!');
            return redirect('/user-profile');
        }
    
        // Delete the thumbnail from storage
        if ($user->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $user->hash_for_profile_picture);
        }

        // Delete the chosen user
        Auth::logout();
        $user->delete();
        // Redirect the admin to List of Instructor Page
        return redirect('/');
    }

    // User Course history Page Controller
    public function courseHistoryPage() {
        $upcomingCourses = Enrollment::where('student_id', auth()->id())
        ->whereHas('schedule', function ($query) {
            $query->where('start_time', '>', now());
        })
        ->with(['schedule' => function ($query) {
            $query->where('start_time', '>', now())->orderBy('start_time')->limit(1);
        }, 'course'])
        ->get();

        $enrolledCourse = Enrollment::where('student_id', auth()->id())
        ->whereDoesntHave('schedule', function ($query) {
            $query->where('start_time', '>', now()); // Exclude upcoming courses
        })
        ->with('course') // Eager load the related course data
        ->get(); // Fetch all enrolled courses

        return view('student-page.user-course-list', [
            "pageName" => "Riwayat Kursus Anda | ",
            "upcomingCourses" => $upcomingCourses,
            "enrolledCourse" => $enrolledCourse,
        ]);
    }

    // Course Registration Form Page Controller
    public function courseRegistrationForm($course_name, $course_id) {
        // Find the enrollment data for this student
        $course = Course::findOrFail($course_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        return view('student-page.course-registration-form', [
            "pageName" => "Form Pendaftaran Kursus | ",
            "course" => $course,
        ]);
    }

    // User Course Progress Page Controller
    public function courseProgressPage($student_fullname, $enrollment_id) {        
        // Find the enrollment data for this student
        $enrollment = Enrollment::with(['schedule', 'coursePayment'])->find($enrollment_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the current date and time
        $now = now();

        // Check if the course is completed
        $isCourseCompleted = $enrollment->schedule->every(function ($schedule) use ($now) {
            return $schedule->end_time < $now; // All meetings have ended
        });

        if (!$isCourseCompleted) {
            $upcomingSchedule = $enrollment->schedule->filter(function ($schedule) use ($now) {
                return $schedule->start_time >= $now; 
            })->first(); // Find the first / closest upcoming schedule

            // Get the current meeting number if an upcoming schedule exists
            $currentMeetingNumber = $upcomingSchedule ? $upcomingSchedule->meeting_number : null;
        } else {
            if ($enrollment->schedule->isEmpty()) {
                $currentMeetingNumber = 1; // Or set to a specific value if needed
            } else {
                $currentMeetingNumber = $enrollment->course->course_length + 1; // Or set to a specific value if needed
            }
        }

        // Get new collection of the real schedules
        $courseSchedules = $enrollment->schedule;
        // Run through every real schedules
        foreach ($courseSchedules as $courseSchedule) {
            // Then check if there's proposed schedule
            $proposedSchedule = $courseSchedule->proposedSchedule;
            // Check if the proposed schedule is all agreed. If do, update the real schedule based on the proposed schedule. After update, delete the agreed proposed schedule
            if ($proposedSchedule && $proposedSchedule->instructor_decision == 1 && $proposedSchedule->student_decision == 1) {
                $courseSchedule->start_time = $proposedSchedule->start_time;
                $courseSchedule->end_time = $proposedSchedule->end_time;
                $courseSchedule->instructor_id = $proposedSchedule->instructor_id;
                $courseSchedule->save();
                $proposedSchedule->delete();
            } 
            // When the proposed schedule is not getting agreed, but the next current schedule is under the 24 hours, cancel that proposed schedule
            elseif ($proposedSchedule && $courseSchedule->start_time < $now->addHours(24)) {
                $proposedSchedule->delete();
            }
        }

        // Format the schedule dates
        foreach ($enrollment->schedule as $schedule) {
            $schedule->formatted_date = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('l, d F Y');
            $schedule->formatted_time = \Carbon\Carbon::parse($schedule->start_time)->locale('id')->translatedFormat('H:i');
        }

        return view('student-page.user-course-progress', [
            'pageName' => "Detail Progress Kursus Siswa | ",
            'enrollment' => $enrollment,
            'currentMeetingNumber' => $currentMeetingNumber,
        ]);
    }

    // Choose Schedule for the First Time Page Controller 
    public function chooseFirstSchedulePage($student_fullname, $enrollment_id) {
        // Find the enrollment data for this student
        $enrollment = Enrollment::with(['schedule', 'coursePayment'])->find($enrollment_id);

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the Open Time of the Admin's
        $openTime = \Carbon\Carbon::parse($enrollment->course->admin->open_hours_for_admin);
        // Get the Close Time of the Admin's
        $closeTime = \Carbon\Carbon::parse($enrollment->course->admin->close_hours_for_admin);
        // Get the course duration of the selected schedule
        $courseDuration = $enrollment->course->course_duration;

        $availableSlots = [];

        // Generate the course time option until the start time is not more than close time
        while ($openTime->lessThan($closeTime)) {
            // Generate the end time from adding the open time with course duration
            $endOptionTime = $openTime->copy()->addMinutes($courseDuration);
    
            // When the end time is passed the close time, end the generation
            if ($endOptionTime->greaterThan($closeTime)) {
                break; // Exit the loop if it exceeds
            }
    
            // Skip lunch break
            if ($openTime->between('11:30', '13:00', true) || $endOptionTime->between('11:30', '13:00', true)) {
                $openTime->addMinutes($courseDuration);
                continue;
            }
    
            // Add the slot to available slots
            $availableSlots[] = [
                'start' => $openTime->format('H:i'),
                'end' => $endOptionTime->format('H:i'),
            ];
    
            // Create new start time by adding the previous start time with course duration
            $openTime->addMinutes($courseDuration);
        }

        // Collect every Instructors that are assigned to this class from Course Instructor Tables
        $instructorOption = CourseInstructor::query()->where('course_id', $enrollment->course->id)->orderBy('created_at', 'desc')->get();
        // dd($instructorOption);

        return view('student-page.user-choose-schedule', [
            'pageName' => "Pilih Jadwal Kursus | ",
            'enrollment' => $enrollment,
            'availableSlots' => $availableSlots,
            'instructorOption' => $instructorOption,
        ]);
    }

    public function paymentPage($student_real_name, $enrollment_id) {
        // Find the enrollment data for this student
        $enrollment = Enrollment::with(['schedule', 'coursePayment'])->find($enrollment_id);

        // Create new collection to collect the payment_method that the admin/owner own
        $paymentMethod = PaymentMethod::where('admin_id', $enrollment->course->admin->id)
            ->where('is_payment_active', 1) // Add this condition to filter active payment methods
            ->get();
        // Decrypt the payment_address
        $paymentMethod->each(function ($method) {
            $method->payment_address = Crypt::decryptString($method->payment_address);
        });

        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // dd($paymentMethod);

        return view('student-page.user-payment', [
            'pageName' => "Pembayaran Kursus | ",
            'enrollment' => $enrollment,
            'paymentMethod' => $paymentMethod,
        ]);
    }

    public function theoryPage($enrollment_id, $meeting_number) {
        // Static content for each meeting_number
        $content = [
            1 => [
                'title' => 'Preparing to Drive Safely',
                'title-image' => 'car_preparation.jpg', 
                'slides' => [
                    [
                        'image' => 'seatbelt.jpg',
                        'content' => 'Always Wear Your Seatbelt: Buckling up is the simplest and most effective way to protect yourself in case of an accident. Ensure all passengers are also wearing their seatbelts before starting your journey.'
                    ],
                    [
                        'image' => 'no_drinking_no_sleepy.jpg',
                        'content' => 'Avoid Driving When Sleepy or Under the Influence: Driving while fatigued or under the influence of alcohol significantly increases the risk of accidents. If you feel tired or impaired, it’s best to avoid driving.'
                    ],
                    [
                        'image' => 'engine_warmup.jpg',
                        'content' => 'Warming Up the Engine: Before starting your journey, let the engine warm up for a few minutes, especially in cold weather, to ensure smooth functioning.'
                    ],
                    [
                        'image' => 'blinker_and_brake_check.jpg',
                        'content' => 'Checking the Blinkers and Brakes: Ensure that your indicator lights are functioning and gently test your brakes before moving. Both are critical for safe driving.'
                    ],
                    [
                        'image' => 'headlight_check.jpg',
                        'content' => 'Headlight and Taillight Check: Verify that your headlights, taillights, and brake lights are working properly for good visibility and safety in all conditions.'
                    ],
                    [
                        'image' => 'wiper_and_oil_check.jpg',
                        'content' => 'Windshield Wipers and Oil Level: Check your wipers for proper functioning and ensure your engine oil is at the right level using the dipstick.'
                    ],
                    [
                        'image' => 'tire_pressure_check.jpg',
                        'content' => 'Tire Pressure: Proper tire pressure ensures safe handling and fuel efficiency. Check the tire pressure before you drive.'
                    ],
                ],
            ],

            2 => [
                'title' => 'Types of Car Transmission and Driving Basics',
                'title-image' => 'transmission_types.jpg', 
                'slides' => [
                    [
                        'image' => 'manual_vs_automatic.jpg',
                        'content' => 'Introduction to car transmissions: the difference between manual and automatic transmission systems. Manual cars use a clutch and gear stick, while automatic cars handle the gear shifts automatically.'
                    ],
                    [
                        'image' => 'manual_gears.jpg',
                        'content' => 'Manual Transmission Basics: In a manual car, you control the gears. Learn the functions of each gear and when to use them: 1st gear for starting, 2nd gear for slow speeds, etc.'
                    ],
                    [
                        'image' => 'automatic_gears.jpg',
                        'content' => 'Automatic Transmission Basics: Automatic cars come with a "P-R-N-D" gear selector. Understand how each mode works: Park (P), Reverse (R), Neutral (N), and Drive (D).'
                    ],
                    [
                        'image' => 'traffic_jam_gear.jpg',
                        'content' => 'Gears in Traffic Jam: For manual cars, use 1st or 2nd gear for stop-and-go traffic. In automatic cars, staying in "Drive" is recommended, but switching to "Low Gear" can help in severe traffic jams.'
                    ],
                    [
                        'image' => 'flood_gear.jpg',
                        'content' => 'Gears in Flooding Conditions: In manual cars, use 1st or 2nd gear to keep engine revs high and avoid stalling. In automatic cars, use the "Low Gear" (L) or 2nd gear for more control.'
                    ],
                    [
                        'image' => 'uphill_driving.jpg',
                        'content' => 'Uphill Driving: In manual cars, downshift to 1st or 2nd gear when driving uphill to prevent the engine from struggling. For automatic cars, use "Drive" or shift to "Low Gear."'
                    ],
                    [
                        'image' => 'downhill_driving.jpg',
                        'content' => 'Downhill Driving: In manual cars, downshift to 2nd or 3rd gear to use engine braking, reducing the need for frequent braking. In automatic cars, shift to "Low Gear" for better control.'
                    ],
                ],                
            ],

            3 => [
                'title' => 'Road Signs, Road Markings, and Traffic Lights',
                'title-image' => 'road_signs.jpg',
                'slides' => [
                    [
                        'image' => 'regulatory_signs.jpg',
                        'content' => 'Regulatory Signs: These signs give mandatory instructions like stop, yield, and speed limits. Drivers must follow these to avoid penalties. Common examples include Stop signs, No Entry, and Speed Limit signs.'
                    ],
                    [
                        'image' => 'warning_signs.jpg',
                        'content' => 'Warning Signs: These signs alert drivers to potential hazards ahead, such as sharp bends, slippery roads, or animal crossings. These are usually triangular in shape with a red border.'
                    ],
                    [
                        'image' => 'informational_signs.jpg',
                        'content' => 'Informational Signs: These provide helpful information for drivers, like directions, parking areas, or gas stations. They are usually rectangular and blue or green in color.'
                    ],
                    [
                        'image' => 'road_markings.jpg',
                        'content' => 'Road Markings: These include lane dividers, pedestrian crossings, and arrows indicating allowed lane directions. Solid lines generally mean no crossing, while dashed lines may allow lane changes.'
                    ],
                    [
                        'image' => 'traffic_lights.jpg',
                        'content' => 'Traffic Lights: Understanding traffic signals is crucial. Red means stop, yellow indicates that the light is about to change, and green allows you to proceed. Some intersections may also have arrow signals to guide turns.'
                    ],
                    [
                        'image' => 'pedestrian_crossings.jpg',
                        'content' => 'Pedestrian Crossings: Marked by white stripes or "zebra" crossings, drivers must yield to pedestrians at these points. Always slow down near crossings and check for people on foot.'
                    ],
                    [
                        'image' => 'intersection_priority.jpg',
                        'content' => 'Intersection Priority: Learn the right-of-way rules at intersections with and without traffic lights. Drivers should yield to vehicles coming from the right in countries where traffic moves on the right-hand side, unless signs indicate otherwise.'
                    ],
                ],                
            ],

            4 => [
                'title' => 'Driving Ethics and Responsibilities',
                'title-image' => 'driving_ethics.jpg',
                'slides' => [
                    [
                        'image' => 'overtaking.jpg',
                        'content' => 'Overtaking Etiquette: When overtaking another vehicle, always check your mirrors and blind spots. Overtake only on the left side (in countries with right-hand traffic) and ensure there’s enough space before returning to your lane. Avoid overtaking in curves, intersections, or when visibility is poor.'
                    ],
                    [
                        'image' => 'lane_switching.jpg',
                        'content' => 'Switching Lanes: Before switching lanes, signal your intent, check mirrors, and look over your shoulder to check blind spots. Make sure the lane is clear, and avoid frequent, unnecessary lane changes.'
                    ],
                    [
                        'image' => 'emergency_vehicle_priority.jpg',
                        'content' => 'Emergency Vehicle Priority: Always give way to emergency vehicles like fire trucks, ambulances, and police patrol cars when you hear sirens or see flashing lights. Pull over to the side of the road and stop if necessary, allowing them to pass quickly and safely.'
                    ],
                    [
                        'image' => 'roundabout.jpg',
                        'content' => 'Turning in a Roundabout: Yield to traffic already in the roundabout, and signal your intent to exit. Stay in the correct lane depending on whether you are turning left, right, or going straight.'
                    ],
                    [
                        'image' => 'u_turn.jpg',
                        'content' => 'Making a U-Turn: Only make U-turns at designated intersections or where permitted. Ensure there is no oncoming traffic and enough space to complete the turn safely. Be cautious of pedestrians and other vehicles.'
                    ],
                    [
                        'image' => 'right_of_way.jpg',
                        'content' => 'Right-of-Way Rules: Always yield the right of way to pedestrians at crosswalks. When two vehicles arrive at an intersection at the same time, the vehicle on the right has the right of way unless signs indicate otherwise.'
                    ],
                    [
                        'image' => 'courtesy_driving.jpg',
                        'content' => 'Courtesy and Safe Driving: Always maintain a safe following distance, use turn signals, and avoid aggressive driving. Show courtesy to other drivers, especially in high-traffic or difficult conditions.'
                    ],
                ],                
            ],

            5 => [
                'title' => 'Basic Driving Laws and Legal Responsibilities',
                'title-image' => 'basic_laws.jpg',
                'slides' => [
                    [
                        'image' => 'stopped_by_police.jpg',
                        'content' => 'What to Do When Stopped by Police: Stay calm, pull over safely, and keep your hands visible. Only provide your license, vehicle registration, and insurance when asked. Do not argue or attempt to leave the scene before permitted.'
                    ],
                    [
                        'image' => 'collision.jpg',
                        'content' => 'What to Do After a Collision: Stay at the scene and check for injuries. Call emergency services if necessary and exchange information with the other driver (license, insurance, etc.). Document the scene with photos if possible, and avoid admitting fault on the spot.'
                    ],
                    [
                        'image' => 'insurance_claim.jpg',
                        'content' => 'Filing an Insurance Claim: In case of an accident, contact your insurance company as soon as possible to file a claim. Provide all necessary details, including any police reports, photos, and contact information of the other party involved.'
                    ],
                    [
                        'image' => 'no_drunk_driving.jpg',
                        'content' => 'Prohibition of Drunk and Distracted Driving: It is illegal to drive under the influence of alcohol, drugs, or while distracted (texting, phone use). Violations result in severe penalties, including fines, license suspension, or jail time.'
                    ],
                    [
                        'image' => 'vehicle_documents.jpg',
                        'content' => 'Always Carry Essential Documents: Drivers are required to have their driver’s license, vehicle registration, and proof of insurance when operating a vehicle. These must be presented upon request by law enforcement.'
                    ],
                    [
                        'image' => 'traffic_violations.jpg',
                        'content' => 'Traffic Violations: Speeding, running red lights, illegal parking, and other traffic violations are punishable by fines and points on your license. Accumulating too many points can lead to license suspension.'
                    ],
                ],                
            ],
        ];
    
        // Check if the meeting_number exists in the content array
        if (!array_key_exists($meeting_number, $content)) {
            // Generate a flash message via Toastr to let user know that the process is successful
            session()->flash('warning', 'Panduan untuk Pertemuan ' . $meeting_number . ' belum tersedia');
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }

        $enrollment = Enrollment::findOrFail($enrollment_id);
    
        return view('student-page.user-course-theory', [
            'pageName' => "Panduan | ",
            'enrollment' => $enrollment,
            'content' => $content[$meeting_number],
        ]);
    }
}
