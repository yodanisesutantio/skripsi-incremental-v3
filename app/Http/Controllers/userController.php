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
        $user = auth()->user();
        $decryptedFpAnswer = null;

        if ($user && $user->fp_answer) {
            $decryptedFpAnswer = Crypt::decryptString($user->fp_answer);
        }

        return view('profile.edit-user-profile', [
            "pageName" => "Edit Profil | ",
            "decryptedFpAnswer" => $decryptedFpAnswer,
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
            'fp_question' => 'required|max:255',
            'fp_answer' => 'required|max:255',
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
            'fp_question.required' => 'Kolom ini harus diisi',
            'fp_question.max' => 'Pertanyaan Terlalu Panjang',
            'fp_answer.required' => 'Kolom ini harus diisi',
            'fp_answer.max' => 'Jawaban Terlalu Panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::find(Auth::id());
        // Immediately update this attribute as per request
        $user->update($request->only(['fullname', 'username', 'description', 'age', 'phone_number', 'fp_question']));

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

        // Encrypt the fp_answer before saving
        $user->fp_answer = Crypt::encryptString($request->input('fp_answer'));

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

    // Reset Password Logic Handler
    public function resetPassword(Request $request, $username) {
        // Validation Rules
        $request->validate([
            'password' => 'required|min:5|max:255|confirmed',
            'password_confirmation' => 'required|min:5|max:255',
        ],
        
        // Validation Error Messages
        [
            'password.required' => 'Kolom ini harus diisi',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.required' => 'Kolom ini harus diisi',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        // Find the User data by matching it with the current authenticated user ID
        $user = User::where('username', $username)->firstOrFail();

        // Crypt the new password
        $user->password = bcrypt($request->password);
        // Save the new password to User Tables
        $user->save();

        // Flash User with Success Message
        session()->flash('success', 'Password berhasil diatur ulang!');
        // Redirect user to profile page
        return redirect('/login');
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
            $query->where('start_time', '>', now())->orderBy('start_time');
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

    // Course Theory Page Controller
    public function theoryPage($enrollment_id, $meeting_number) {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the current date and time
        $now = now();

        $enrollment = Enrollment::findOrFail($enrollment_id);

        // Check if the course is completed
        $isCourseCompleted = $enrollment->schedule->every(function ($schedule) use ($now) {
            return $schedule->end_time < $now; // All meetings have ended
        });

        if ($isCourseCompleted) {
            // Return student back if they've done the course
            session()->flash('info', 'Kursus sudah selesai. Anda tidak bisa mengakses panduan kursus lagi.');
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }

        // Static content for each meeting_number
        $content = [
            1 => [
                'title' => 'Persiapan untuk Berkendara dengan Aman',
                'title-image-mobile' => 'car_preparation_small.webp', 
                'title-image-desktop' => 'car_preparation.webp', 
                'slides' => [
                    [
                        'image' => 'seatbelt.webp',
                        'content' => 'Selalu kenakan sabuk pengaman saat mengemudi atau naik kendaraan. Sabuk pengaman adalah alat keselamatan yang penting untuk melindungi Anda dan penumpang Anda dari cedera serius dalam kecelakaan lalu lintas. <br><br>

                        Pastikan sabuk pengaman terpasang dengan benar dan tidak terlalu ketat. Ajarkan penumpang Anda, baik dewasa maupun anak-anak, untuk selalu mengenakan sabuk pengaman. Dengan mengenakan sabuk pengaman, Anda melindungi diri sendiri dan orang-orang yang Anda cintai.'
                    ],
                    [
                        'image' => 'no_drinking_no_sleepy.webp',
                        'content' => 'Mengemudi dalam kondisi lelah atau setelah mengonsumsi alkohol dapat meningkatkan risiko kecelakaan secara drastis. Jika Anda merasa mengantuk atau tidak fit, sebaiknya hindari mengemudi. <br><br>

                        Untuk memastikan keselamatan di jalan raya, pastikan Anda istirahat cukup sebelum mengemudi. Hindari mengonsumsi alkohol sebelum mengemudi. Jika merasa mengantuk, berhentilah di tempat yang aman untuk beristirahat atau tidur sebentar. Minum kopi atau minuman berkafein lainnya dapat membantu meningkatkan kewaspadaan, tetapi jangan mengandalkan kafein sebagai pengganti istirahat yang cukup.'
                    ],
                    [
                        'image' => 'engine_warmup.webp',
                        'content' => 'Sebelum memulai perjalanan, berikan kesempatan mesin kendaraan Anda untuk menjadi sedikit panas terlebih dahulu. Hal ini sangat penting, terutama dalam cuaca dingin, untuk memastikan kinerja mesin yang optimal dan mencegah kerusakan komponen. Biarkan mesin menyala selama beberapa menit sebelum mengemudi, hingga jarum suhu mencapai titik tengah atau sedikit di atasnya. <br><br>

                        Dengan memanaskan mesin, Anda memberikan waktu bagi oli untuk bersirkulasi dan melumasi komponen-komponen penting mesin. Hal ini dapat membantu mencegah keausan dan meningkatkan umur pakai kendaraan Anda.'
                    ],
                    [
                        'image' => 'blinker_and_brake_check.webp',
                        'content' => 'Sebelum memulai perjalanan, pastikan lampu sein dan rem kendaraan Anda berfungsi dengan baik. Uji lampu sein kanan dan kiri untuk memastikan sinyal belok Anda terlihat jelas. Kemudian, tekan pedal rem untuk memastikan lampu rem menyala dengan terang. Dengan memeriksa lampu-lampu ini, Anda dapat memastikan keamanan berkendara Anda dan menghindari kecelakaan.'
                    ],
                    [
                        'image' => 'headlight_check.webp',
                        'content' => 'Sebelum memulai perjalanan, pastikan semua lampu kendaraan Anda berfungsi dengan baik. Periksa lampu depan, lampu belakang, lampu sein, dan lampu rem untuk memastikan visibilitas yang optimal. Dengan lampu yang berfungsi dengan baik, Anda dapat meningkatkan keselamatan berkendara Anda dan menghindari kecelakaan.'
                    ],
                    [
                        'image' => 'wiper_and_oil_check.webp',
                        'content' => 'Sebelum memulai perjalanan, pastikan wiper kaca depan Anda berfungsi dengan baik untuk memastikan visibilitas yang jelas saat hujan atau cuaca buruk. Periksa juga level oli mesin menggunakan dipstick untuk memastikan mesin Anda terlumasi dengan baik. Dengan melakukan pemeriksaan rutin ini, Anda dapat mencegah kerusakan mesin dan memastikan keselamatan berkendara Anda.'
                    ],
                    [
                        'image' => 'tire_pressure_check.webp',
                        'content' => 'Tekanan angin ban yang tepat sangat penting untuk keselamatan dan efisiensi bahan bakar. Sebelum memulai perjalanan, pastikan tekanan angin ban Anda sesuai dengan rekomendasi pabrik. Gunakan alat pengukur tekanan ban yang akurat untuk mengecek tekanan angin ban secara berkala.'
                    ],
                ],
            ],

            2 => [
                'title' => 'Jenis Transmisi Mobil dan Dasar-Dasar Mengemudi',
                'title-image-mobile' => 'types_of_transmission_mobile.webp', 
                'title-image-desktop' => 'types_of_transmission_desktop.webp', 
                'slides' => [
                    [
                        'image' => 'manual_vs_automatic.webp',
                        'content' => 'Transmisi manual menggunakan pedal kopling dan tuas transmisi untuk mengganti gigi. Transmisi otomatis mengubah gigi secara otomatis. Transmisi manual umumnya lebih efisien bahan bakar dan memberikan kontrol lebih besar, tetapi memerlukan keterampilan dan koordinasi yang lebih baik. Transmisi otomatis lebih nyaman dan mudah digunakan, tetapi konsumsi bahan bakarnya sedikit lebih tinggi. <br><br>
                        
                        Pilihlah transmisi yang sesuai dengan preferensi dan kebutuhan mengemudi Anda. Pertimbangkan gaya mengemudi Anda, kondisi lalu lintas yang biasa Anda hadapi, dan anggaran Anda saat memilih antara transmisi manual atau otomatis.'
                    ],
                    [
                        'image' => 'manual_gears.webp',
                        'content' => 'Pada mobil dengan transmisi manual, Anda bertanggung jawab untuk mengganti gigi secara manual. Pelajari fungsi setiap gigi dan kapan harus menggunakannya. Gigi 1 digunakan untuk memulai perjalanan atau saat kecepatan sangat rendah. Gigi 2 digunakan untuk kecepatan rendah hingga sedang, seperti saat melewati persimpangan atau jalanan yang ramai. <br><br>
                        
                        Gigi 3 digunakan untuk kecepatan sedang hingga tinggi, cocok untuk jalanan yang lancar dan terbuka. Gigi 4 digunakan untuk kecepatan tinggi pada jalan raya atau jalan tol. Gigi 5 adalah gigi tertinggi, digunakan untuk kecepatan tertinggi yang aman. Dengan memahami fungsi setiap gigi, Anda dapat mengoptimalkan performa kendaraan dan efisiensi bahan bakar.'
                    ],
                    [
                        'image' => 'automatic_gears.webp',
                        'content' => 'Transmisi otomatis memiliki tuas transmisi dengan posisi "P-R-N-D". Setiap posisi memiliki fungsi yang berbeda. Posisi P digunakan saat parkir atau berhenti total. Posisi R digunakan untuk mundur. Posisi N digunakan saat berhenti sementara atau untuk menunda transmisi. Posisi D digunakan untuk mengemudi maju. Dengan memahami fungsi setiap posisi, Anda dapat mengoperasikan transmisi otomatis dengan mudah dan aman.'
                    ],
                    [
                        'image' => 'traffic_jam_gear.webp',
                        'content' => 'Pada mobil manual, gunakan gigi 1 atau 2 saat menghadapi kemacetan untuk menjaga kontrol kendaraan. Pada mobil otomatis, tetaplah di posisi "Drive", tetapi Anda dapat beralih ke "Low Gear" untuk membantu menjaga kontrol kendaraan jika kemacetan sangat parah. Dengan memilih gigi yang tepat, Anda dapat memastikan kendaraan Anda berjalan dengan lancar dan menghindari kemacetan yang lebih panjang.'
                    ],
                    [
                        'image' => 'flood_gear.webp',
                        'content' => 'Saat menghadapi kondisi banjir, gunakan gigi 1 atau 2 pada mobil manual untuk menjaga putaran mesin tetap tinggi dan mencegah mesin mati. Pada mobil otomatis, gunakan posisi "Low Gear" (L) untuk mendapatkan kontrol yang lebih baik. Dengan menggunakan gigi yang tepat, Anda dapat membantu mencegah mesin mati dan menjaga kendaraan tetap berjalan lancar dalam kondisi banjir.'
                    ],
                    [
                        'image' => 'uphill_driving.webp',
                        'content' => 'Saat menghadapi tanjakan, gunakan gigi yang lebih rendah untuk membantu mesin mengatasi beban. Pada mobil manual, turunkan gigi ke 1 atau 2 untuk mencegah mesin mati. Pada mobil otomatis, gunakan posisi "Drive" atau beralih ke "Low Gear" jika diperlukan. Dengan menggunakan gigi yang tepat, Anda dapat memastikan kendaraan Anda dapat mengatasi tanjakan dengan lancar dan menghindari tekanan berlebih pada mesin.'
                    ],
                    [
                        'image' => 'downhill_driving.webp',
                        'content' => 'Saat menghadapi turunan, gunakan gigi yang lebih rendah untuk membantu mengurangi kecepatan kendaraan dan mengurangi tekanan pada rem. Pada mobil manual, turunkan gigi ke 2 atau 3 untuk memanfaatkan pengereman mesin. Pada mobil otomatis, gunakan posisi "Low Gear" untuk mendapatkan kontrol yang lebih baik. Dengan menggunakan gigi yang tepat, Anda dapat memastikan kendaraan Anda dapat turun dengan aman dan mengurangi keausan pada rem.'
                    ],
                ],                
            ],

            3 => [
                'title' => 'Rambu Jalan, Marka Jalan, dan Lampu Lalu Lintas',
                'title-image-mobile' => 'road_attributes_mobile.webp', 
                'title-image-desktop' => 'road_attributes_desktop.webp', 
                'slides' => [
                    [
                        'image' => 'regulatory_signs.webp',
                        'content' => 'Tanda-tanda aturan lalu lintas memberikan instruksi yang harus dipatuhi oleh pengemudi, seperti berhenti, memberi jalan, dan batas kecepatan. Kegagalan mengikuti tanda-tanda ini dapat mengakibatkan sanksi. Contoh umum tanda-tanda aturan lalu lintas antara lain tanda berhenti, tanda larangan masuk, dan tanda batas kecepatan.'
                    ],
                    [
                        'image' => 'warning_signs.webp',
                        'content' => 'Tanda-tanda peringatan memberikan informasi tentang potensi bahaya di depan, seperti tikungan tajam, jalan licin, atau penyeberangan hewan. Tanda-tanda ini biasanya berbentuk segitiga dengan tepi merah. Perhatikan tanda-tanda peringatan ini untuk memastikan keselamatan berkendara Anda.'
                    ],
                    [
                        'image' => 'informational_signs.webp',
                        'content' => 'Tanda-tanda informasi memberikan petunjuk dan informasi bermanfaat bagi pengemudi, seperti petunjuk arah, area parkir, atau lokasi stasiun pengisian bahan bakar. Tanda-tanda ini biasanya berbentuk persegi panjang dan berwarna biru atau hijau. Perhatikan tanda-tanda informasi untuk membantu Anda memahami rute perjalanan dan menemukan fasilitas yang dibutuhkan. Dengan memperhatikan tanda-tanda informasi, Anda dapat menghindari kebingungan dan memastikan perjalanan yang lancar dan nyaman.'
                    ],
                    [
                        'image' => 'road_markings.webp',
                        'content' => 'Tanda-tanda jalan memberikan petunjuk tentang kondisi jalan dan aturan lalu lintas. Tanda-tanda seperti garis putus-putus dan garis penuh menunjukkan jalur lalu lintas dan izin untuk berpindah jalur. Garis putus-putus menandakan anda diperbolehkan untuk berpindah jalur, sedangkan garis penuh umumnya melarang perubahan jalur. Perhatikan tanda-tanda jalan untuk memastikan Anda berkendara dengan aman dan mematuhi aturan lalu lintas.'
                    ],
                    [
                        'image' => 'traffic_lights.webp',
                        'content' => 'Lampu lalu lintas merupakan alat penting untuk mengatur arus lalu lintas. Lampu merah berarti berhenti, lampu kuning menandakan lampu akan segera berganti, dan lampu hijau memberikan izin untuk melanjutkan perjalanan. Beberapa persimpangan juga menggunakan lampu panah untuk memberikan petunjuk arah belok. Selalu perhatikan lampu lalu lintas dan ikuti instruksinya untuk berkendara dengan aman.'
                    ],
                    [
                        'image' => 'pedestrian_crossings.webp',
                        'content' => 'Daerah penyeberangan pejalan kaki biasanya ditandai dengan garis-garis putih atau "zebra". Sebagai pengemudi, Anda harus memberikan prioritas kepada pejalan kaki di daerah penyeberangan. Kurangi kecepatan kendaraan Anda saat mendekati daerah penyeberangan dan selalu perhatikan apakah ada pejalan kaki yang ingin menyeberang.'
                    ],
                    [
                        'image' => 'intersection_priority.webp',
                        'content' => 'Pelajari aturan prioritas di persimpangan dengan dan tanpa lampu lalu lintas. Di negara-negara dengan lalu lintas yang bergerak di sisi kanan jalan, pengemudi harus memberi jalan kepada kendaraan yang datang dari kanan, kecuali ada tanda-tanda yang menunjukkan sebaliknya. Selalu perhatikan tanda-tanda lalu lintas dan prioritas di persimpangan untuk menghindari kecelakaan.'
                    ],
                ],                
            ],

            4 => [
                'title' => 'Etika dan Kewajiban Pengemudi',
                'title-image-mobile' => 'driving_ethics_mobile.webp', 
                'title-image-desktop' => 'driving_ethics_desktop.webp', 
                'slides' => [
                    [
                        'image' => 'overtaking.webp',
                        'content' => 'Saat menyalip kendaraan lain, selalu periksa kaca spion dan titik buta Anda untuk memastikan tidak ada kendaraan lain yang tersembunyi. Salip kendaraan dari sisi kanan dan pastikan ada ruang yang cukup sebelum kembali ke jalur semula. Hindari menyalip pada tikungan, persimpangan, atau saat kondisi visibilitas buruk.<br><br>
                        
                        Menyalip dengan aman dan bertanggung jawab adalah penting untuk menjaga keselamatan di jalan raya. Selalu perhatikan situasi di sekitar Anda dan berikan ruang yang cukup bagi kendaraan lain.'
                    ],
                    [
                        'image' => 'lane_switching.webp',
                        'content' => 'Sebelum berpindah jalur, berikan sinyal dengan lampu sein, periksa kaca spion, dan lihat ke belakang untuk memastikan tidak ada kendaraan di titik buta Anda. Pastikan jalur yang ingin Anda tuju kosong sebelum berpindah. Hindari perubahan jalur yang sering dan tidak perlu, karena dapat mengganggu lalu lintas dan meningkatkan risiko kecelakaan.'
                    ],
                    [
                        'image' => 'emergency_vehicle_priority.webp',
                        'content' => 'Saat mendengar sirene atau melihat lampu kedip dari kendaraan darurat seperti mobil pemadam kebakaran, ambulans, atau mobil polisi, segera berikan jalan kepada mereka. Tarik kendaraan Anda ke sisi jalan dan berhenti jika diperlukan, memungkinkan mereka untuk melewati Anda dengan cepat dan aman. <br><br>
                        
                        Memberikan prioritas kepada kendaraan darurat adalah tindakan penting untuk menyelamatkan jiwa dan menjaga keselamatan di jalan raya. Selalu waspada terhadap sirene dan lampu kedip kendaraan darurat, dan segera berikan jalan kepada mereka.'
                    ],
                    [
                        'image' => 'roundabout.webp',
                        'content' => 'Saat memasuki bundaran, berikan jalan kepada kendaraan yang sudah berada di dalam bundaran. Gunakan lampu sein untuk memberi sinyal niat Anda keluar dari bundaran. Tetaplah di jalur yang sesuai dengan arah tujuan Anda, apakah belok kiri, kanan, atau lurus. Dengan mengikuti aturan ini, Anda dapat menghindari kecelakaan dan menjaga kelancaran lalu lintas di persimpangan bundaran.'
                    ],
                    [
                        'image' => 'u_turn.webp',
                        'content' => 'Putar balik hanya boleh dilakukan di persimpangan yang telah ditentukan atau tempat yang diizinkan. Pastikan tidak ada kendaraan yang datang dari arah berlawanan dan ada ruang yang cukup untuk menyelesaikan putar balik dengan aman. Perhatikan juga pejalan kaki dan kendaraan lain di sekitar Anda. <br><br>
                        
                        Saat melakukan putar balik, hindari memasukkan bagian depan kendaraan anda ke arah jalan yang berlawanan. Hal ini dapat membahayakan kendaraan yang datang dari arah berlawanan. Pastikan putar balik dilakukan dengan lancar dan tidak mengganggu lalu lintas.'
                    ],
                    [
                        'image' => 'right_of_way.webp',
                        'content' => 'Berikan prioritas kepada pejalan kaki di persimpangan. Jika dua kendaraan tiba di persimpangan pada waktu yang sama, kendaraan yang datang dari kanan memiliki hak untuk melanjutkan perjalanan, kecuali ada tanda-tanda yang menunjukkan sebaliknya. Selalu perhatikan aturan prioritas di persimpangan untuk menghindari kecelakaan.'
                    ],
                    [
                        'image' => 'courtesy_driving.webp',
                        'content' => 'Jaga jarak aman dengan kendaraan di depan Anda, gunakan lampu sein saat berbelok atau berpindah jalur, dan hindari mengemudi secara agresif. Bersikap sopan dan menghargai pengemudi lain, terutama dalam kondisi lalu lintas yang padat atau sulit. Dengan mengemudi dengan sopan dan bertanggung jawab, Anda dapat membantu menjaga keselamatan di jalan raya.'
                    ],
                ],                
            ],

            5 => [
                'title' => 'Hukum dan Peraturan di Jalan Raya',
                'title-image-mobile' => 'basic_driving_mobile.webp', 
                'title-image-desktop' => 'basic_driving_desktop.webp', 
                'slides' => [
                    [
                        'image' => 'stopped_by_police.webp',
                        'content' => 'Jika dihentikan oleh polisi, tetaplah tenang dan berhentikan kendaraan Anda dengan aman di tempat yang sesuai. Jaga tangan Anda tetap terlihat dan jangan membuat gerakan tiba-tiba. Siapkan dokumen-dokumen penting seperti SIM, STNK, dan bukti asuransi kendaraan. Ikuti instruksi petugas dengan sopan dan jangan memulai perdebatan.'
                    ],
                    [
                        'image' => 'collision.webp',
                        'content' => 'Terlibat dengan kecelakaan? Tetaplah di tempat kejadian kecelakaan dan periksa apakah ada korban luka. Hubungi layanan darurat jika diperlukan. Tukarkan informasi dengan pengemudi lainnya, seperti nama, nomor telepon, nomor SIM, dan informasi asuransi. Jika memungkinkan, dokumentasikan kejadian dengan mengambil foto. Hindari mengakui kesalahan di tempat kejadian.'
                    ],
                    [
                        'image' => 'no_drunk_driving.webp',
                        'content' => 'Mengemudi dalam keadaan mabuk alkohol atau narkoba, serta saat terganggu (seperti menggunakan ponsel), adalah tindakan yang dilarang oleh hukum. Pelanggaran terhadap larangan ini dapat mengakibatkan sanksi yang berat, termasuk denda, penangguhan SIM, atau bahkan penjara.'
                    ],
                    [
                        'image' => 'vehicle_documents.webp',
                        'content' => 'Sebagai pengemudi, Anda diwajibkan membawa surat-surat penting seperti SIM, STNK, dan bukti asuransi kendaraan saat mengemudi. Dokumen-dokumen ini harus ditunjukkan kepada petugas penegak hukum jika diminta. Pastikan dokumen-dokumen tersebut selalu tersedia dan mudah diakses saat mengemudi.'
                    ],
                    [
                        'image' => 'traffic_violations.webp',
                        'content' => 'Melanggar aturan lalu lintas seperti mengebut, menerobos lampu merah, parkir ilegal, atau pelanggaran lainnya dapat mengakibatkan sanksi berupa denda atau penambahan poin pelanggaran pada SIM Anda. Jika Anda mengumpulkan terlalu banyak poin pelanggaran, SIM Anda dapat ditangguhkan atau dicabut. Patuhi peraturan lalu lintas untuk menghindari sanksi dan menjaga keselamatan di jalan raya.'
                    ],
                ],                
            ],
        ];
        
        // Check if the meeting_number exists in the content array
        if (!array_key_exists($meeting_number, $content)) {
            // Generate a flash message via Toastr to let user know that there's no Theory for current Meeting Number
            session()->flash('warning', 'Panduan untuk Pertemuan ' . $meeting_number . ' belum tersedia');
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }
        
        return view('student-page.user-course-theory', [
            'pageName' => "Panduan | ",
            'enrollment' => $enrollment,
            'meeting_number' => $meeting_number,
            'content' => $content[$meeting_number],
        ]);
    }

    // Course Quiz Page Controller
    public function quizPage($enrollment_id, $meeting_number) {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get the current date and time
        $now = now();

        $enrollment = Enrollment::findOrFail($enrollment_id);

        // Check if the course is completed
        $isCourseCompleted = $enrollment->schedule->every(function ($schedule) use ($now) {
            return $schedule->end_time < $now; // All meetings have ended
        });

        if ($isCourseCompleted) {
            // Return student back if they've done the course
            session()->flash('info', 'Kursus sudah selesai. Anda tidak bisa mengakses Quiz.');
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }
        
        $currentSchedule = CourseSchedule::where('enrollment_id', $enrollment_id)->where('meeting_number', $meeting_number)->first();

        if ($currentSchedule->quizStatus === 1) {
            // Return student back if they've done the quiz already
            session()->flash('info', 'Anda sudah menyelesaikan quiz untuk pertemuan ' . $meeting_number);
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }

        // Static content for each meeting_number
        $content = [
            1 => [
                'title' => 'Persiapan untuk Berkendara dengan Aman',
                'title-image-mobile' => 'car_preparation_small.webp', 
                'title-image-desktop' => 'car_preparation.webp', 
                'slides' => [
                    [
                        'question' => '"Mengenakan sabuk pengaman saat mengemudi adalah wajib. Baik bagi pengemudi maupun penumpang." Apakah pernyataan tersebut benar?',
                        'choice' => [
                            'Benar',
                            'Salah',
                        ],
                        'correctAnswer' => 0
                    ],
                    [
                        'question' => 'Apabila anda mengantuk pada saat anda sedang mengemudi, mana tindakan dibawah ini yang paling benar?',
                        'choice' => [
                            'Lanjutkan Mengemudi',
                            'Berhenti dan Tidur sejenak di tempat yang aman',
                            'Memutar lagu untuk mengaburkan rasa kantuk',
                            'Berhenti di bahu jalan dan menyalakan lampu hazard',
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'question' => '"Mengendarakan mobil dengan kondisi mesin dingin akan membuat usia kendaraan berkurang". Apakah pernyataan tersebut benar?',
                        'choice' => [
                            'Tidak, suhu mobil mesin tidak ada hubungannya dengan usia kendaraan',
                            'Benar, mesin mobil sebaiknya dipanaskan terlebih dahulu',
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'question' => '"Kondisi tekanan angin ban yang kurang akan berpengaruh terhadap borosnya bahan bakar kendaraan". Apakah pernyataan tersebut benar?',
                        'choice' => [
                            'Salah',
                            'Benar',
                        ],
                        'correctAnswer' => 1
                    ],
                ],
            ],

            2 => [
                'title' => 'Jenis Transmisi Mobil dan Dasar-Dasar Mengemudi',
                'title-image-mobile' => 'types_of_transmission_mobile.webp', 
                'title-image-desktop' => 'types_of_transmission_desktop.webp', 
                'slides' => [
                    [
                        'question' => 'Apa perbedaan utama antara transmisi manual dan otomatis?',
                        'choice' => [
                            'Transmisi manual lebih efisien bahan bakar, sedangkan transmisi otomatis lebih nyaman.',
                            'Keduanya memiliki efisiensi bahan bakar yang sama.',
                            'Transmisi manual lebih sulit digunakan daripada transmisi otomatis.',
                            'Semua jawaban salah.'
                        ],
                        'correctAnswer' => 0
                    ],
                    [
                        'question' => 'Kapan sebaiknya menggunakan gigi 1 pada mobil manual?',
                        'choice' => [
                            'Saat melaju di jalan tol.',
                            'Saat memulai perjalanan atau dalam kondisi jalan yang sangat lambat.',
                            'Saat mendaki tanjakan yang curam.',
                            'Saat melewati tikungan tajam.'
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'question' => 'Apa fungsi posisi "N" pada transmisi otomatis?',
                        'choice' => [
                            'Untuk mundur.',
                            'Untuk parkir.',
                            'Untuk berhenti sementara atau menunda transmisi.',
                            'Untuk melaju dengan kecepatan tinggi.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Dalam kondisi banjir, gigi mana yang sebaiknya digunakan pada mobil manual untuk menjaga mesin tetap hidup?',
                        'choice' => [
                            'Gigi 4 atau 5.',
                            'Gigi 3.',
                            'Gigi 2 atau 1.',
                            'Tidak perlu mengubah gigi.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Manakah pernyataan yang BENAR mengenai penggunaan gigi saat mendaki tanjakan?',
                        'choice' => [
                            'Gunakan gigi tertinggi untuk mengurangi beban mesin.',
                            'Gunakan gigi terendah untuk membantu mesin mengatasi tanjakan.',
                            'Tidak perlu mengubah gigi saat mendaki.',
                            'Gunakan gigi netral untuk menjaga kecepatan konstan.'
                        ],
                        'correctAnswer' => 1
                    ],
                ],                
            ],

            3 => [
                'title' => 'Rambu Jalan, Marka Jalan, dan Lampu Lalu Lintas',
                'title-image-mobile' => 'road_attributes_mobile.webp', 
                'title-image-desktop' => 'road_attributes_desktop.webp', 
                'slides' => [
                    [
                        'question' => 'Apa fungsi utama dari tanda-tanda peringatan lalu lintas?',
                        'choice' => [
                            'Memberikan instruksi yang harus diikuti oleh pengemudi.',
                            'Memberikan informasi tentang potensi bahaya di depan.',
                            'Memberikan petunjuk arah dan informasi bermanfaat.',
                            'Menunjukkan batas kecepatan maksimum.'
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'question' => 'Apa yang diartikan oleh garis putus-putus pada marka jalan?',
                        'choice' => [
                            'Larangan untuk berpindah jalur.',
                            'Izin untuk berpindah jalur.',
                            'Menunjukkan adanya tikungan tajam.',
                            'Menunjukkan adanya persimpangan.'
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'Siapa yang harus diprioritaskan saat melewati zebra cross?',
                        'choice' => [
                            'Kendaraan yang datang dari arah berlawanan.',
                            'Kendaraan yang berjalan lurus.',
                            'Pejalan kaki.',
                            'Tidak ada yang harus diprioritaskan.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'Apa warna umum untuk tanda-tanda informasi lalu lintas?',
                        'choice' => [
                            'Merah',
                            'Biru atau hijau.',
                            'Kuning',
                            'Hitam dan putih.'
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'Apa yang harus dilakukan saat melihat lampu lalu lintas berwarna kuning?',
                        'choice' => [
                            'Segera berhenti.',
                            'Bersiap-siap untuk berhenti.',
                            'Melaju dengan kecepatan tinggi.',
                            'Melaju dengan kecepatan rendah.'
                        ],
                        'correctAnswer' => 1
                    ],
                ],                
            ],

            4 => [
                'title' => 'Etika dan Kewajiban Pengemudi',
                'title-image-mobile' => 'driving_ethics_mobile.webp', 
                'title-image-desktop' => 'driving_ethics_desktop.webp', 
                'slides' => [
                    [
                        'question' => 'Apa yang harus dilakukan sebelum menyalip kendaraan lain?',
                        'choice' => [
                            'Menyalakan lampu sein dan memastikan tidak ada kendaraan di titik buta.',
                            'Menyalakan lampu jauh dan mempercepat laju kendaraan.',
                            'Menyalip dari sisi kanan.',
                            'Tidak perlu melakukan tindakan apa-apa.'
                        ],
                        'correctAnswer' => 0
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan sebelum berpindah jalur?',
                        'choice' => [
                            'Menyalakan lampu sein dan memastikan jalur tujuan kosong.',
                            'Menyalakan lampu jauh dan mempercepat laju kendaraan.',
                            'Tidak perlu melakukan apa-apa.',
                            'Langsung berpindah jalur tanpa melihat ke belakang.'
                        ],
                        'correctAnswer' => 0
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan saat melihat kendaraan darurat dengan sirene dan lampu berkedip?',
                        'choice' => [
                            'Mengerem mendadak untuk menghentikan kendaraan.',
                            'Menyalakan lampu jauh untuk memberi sinyal.',
                            'Memberikan jalan kepada kendaraan darurat.',
                            'Tidak melakukan apa-apa.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan saat memasuki persimpangan bundaran?',
                        'choice' => [
                            'Langsung melaju tanpa memperhatikan kendaraan lain.',
                            'Menyalip kendaraan yang sudah berada di dalam bundaran.',
                            'Memberikan jalan kepada kendaraan yang sudah berada di dalam bundaran.',
                            'Tidak melakukan apa-apa.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan saat ingin melakukan putar balik?',
                        'choice' => [
                            'Putar balik di mana saja yang dianggap aman.',
                            'Putar balik hanya di tempat yang diizinkan dan tidak mengganggu lalu lintas.',
                            'Putar balik dengan cara mundur.',
                            'Tidak melakukan putar balik.'
                        ],
                        'correctAnswer' => 1
                    ],
                ],                
            ],

            5 => [
                'title' => 'Hukum-Hukum di Jalan Raya',
                'title-image-mobile' => 'basic_driving_mobile.webp', 
                'title-image-desktop' => 'basic_driving_desktop.webp', 
                'slides' => [
                    [
                        'question' => 'Apa yang harus dilakukan jika dihentikan oleh polisi?',
                        'choice' => [
                            'Mencoba melarikan diri.',
                            'Berhenti di tempat yang aman dan tetap tenang.',
                            'Berdebat dengan petugas polisi.',
                            'Tidak memberikan dokumen yang diminta.'
                        ],
                        'correctAnswer' => 1
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan setelah terjadi kecelakaan?',
                        'choice' => [
                            'Langsung meninggalkan tempat kejadian.',
                            'Mencari bantuan dari orang-orang di sekitar.',
                            'Menghubungi polisi dan memeriksa korban luka.',
                            'Tidak melakukan apa-apa.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Apa yang harus dilakukan jika terjadi kecelakaan?',
                        'choice' => [
                            'Langsung meninggalkan tempat kejadian.',
                            'Mencari bantuan dari orang-orang di sekitar.',
                            'Menghubungi polisi dan memeriksa korban luka.',
                            'Tidak melakukan apa-apa.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Apa yang dianggap sebagai pelanggaran lalu lintas?',
                        'choice' => [
                            'Mengemudi dengan kecepatan yang sesuai.',
                            'Menyalakan lampu sein saat berbelok.',
                            'Mengemudi sambil mengobrol di telepon.',
                            'Tidak ada yang dianggap pelanggaran lalu lintas.'
                        ],
                        'correctAnswer' => 2
                    ],
                    [
                        'question' => 'Dokumen apa saja yang wajib dibawa saat mengemudi?',
                        'choice' => [
                            'SIM, STNK, dan bukti asuransi kendaraan.',
                            'SIM saja.',
                            'STNK saja.',
                            'Tidak ada dokumen yang wajib dibawa.'
                        ],
                        'correctAnswer' => 0
                    ],
                ],                
            ],
        ];
    
        $enrollment = Enrollment::findOrFail($enrollment_id);
        
        // Check if the meeting_number exists in the content array
        if (!array_key_exists($meeting_number, $content)) {
            // Generate a flash message via Toastr to let user know that there's no quiz
            session()->flash('warning', 'Quiz untuk Pertemuan ' . $meeting_number . ' belum tersedia');
            return redirect(url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment_id));
        }

        return view('student-page.user-course-quiz', [
            'pageName' => "Quiz | ",
            'enrollment' => $enrollment,
            'meeting_number' => $meeting_number,
            'content' => $content[$meeting_number],
        ]);
    }

    // New Driving School Page Controller
    public function newDrivingSchool() {
        $user = auth()->user();

        return view('student-page.new-driving-school', [
            'pageName' => "Ajukan Kursus Mengemudi Baru | ",
            'user' => $user,
        ]);
    }
}
