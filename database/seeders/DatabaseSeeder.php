<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\DrivingSchoolLicense;
use App\Models\InstructorCertificate;
use App\Models\Course;
use App\Models\CourseInstructor;
use App\Models\CourseSchedule;
use App\Models\Enrollment;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Pemilik / Admin',
            'username' => 'pemilik_kursus',
            'phone_number' => '+6282145749388',
            'password' => bcrypt('sayapemilik'),
            'role' => "admin",
            'description' => 'House of Surabaya Driving School'
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi Magetan',
            'username' => 'kursus_magetan',
            'phone_number' => '+628310231231',
            'password' => bcrypt('magetan'),
            'role' => "admin",
            'description' => 'House of Magetan Driving School'
        ]);
        User::create([
            'fullname' => 'Instruktur A',
            'username' => 'instruktur_A',
            'phone_number' => '+6281401203102',
            'password' => bcrypt('sayaA'),
            'age' => 28,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Surabaya',
            'availability' => 0,
            'admin_id' => 1
        ]);
        User::create([
            'fullname' => 'Instruktur Manual',
            'username' => 'instruktur_manual',
            'phone_number' => '+6281401203103',
            'password' => bcrypt('sayaB'),
            'age' => 33,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Surabaya',
            'availability' => 1,
            'admin_id' => 1
        ]);
        User::create([
            'fullname' => 'Instruktur Matic',
            'username' => 'instruktur_matic',
            'phone_number' => '+6281401503103',
            'password' => bcrypt('sayaC'),
            'age' => 30,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Surabaya',
            'availability' => 0,
            'admin_id' => 1
        ]);
        User::create([
            'fullname' => 'Siswa 1',
            'username' => 'Siswa_1',
            'phone_number' => '+6281403203103',
            'password' => bcrypt('sayasiswa1'),
            'age' => 19,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
        ]);
        User::create([
            'fullname' => 'Siswa 2',
            'username' => 'Siswa_2',
            'phone_number' => '+6281503203103',
            'password' => bcrypt('sayasiswa2'),
            'age' => 27,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
        ]);
        User::create([
            'fullname' => 'Siswa 3',
            'username' => 'Siswa_3',
            'phone_number' => '+6281703203103',
            'password' => bcrypt('sayasiswa3'),
            'age' => 24,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
        ]);

        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2024-08-21',
            'endLicenseDate' => '2026-08-21',
            'licenseStatus' => 'Sudah Tervalidasi',
            'admin_id' => 1,
        ]);
        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2022-08-21',
            'endLicenseDate' => '2024-08-21',
            'licenseStatus' => 'Aktif',
            'admin_id' => 1,
        ]);
        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2020-08-21',
            'endLicenseDate' => '2022-08-21',
            'licenseStatus' => 'Tidak Berlaku',
            'admin_id' => 1,
        ]);

        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Belum Divalidasi',
            'instructor_id' => 3,
        ]);
        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Sudah Divalidasi',
            'instructor_id' => 4,
        ]);
        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Sudah Divalidasi',
            'instructor_id' => 5,
        ]);

        Course::create([
            'course_name' => 'Kursus Mobil Manual untuk Pemula',
            'course_description' => 'Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda. Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 770000,
            'course_length' => 5,
            'course_duration' => 90,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 1,
        ]);
        Course::create([
            'course_name' => 'Kursus Mobil Matic untuk Pemula',
            'course_description' => 'Untuk anda yang baru belajar mengemudi dengan mobil matic, kursus ini tepat untuk anda.',
            'course_quota' => 5,
            'course_price' => 900000,
            'course_length' => 5,
            'course_duration' => 90,
            'car_type' => "Automatic",
            'can_use_own_car' => false,
            'course_availability' => 0,
            'admin_id' => 1,
        ]);
        Course::create([
            'course_name' => 'Kursus Kilat Mobil Manual',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat, kursus ini tepat untuk anda.',
            'course_quota' => 3,
            'course_price' => 650000,
            'course_length' => 3,
            'course_duration' => 90,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 1,
        ]);
        Course::create([
            'course_name' => 'Kursus Privat',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobila anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 6,
            'course_price' => 1200000,
            'course_length' => 5,
            'course_duration' => 120,
            'car_type' => "Both",
            'can_use_own_car' => true,
            'admin_id' => 1,
        ]);

        Enrollment::create([
            'course_id' => 1,
            'instructor_id' => 4,
            'student_id' => 6,
            'student_real_name' => 'Nama Saya Budi',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Madiun',
            'student_birth_of_date' => '1997-08-30',
            'student_occupation' => 'Karyawan Swasta',
            'student_phone_number' => '+6281403203103',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'Magister',
        ]);
        Enrollment::create([
            'course_id' => 2,
            'instructor_id' => 5,
            'student_id' => 7,
            'student_real_name' => 'Nama Saya Ani',
            'student_gender' => 'Wanita',
            'student_birth_of_place' => 'Trenggalek',
            'student_birth_of_date' => '1989-01-14',
            'student_occupation' => 'Wiraswasta',
            'student_phone_number' => '+6281403283713',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'SMA/SMK Sederajat',
        ]);

        CourseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 3,
        ]);
        CourseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 3,
        ]);
        CourseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 5,
        ]);
        CourseInstructor::create([
            'course_id' => 3,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 3,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 5,
        ]);

        // Pertemuan 1, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-01 08:00:00',
            'end_time' => '2024-08-01 09:30:00',
            'meeting_number' => 1,
        ]);
        // Pertemuan 2, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-08 08:00:00',
            'end_time' => '2024-08-08 09:30:00',
            'meeting_number' => 2,
        ]);
        // Pertemuan 3, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-15 08:00:00',
            'end_time' => '2024-08-15 09:30:00',
            'meeting_number' => 3,
        ]);
        // Pertemuan 4, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-22 08:00:00',
            'end_time' => '2024-08-22 09:30:00',
            'meeting_number' => 4,
        ]);
        // Pertemuan 5, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-29 08:00:00',
            'end_time' => '2024-08-29 09:30:00',
            'meeting_number' => 5,
        ]);

        // Pertemuan 1, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-07-14 13:00:00',
            'end_time' => '2024-07-14 14:30:00',
            'meeting_number' => 1,
        ]);
        // Pertemuan 2, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-07-21 13:00:00',
            'end_time' => '2024-07-21 14:30:00',
            'meeting_number' => 2,
        ]);
        // Pertemuan 3, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-07-28 13:00:00',
            'end_time' => '2024-07-28 14:30:00',
            'meeting_number' => 3,
        ]);
        // Pertemuan 4, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-08-04 13:00:00',
            'end_time' => '2024-08-04 14:30:00',
            'meeting_number' => 4,
        ]);
        // Pertemuan 5, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-08-11 13:00:00',
            'end_time' => '2024-08-11 14:30:00',
            'meeting_number' => 5,
        ]);

        PaymentMethod::create([
            'payment_vendor' => "BCA",
            'payment_receiver_name' => "Agus",
            'payment_address' => Crypt::encryptString("282831039210"),
            'is_payment_active' => 1,
            'admin_id' => 1,
        ]);
    }
}
