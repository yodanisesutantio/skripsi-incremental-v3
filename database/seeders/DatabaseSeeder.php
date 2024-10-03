<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\DrivingSchoolLicense;
use App\Models\InstructorCertificate;
use App\Models\Course;
use App\Models\CourseInstructor;
use App\Models\CoursePayment;
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
            'fullname' => 'Master KEMUDI',
            'username' => 'master_kemudi_',
            'phone_number' => '+6282145649388',
            'password' => bcrypt('ichbindersystemmaster'),
            'role' => "sysAdmin",
            'fp_question' => 'Wie ist es in Surabaya?',
            'fp_answer' => Crypt::encryptString("Surabaya ist zu heiß"),
        ]);
        User::create([
            'fullname' => 'Pemilik / Admin',
            'username' => 'pemilik_kursus',
            'phone_number' => '+6282145749388',
            'password' => bcrypt('sayapemilik'),
            'role' => "admin",
            'description' => 'House of Surabaya Driving School',
            'open_hours_for_admin' => '08:00:00',
            'close_hours_for_admin' => '17:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi Magetan',
            'username' => 'kursus_magetan',
            'phone_number' => '+628310231231',
            'password' => bcrypt('magetan'),
            'role' => "admin",
            'description' => 'House of Magetan Driving School',
            'open_hours_for_admin' => '09:00:00',
            'close_hours_for_admin' => '20:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
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
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
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
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
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
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
        ]);
        User::create([
            'fullname' => 'Siswa 1',
            'username' => 'Siswa_1',
            'phone_number' => '+6281403203103',
            'password' => bcrypt('sayasiswa1'),
            'age' => 19,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
            'fp_question' => 'Sebutkan Ibu Kota Negara Jerman',
            'fp_answer' => Crypt::encryptString("Berlin"),
        ]);
        User::create([
            'fullname' => 'Siswa 2',
            'username' => 'Siswa_2',
            'phone_number' => '+6281503203103',
            'password' => bcrypt('sayasiswa2'),
            'age' => 27,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
            'fp_question' => 'Sebutkan Ibu Kota Negara Jepang',
            'fp_answer' => Crypt::encryptString("Tokyo"),
        ]);
        User::create([
            'fullname' => 'Siswa 3',
            'username' => 'Siswa_3',
            'phone_number' => '+6281703203103',
            'password' => bcrypt('sayasiswa3'),
            'age' => 24,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
            'fp_question' => 'Lingkaran mempunyai berapa sisi?',
            'fp_answer' => Crypt::encryptString("Satu"),
        ]);

        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2024-08-21',
            'endLicenseDate' => '2026-08-21',
            'licenseStatus' => 'Sudah Tervalidasi',
            'admin_id' => 2,
        ]);
        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2022-08-21',
            'endLicenseDate' => '2024-08-21',
            'licenseStatus' => 'Aktif',
            'admin_id' => 2,
        ]);
        DrivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2020-08-21',
            'endLicenseDate' => '2022-08-21',
            'licenseStatus' => 'Tidak Berlaku',
            'admin_id' => 2,
        ]);

        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Belum Divalidasi',
            'instructor_id' => 4,
        ]);
        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Sudah Divalidasi',
            'instructor_id' => 5,
        ]);
        InstructorCertificate::create([
            'certificatePath' => '1722614055.webp',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Sudah Divalidasi',
            'instructor_id' => 6,
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
            'admin_id' => 2,
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
            'admin_id' => 2,
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
            'admin_id' => 2,
        ]);
        Course::create([
            'course_name' => 'Kursus Privat',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda. Anda bebas memilih transmisi yang ingin anda pelajari.',
            'course_quota' => 6,
            'course_price' => 1200000,
            'course_length' => 5,
            'course_duration' => 120,
            'car_type' => "Both",
            'can_use_own_car' => true,
            'admin_id' => 2,
        ]);

        // Course::create([
        //     'course_name' => 'Belajar Mengemudi Mobil Manual',
        //     'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
        //     'course_quota' => 10,
        //     'course_price' => 1200000,
        //     'course_length' => 6,
        //     'course_duration' => 90,
        //     'car_type' => "Manual",
        //     'can_use_own_car' => false,
        //     'admin_id' => 2,
        // ]);
        // Course::create([
        //     'course_name' => 'Belajar Mengemudi Mobil Matic',
        //     'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
        //     'course_quota' => 8,
        //     'course_price' => 1400000,
        //     'course_length' => 6,
        //     'course_duration' => 90,
        //     'car_type' => "Automatic",
        //     'can_use_own_car' => false,
        //     'admin_id' => 2,
        // ]);
        // Course::create([
        //     'course_name' => 'Kursus Mengemudi Murah di Magetan',
        //     'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
        //     'course_quota' => 8,
        //     'course_price' => 900000,
        //     'course_length' => 5,
        //     'course_duration' => 90,
        //     'car_type' => "Both",
        //     'can_use_own_car' => false,
        //     'admin_id' => 2,
        // ]);
        // Course::create([
        //     'course_name' => 'Kursus Mengemudi Mobil Magetan',
        //     'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
        //     'course_quota' => 11,
        //     'course_price' => 1000000,
        //     'course_length' => 7,
        //     'course_duration' => 60,
        //     'car_type' => "Both",
        //     'can_use_own_car' => false,
        //     'admin_id' => 2,
        // ]);
        // Course::create([
        //     'course_name' => 'Kursus Mengemudi Mobil Mandiri',
        //     'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
        //     'course_quota' => 5,
        //     'course_price' => 1700000,
        //     'course_length' => 6,
        //     'course_duration' => 90,
        //     'car_type' => "Both",
        //     'can_use_own_car' => false,
        //     'admin_id' => 2,
        // ]);

        Enrollment::create([
            'course_id' => 1,
            'instructor_id' => 5,
            'student_id' => 7,
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
            'instructor_id' => 6,
            'student_id' => 8,
            'student_real_name' => 'Nama Saya Ani',
            'student_gender' => 'Wanita',
            'student_birth_of_place' => 'Trenggalek',
            'student_birth_of_date' => '1989-01-14',
            'student_occupation' => 'Wiraswasta',
            'student_phone_number' => '+6281403283713',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'SMA/SMK Sederajat',
        ]);
        Enrollment::create([
            'course_id' => 4,
            'instructor_id' => 5,
            'student_id' => 9,
            'student_real_name' => 'Nama Saya Arya',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Gresik',
            'student_birth_of_date' => '1999-04-14',
            'student_occupation' => 'Wiraswasta',
            'student_phone_number' => '+6281403232713',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'S1 Sederajat',
        ]);
        Enrollment::create([
            'course_id' => 1,
            'instructor_id' => 4,
            'student_id' => 7,
            'student_real_name' => 'Lolok',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Banjarmasin',
            'student_birth_of_date' => '1997-10-11',
            'student_occupation' => 'Karyawan Swasta',
            'student_phone_number' => '+62881041401285',
            'student_address' => 'Bangkalan, Madura',
            'student_education_level' => 'S1/D4',
        ]);

        CourseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 5,
        ]);
        CourseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 6,
        ]);
        CourseInstructor::create([
            'course_id' => 3,
            'instructor_id' => 5,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 4,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 5,
        ]);
        CourseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 6,
        ]);

        // Pertemuan 1, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-09-11 08:00:00',
            'end_time' => '2024-09-11 09:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-09-18 08:00:00',
            'end_time' => '2024-09-18 09:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-09-25 08:00:00',
            'end_time' => '2024-09-25 09:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-10-01 08:00:00',
            'end_time' => '2024-10-01 09:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, Enrollment 1
        CourseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-10-08 08:00:00',
            'end_time' => '2024-10-08 09:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-09-11 15:30:00',
            'end_time' => '2024-09-11 17:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-09-18 15:30:00',
            'end_time' => '2024-09-18 17:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 3, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-09-25 15:30:00',
            'end_time' => '2024-09-25 17:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 4, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-10-01 15:30:00',
            'end_time' => '2024-10-01 17:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 5, Enrollment 2
        CourseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 5,
            'start_time' => '2024-10-08 15:30:00',
            'end_time' => '2024-10-08 17:00:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, Enrollment 3
        CourseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-10-24 13:00:00',
            'end_time' => '2024-10-24 14:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, Enrollment 3
        CourseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-10-31 13:00:00',
            'end_time' => '2024-10-31 14:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 3, Enrollment 3
        CourseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-11-07 13:00:00',
            'end_time' => '2024-11-07 14:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 4, Enrollment 3
        CourseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-11-11 13:00:00',
            'end_time' => '2024-11-11 14:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 5, Enrollment 3
        CourseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-11-18 13:00:00',
            'end_time' => '2024-11-18 14:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, Enrollment 4
        CourseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-11 08:00:00',
            'end_time' => '2024-08-11 09:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, Enrollment 4
        CourseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-18 08:00:00',
            'end_time' => '2024-08-18 09:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, Enrollment 4
        CourseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-08-25 08:00:00',
            'end_time' => '2024-08-25 09:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, Enrollment 4
        CourseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-09-01 08:00:00',
            'end_time' => '2024-09-01 09:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, Enrollment 4
        CourseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-09-08 08:00:00',
            'end_time' => '2024-09-08 09:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Bukti Pembayaran untuk Siswa 1
        CoursePayment::create([
            'enrollment_id' => 1,
            'paymentFile' => '1723140944.png',
        ]);
        // Bukti Pembayaran untuk Siswa 2
        CoursePayment::create([
            'enrollment_id' => 2,
            'paymentFile' => '1722842843.png',
        ]);
        // Bukti Pembayaran untuk Siswa 3
        CoursePayment::create([
            'enrollment_id' => 3,
            'paymentFile' => '1722842843.png',
        ]);

        PaymentMethod::create([
            'payment_vendor' => "BCA",
            'payment_receiver_name' => "Agus",
            'payment_address' => Crypt::encryptString("282831039210"),
            'is_payment_active' => 1,
            'admin_id' => 2,
        ]);
        PaymentMethod::create([
            'payment_vendor' => "Mandiri",
            'payment_receiver_name' => "Kursus Magetan",
            'payment_address' => Crypt::encryptString("283101263159"),
            'is_payment_active' => 1,
            'admin_id' => 3,
        ]);
    }
}
