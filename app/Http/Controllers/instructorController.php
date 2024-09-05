<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\InstructorCertificate; // Access Instructor Certificate Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\Enrollment; // Access Enrollment Tables
use App\Models\PaymentMethod; // Access PaymentMethod Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class instructorController extends Controller
{
    // Instructor-Index Page Controller
    public function instructorIndex() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');
        
        // Check for incoming course schedules for the authenticated admin
        $incomingSchedule = CourseSchedule::where('instructor_id', auth()->id())
            ->where('start_time', '>', now()) // Filter for upcoming schedules
            ->orderBy('start_time', 'asc') // Order by start time
            ->first(); // Get the first upcoming schedule

        // Localize the startLicenseDate to Indonesian and formatted to be written as this "20 Agt 2024"
        if ($incomingSchedule) {
            $incomingSchedule->formattedStartDate = Carbon::parse($incomingSchedule->start_time)->translatedFormat('d F Y');
            $incomingSchedule->formattedStartTime = Carbon::parse($incomingSchedule->start_time)->translatedFormat('H:i');
            $incomingSchedule->formattedEndTime = Carbon::parse($incomingSchedule->end_time)->translatedFormat('H:i');
        }

        // Fetch today's schedule from the course_schedule table
        $todaySchedule = CourseSchedule::where('instructor_id', auth()->id())
            ->whereDate('start_time', \Carbon\Carbon::today())
            ->orderBy('start_time', 'asc')
            ->get();

        // Run through each today schedule and format the start time and end time to be written as 20:15
        if ($todaySchedule->isNotEmpty()) {
            $todaySchedule->each(function ($schedule) {
                $schedule->formattedStartTime = Carbon::parse($schedule->start_time)->translatedFormat('H:i');
                $schedule->formattedEndTime = Carbon::parse($schedule->end_time)->translatedFormat('H:i');
            });
        }

        // Fetch schedules for the next 7 days
        $nextWeekSchedules = [];
        for ($i = 1; $i <= 6; $i++) {
        $nextWeekSchedules[$i] = CourseSchedule::where('instructor_id', auth()->id())
            ->whereDate('start_time', \Carbon\Carbon::today()->addDays($i))
            ->get();

            // The Same as the today schedule, run through each schedule and format the start time and end time 08:00
            if ($nextWeekSchedules[$i]->isNotEmpty()) {
                $nextWeekSchedules[$i]->each(function ($schedule) {
                    $schedule->formattedStartTime = Carbon::parse($schedule->start_time)->translatedFormat('H:i');
                    $schedule->formattedEndTime = Carbon::parse($schedule->end_time)->translatedFormat('H:i');
                });
            }
        }

        // dd($todaySchedule);
    
        return view('home.instructor', [
            "pageName" => "Beranda | ",
            "incomingSchedule" => $incomingSchedule,
            "todaySchedule" => $todaySchedule,
            "nextWeekSchedules" => $nextWeekSchedules,
        ]);
    }
    
    // Admin-Profile Page Controller
    public function instructorProfile() {
        return view('profile.instructor-profile', [
            "pageName" => "Profil Anda | ",
        ]);
    }

    // Instructor-Profile/Edit Page Controller
    public function editProfilePage() {// Check for active instructor certificates
        $hasActiveLicense = InstructorCertificate::where('instructor_id', auth()->id())
            ->where('certificateStatus', 'Sudah Divalidasi')
            ->exists();

        return view('profile.edit-instructor-profile', [
            "pageName" => "Edit Profil | ",
            "hasActiveLicense" => $hasActiveLicense,
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
            'age' => 'integer|min:18|max:70',
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

        // Save new User data
        $user->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Profil berhasil diperbarui!');
        // Redirect owner/admin to List of Course Page
        return redirect()->intended('/instructor-profile');
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
        // Redirect instructor to profile page
        return redirect()->intended('/instructor-profile');
    }

    // Deactivate Instructor Logic Handler
    public function deactivateInstructor(Request $request) {
        // find the Instructor by matching the user_id with the incoming request from User Tables
        $user = User::find($request->user_id);

        // If user is found, do this data transaction
        if ($user) {
            // Change the availability attribute value to 0
            $user->availability = 0;
            // Save the new data
            $user->save();
    
            // Return success response to JSON
            return response()->json(['success' => true]);
        }
    
        // Return failed response to JSON when no user is found
        return response()->json(['success' => false], 400);
    }

    // Activate Instructor Logic Handler
    public function activateInstructor(Request $request) {
        // find the Instructor by matching the user_id with the incoming request from User Tables
        $user = User::find($request->user_id);

        // If user is found, do this data transaction
        if ($user) {
            // Change the availability attribute value to 0
            $user->availability = 1;
            // Save the new data
            $user->save();

            // Return success response to JSON
            return response()->json(['success' => true]);
        }

        // Return failed response to JSON when no user is found
        return response()->json(['success' => false], 400);
    }

    // Create new Instructor Form Logic Handler
    public function createInstructorLogic(Request $request) {
        // Validation Rules
        $this->validate($request, [
            'certificatePath' => 'required|mimes:jpeg,png,jpg,webp|max:2048',
            'startCertificateDate' => 'required',
            'endCertificateDate' => 'required',
            'hash_for_profile_picture' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'fullname' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'age' => 'nullable|integer|min:18|max:99',
            'description' => 'nullable|max:255',
            'phone_number' => 'required|max:20|unique:users',
            'password' => 'required|min:5|max:255|confirmed',
            'password_confirmation' => 'required|min:5|max:255',
        ],
        
        // Validation Error Messages
        [
            'certificatePath.required' => 'Silahkan pilih Sertifikat Instruktur untuk diunggah',
            'certificatePath.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'certificatePath.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'startCertificateDate.required' => 'Kolom ini harus diisi',
            'endCertificateDate.required' => 'Kolom ini harus diisi',
            'hash_for_profile_picture.mimes' => 'Format yang didukung adalah .jpg, .png, dan .webp',
            'hash_for_profile_picture.max' => 'Ukuran gambar maksimal adalah 2 MB',
            'fullname.required' => 'Kolom ini harus diisi',
            'fullname.max' => 'Nama Terlalu Panjang',
            'username.required' => 'Kolom ini harus diisi',
            'username.max' => 'Username Terlalu Panjang',
            'username.unique' => 'Username sudah digunakan',
            'age.min' => 'Usia minimal adalah 18 Tahun',
            'age.max' => 'Usia maksimal adalah 99 Tahun',
            'description.max' => 'Deskripsi terlalu panjang',
            'phone_number.required' => 'Kolom ini harus diisi',
            'phone_number.max' => 'Nomor Terlalu Panjang',
            'password.required' => 'Kolom ini harus diisi',
            'password.min' => 'Password minimal berisi 5 karakter',
            'password.max' => 'Password terlalu panjang',
            'password.confirmed' => 'Pastikan anda mengetikkan password yang sama',
            'password_confirmation.required' => 'Ketik Ulang Password Anda',
            'password_confirmation.min' => 'Password minimal berisi 5 karakter',
            'password_confirmation.max' => 'Password terlalu panjang',
        ]);

        // Replace 0 or 62 from the first 2 number of the inputted phone_number with +62, so it is easier to add wa.me/ link
        $request['phone_number'] = preg_replace('/^(0|62)/', '+62', $request->input('phone_number'));

        // Detect if the incoming request has an uploaded profile picture
        if ($request->hasFile('hash_for_profile_picture')) {
            // assign the uploaded file to $file variable
            $file = $request->file('hash_for_profile_picture');
            // rename the file name to store it inside the database
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $file->storeAs('profile_pictures', $fileName);
        }
        
        // Create a new Instructor Data in User Tables
        $user = User::create([
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            'hash_for_profile_picture' => $fileName,
            // assign the value of the fullname attribute as per request
            'fullname' => $request->fullname,
            // assign the value of the username attribute as per request
            'username' => $request->username,
            // assign the value of the password attribute as per request but, we crypted it first
            'password' => bcrypt($request->password),
            // assign the value of the age attribute as per request
            'age' => $request->age,
            // assign the value of the description attribute as per request
            'description' => $request->description,
            // assign the value of the phone_number as it is already formatted from the request
            'phone_number' => $request->phone_number,
            // set the value of availability attribute to 0 by default, since sys_admin need to validate it first
            'availability' => 0,
            // assign the value of the admin_id attribute by the currently authenticated user
            'admin_id' => Auth()->id(),
        ]);
        
        // Save the new array of data to User Tables
        $user->save();


        // Detect if the incoming request has an uploaded certificate
        if ($request->hasFile('certificatePath')) {
            // assign the uploaded file to $fileCertificate variable
            $fileCertificate = $request->file('certificatePath');
            // rename the filename to store it inside the database
            $certificateFile = time() . '.' . $fileCertificate->getClientOriginalExtension();
            // save the uploaded file to Laravel Storage System
            $fileCertificate->storeAs('instructor_certificate', $certificateFile);
        }

        // Create a new Instructor Certificate Data in InstructorCertificate Tables
        $certificate = InstructorCertificate::create([
            // instead of the file being stored in database, we save the filename of the file from Laravel Storage
            'certificatePath' => $certificateFile,
            // assign the value of the startCertificateDate attribute as per request
            'startCertificateDate' => $request->startCertificateDate,
            // assign the value of the endCertificateDate attribute as per request
            'endCertificateDate' => $request->endCertificateDate,
            // assign the value of the instructor_id attribute from the newly added instructor above
            'instructor_id' => $user->id,
        ]);

        // Save the new array of data to InstructorCertificate Tables
        $certificate->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        session()->flash('success', 'Instruktur Berhasil Ditambahkan!');
        // Redirect user to List of Instructor Page
        return redirect()->intended('/admin-manage-instructor');
    }

    // Delete Instructor Logic Handler
    public function deleteInstructor($id) {
        // Find the instructor data by matching the incoming ID with the ID from User Tables
        $instructor = User::findOrFail($id);
    
        // Delete the thumbnail from storage
        if ($instructor->hash_for_profile_picture) {
            Storage::delete('profile_picture/' . $instructor->hash_for_profile_picture);
        }

        // Then Delete the data
        $instructor->delete();

        // Check if the owner/admin has any remaining instructors
        $remainingInstructors = User::where('admin_id', auth()->id())->count();

        // When they had no more instructors, generate this flash message via Toastr
        if ($remainingInstructors == 0) {
            session()->flash('warning', 'Anda sudah tidak memiliki Instruktur lagi!');
        } 
        
        // If they still had at least more than 1 instructors, generate this flash message via Toastr
        else {
            session()->flash('success', 'Instruktur Berhasil Dihapus');
        }
        // Redirect the admin to List of Instructor Page
        return redirect()->intended('/admin-manage-instructor');
    }

    public function instructorCertificatePage() {
        // Assign the current authenticated user ID to $instructorId
        $instructorId = auth()->id();
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');
    
        // Get today's date and localized it to Indonesian
        $today = Carbon::today();
    
        // Collect every Instructor Certificate that are owned by this instructor and sort it from the latest added instructor
        $instructorCertificate = InstructorCertificate::where('instructor_id', $instructorId)
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Set a default value to detect if instructor has an active certificate
        $hasActiveCertificate = false;    

        // Run through the Instructor Certificate collection
        foreach ($instructorCertificate as $certificate) {
            // Localize the startCertificateDate to Indonesian
            $startDate = Carbon::parse($certificate->startCertificateDate);
            // Localize the endCertificateDate to Indonesian
            $endDate = Carbon::parse($certificate->endCertificateDate);
    
            // Avoid certificate that has certificateStatus of "Belum Divalidasi"
            if ($certificate->certificateStatus !== 'Belum Divalidasi') {
                // If today's date is between the startCertificateDate and endCertificateDate 
                if ($startDate->lte($today) && $endDate->gt($today)) {
                    // Change the certificateStatus to "Aktif"
                    $certificate->certificateStatus = 'Aktif';
                    // change the $hasActiveCertificate to true, since we has an active certificate
                    $hasActiveCertificate = true;
                } 
                
                // if today's date is way past the endCertificateDate
                elseif ($endDate->lt($today)) {
                    // Change the certificateStatus to "Tidak Berlaku"
                    $certificate->certificateStatus = 'Tidak Berlaku';
                }

                // Update the certificate data
                $certificate->save();
            }
    
            // Localize the startCertificateDate to Indonesian and formatted to be written as this "20 Agt 2024"
            $certificate->formattedStartDate = Carbon::parse($certificate->startCertificateDate)->locale('id')->translatedFormat('d M Y');
            // Localize the endCertificateDate to Indonesian and formatted to be written as this "20 Agt 2024"
            $certificate->formattedEndDate = Carbon::parse($certificate->endCertificateDate)->locale('id')->translatedFormat('d M Y');
        }
    
        // Update user availability based on certificate status
        $user = User::find($instructorId);
        // If instructor has active certificate and current user availability is 0, activate instructor by changing the user availability to 1
        if ($hasActiveCertificate && $user->availability === 0) {
            $user->availability = true;
            $user->save();
        } 
        
        // If instructor has no active certificate and current user availability is 1, deactivate instructor by changing the user availability to 0
        elseif (!$hasActiveCertificate && $user->availability === 1) {
            $user->availability = false;
            $user->save();
        }
    
        // Find the first Instructor Certificate that has certificateStatus of "Aktif"
        $activeDrivingSchoolCertificate = $instructorCertificate->firstWhere('certificateStatus', 'Aktif');
    
        return view('instructor-page.instructor-certificate', [
            "pageName" => "Sertifikat Instruktur Anda | ",
            "activeCertificate" => $activeDrivingSchoolCertificate,
            "certificates" => $instructorCertificate,
        ]);
    }

    public function instructorCertificateForm() {
        return view('instructor-page.create-instructor-certificate', [
            "pageName" => "Unggah Sertifikat Instruktur Baru | ",
        ]);
    }
}
