<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // Use Carbon Method by Laravel

use App\Models\User; // Access User Tables
use App\Models\Course; // Access Course Tables
use App\Models\CourseSchedule; // Access Course Schedule Tables
use App\Models\CourseInstructor; // Access Course Instructor Tables
use App\Models\InstructorCertificate; // Access Course Instructor Tables
use App\Models\Enrollment; // Access Enrollment Tables
use App\Models\PaymentMethod; // Access PaymentMethod Tables
use Illuminate\Http\Request; // Use Request Method by Laravel
use Illuminate\Support\Facades\Auth; // Use Auth Method by Laravel
use Illuminate\Support\Facades\DB; // Use DB Method by Laravel
use Illuminate\Support\Facades\Storage; // Use Storage Method by Laravel
use Illuminate\Support\Facades\Crypt; // Use Crypt Method by Laravel

class systemController extends Controller
{
    public function systemIndex() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Access User Tables
        $user = User::where('role', '!=', 'sysAdmin')->get();

        // dd($user);

        return view('home.sysAdmin', [
            "pageName" => "Daftar Pengguna | ",
            "user" => $user,
        ]);
    }

    public function resetPassword(Request $request, $id) {
        // Validate the request if necessary
        $request->validate([
            'password' => 'required|min:5|max:255',
        ]);

        // dd($request);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Update the user's password
        $user->password = bcrypt($request->password);
        $user->save();
    
        $request->session()->flash('success', 'Password berhasil diatur ulang!');
        // Redirect back with a success message
        return redirect('/sysAdmin-index');
    }

    public function certificatePage() {
        // Manipulate and localize this page to Indonesian 
        Carbon::setLocale('id');

        // Get today's date and localized it to Indonesian
        $today = Carbon::today();

        // Access User Tables
        $certificate = InstructorCertificate::all();

        // Run through the Instructor Certificate collection
        foreach ($certificate as $certificates) {
            // Localize the startCertificateDate to Indonesian
            $startDate = Carbon::parse($certificates->startCertificateDate);
            // Localize the endCertificateDate to Indonesian
            $endDate = Carbon::parse($certificates->endCertificateDate);
    
            // Avoid certificate that has certificateStatus of "Belum Divalidasi"
            if ($certificates->certificateStatus !== 'Belum Divalidasi' && $certificates->certificateStatus !== 'Validasi Gagal') {
                // If today's date is between the startCertificateDate and endCertificateDate 
                if ($startDate->lte($today) && $endDate->gt($today)) {
                    // Change the certificateStatus to "Aktif"
                    $certificates->certificateStatus = 'Aktif';
                } 
                
                // if today's date is way past the endCertificateDate
                elseif ($endDate->lt($today)) {
                    // Change the certificateStatus to "Tidak Berlaku"
                    $certificates->certificateStatus = 'Tidak Berlaku';
                }

                // Update the certificate data
                $certificates->save();
            }
        }

        return view('sysadmin-page.sysadmin-certificate', [
            "pageName" => "Sertifikat Instruktur | ",
            "certificate" => $certificate,
        ]);
    }

    // Instructor Certificate Delete Logic Handler
    public function updateCertificateStatus($id, Request $request)
    {
        // Validate the request if necessary
        $request->validate([
            'certificateStatus' => 'required|string',
        ]);

        // find the desired license match the incoming ID with the ID from DrivingSchoolLicense Tables
        $certificate = InstructorCertificate::findOrFail($id);
    
        // Change the certificateStatus to "Aktif"
        $certificate->certificateStatus = $request['certificateStatus'];
        // Update the certificate data
        $certificate->save();

        // Generate a flash message via Toastr to let user know that the process is successful
        if ($request['certificateStatus'] === 'Sudah Divalidasi') {
            $request->session()->flash('success', 'Sertifikat Instruktur berhasil divalidasi!');
        } elseif ($request['certificateStatus'] === 'Validasi Gagal') {
            $request->session()->flash('success', 'Validasi Sertifikat Instruktur digagalkan!');
        }
        
        // Redirect Admin to List of Instructor Certificate
        return redirect()->intended('/sysAdmin-certificate');
    }

    // Instructor Certificate Delete Logic Handler
    public function deleteCertificate($id, Request $request)
    {
        // find the desired license match the incoming ID with the ID from DrivingSchoolLicense Tables
        $certificate = InstructorCertificate::findOrFail($id);
    
        // Delete the thumbnail from storage
        if ($certificate->certificatePath) {
            Storage::delete('instructor_certificate/' . $certificate->certificatePath);
        }

        // Delete the desired InstructorCertificate
        $certificate->delete();
        // Generate a flash message via Toastr to let user know that the process is successful
        $request->session()->flash('success', 'Sertifikat Instruktur berhasil dihapus!');
        // Redirect Admin to List of Instructor Certificate
        return redirect()->intended('/sysAdmin-certificate');
    }
}
