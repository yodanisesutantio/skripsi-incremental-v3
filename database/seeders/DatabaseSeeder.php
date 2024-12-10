<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\drivingSchoolLicense;
use App\Models\instructorCertificate;
use App\Models\course;
use App\Models\courseInstructor;
use App\Models\coursePayment;
use App\Models\courseSchedule;
use App\Models\enrollment;
use App\Models\paymentMethod;
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
            'password' => bcrypt('ichbindersystemmeister'),
            'role' => "sysAdmin",
            'fp_question' => 'Wie ist es in Surabaya?',
            'fp_answer' => Crypt::encryptString("Surabaya ist zu heiß"),
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi Sie Bersaudara - Rungkut',
            'username' => 'sie_bersaudara_rungkut',
            'phone_number' => '+6282145749388',
            'password' => bcrypt('sayasiebersaudara'),
            'role' => "admin",
            'description' => 'Kursus Mengemudi Paling Lawas sak Suroboyo',
            'hash_for_profile_picture' => '1730173476.png',
            'open_hours_for_admin' => '08:00:00',
            'close_hours_for_admin' => '17:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi Mobil Pulung',
            'username' => 'pulung',
            'phone_number' => '+628310231231',
            'password' => bcrypt('sayapulung'),
            'role' => "admin",
            'description' => 'Kursus Mengemudi Pulung buka dari Jam 9 pagi sampai 8 malam',
            'hash_for_profile_picture' => '1732615376.png',
            'open_hours_for_admin' => '09:00:00',
            'close_hours_for_admin' => '20:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
        ]);
        User::create([
            'fullname' => 'Slamet',
            'username' => 'instruktur_slamet',
            'phone_number' => '+6281401203102',
            'password' => bcrypt('sayaSlamet'),
            'age' => 43,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Sie Bersaudara',
            'hash_for_profile_picture' => '1732615541.png',
            'availability' => 0,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
        ]);
        User::create([
            'fullname' => 'Rahmat',
            'username' => 'instruktur_rahmat',
            'phone_number' => '+6281175185063',
            'password' => bcrypt('sayaRahmat'),
            'age' => 33,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Sie Bersaudara',
            'hash_for_profile_picture' => '1732615690.png',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
        ]);
        User::create([
            'fullname' => 'Andika',
            'username' => 'instruktur_andika',
            'phone_number' => '+62819419481237',
            'password' => bcrypt('sayaAndika'),
            'age' => 27,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Sie Bersaudara',
            'hash_for_profile_picture' => '1732615605.png',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 2
        ]);
        User::create([
            'fullname' => 'Nabila',
            'username' => 'ini_nabila',
            'phone_number' => '+6281840191556',
            'password' => bcrypt('sayaNabila'),
            'age' => 19,
            'role' => 'user',
            'description' => '',
            'fp_question' => 'Sebutkan Ibu Kota Negara Jerman',
            'fp_answer' => Crypt::encryptString("Berlin"),
        ]);
        User::create([
            'fullname' => 'Faris',
            'username' => 'ini_Faris',
            'phone_number' => '+6287631714085',
            'password' => bcrypt('sayaFaris'),
            'age' => 27,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
            'fp_question' => 'Sebutkan Ibu Kota Negara Jepang',
            'fp_answer' => Crypt::encryptString("Tokyo"),
        ]);
        User::create([
            'fullname' => 'Fathurrochman',
            'username' => 'ini_Fathur',
            'phone_number' => '+6288213001478',
            'password' => bcrypt('sayaFathur'),
            'age' => 24,
            'role' => 'user',
            'description' => 'Saya adalah Siswa',
            'fp_question' => 'Lingkaran mempunyai berapa sisi?',
            'fp_answer' => Crypt::encryptString("Satu"),
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi Sie Bersaudara - Banyu Urip',
            'username' => 'sie_bersaudara_banyu_urip',
            'phone_number' => '+6288210291417',
            'password' => bcrypt('sayasiebersaudara'),
            'role' => "admin",
            'description' => 'Kursus Mengemudi Sie Bersaudara Banyu Urip',
            'hash_for_profile_picture' => '1732615186.png',
            'open_hours_for_admin' => '08:00:00',
            'close_hours_for_admin' => '17:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
            'availability' => 0,
        ]);
        User::create([
            'fullname' => 'Kursus Mengemudi "HAFIZ"',
            'username' => 'kursus_hafiz',
            'phone_number' => '+62882231991417',
            'password' => bcrypt('kursushafiz'),
            'role' => "admin",
            'description' => 'Kursus Mengemudi HAFIZ dari 2018',
            'hash_for_profile_picture' => '1732614956.png',
            'open_hours_for_admin' => '09:00:00',
            'close_hours_for_admin' => '16:00:00',
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("2"),
        ]);
        User::create([
            'fullname' => 'Cecep',
            'username' => 'instruktur_cecep',
            'phone_number' => '+62880102391855',
            'password' => bcrypt('sayaCecep'),
            'age' => 38,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Pulung',
            'hash_for_profile_picture' => '1732615648.png',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 3
        ]);
        User::create([
            'fullname' => 'Adi',
            'username' => 'instruktur_adi',
            'phone_number' => '+628119920063',
            'password' => bcrypt('sayaAdi'),
            'age' => 54,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Pulung',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 3
        ]);
        User::create([
            'fullname' => 'Agus Wahyudi',
            'username' => 'instruktur_wahyudi',
            'phone_number' => '+6282131636194',
            'password' => bcrypt('sayaWahyudi'),
            'age' => 44,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Sie Bersaudara',
            'hash_for_profile_picture' => '1732617381.jpg',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 10
        ]);
        User::create([
            'fullname' => 'Hari Wahyudi',
            'username' => 'instruktur_hari',
            'phone_number' => '+628182831004',
            'password' => bcrypt('sayaHari'),
            'age' => 50,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi Sie Bersaudara',
            'hash_for_profile_picture' => '1732612560912.webp',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 10
        ]);
        User::create([
            'fullname' => 'Hafiz Hidayat',
            'username' => 'instruktur_hafiz',
            'phone_number' => '+6282132318056',
            'password' => bcrypt('sayaWahyudi'),
            'age' => 39,
            'role' => "instructor",
            'description' => 'Saya adalah Instruktur untuk Kursus Mengemudi HAFIZ',
            'hash_for_profile_picture' => '1732614805.png',
            'availability' => 1,
            'fp_question' => 'Satu ditambah satu sama dengan?',
            'fp_answer' => Crypt::encryptString("Dua"),
            'admin_id' => 11
        ]);
        User::create([
            'fullname' => 'Diki',
            'username' => 'ini_Diki',
            'phone_number' => '+62876383182318',
            'password' => bcrypt('sayaDiki'),
            'age' => 33,
            'role' => 'user',
            'description' => 'Saya Diki Siswa Kursus',
            'fp_question' => 'Sebutkan Ibu Kota Negara Russia',
            'fp_answer' => Crypt::encryptString("Moscow"),
        ]);
        User::create([
            'fullname' => 'Umar',
            'username' => 'ini_Umar',
            'phone_number' => '+6288238138568',
            'password' => bcrypt('sayaUmar'),
            'age' => 33,
            'role' => 'user',
            'description' => 'Siswa Kursus',
            'fp_question' => 'Sebutkan Ibu Kota Negara Mexico',
            'fp_answer' => Crypt::encryptString("Mexico City"),
        ]);
        User::create([
            'fullname' => 'Rian',
            'username' => 'ini_Rian',
            'phone_number' => '+628238138568',
            'password' => bcrypt('sayaRian'),
            'age' => 33,
            'role' => 'user',
            'description' => 'Pekerja Swasta',
            'fp_question' => 'Sebutkan Nama Presiden Ke-4 Indonesia',
            'fp_answer' => Crypt::encryptString("Gus Dur"),
        ]);
        User::create([
            'fullname' => 'Test',
            'username' => 'test',
            'phone_number' => '+6282381123568',
            'password' => bcrypt('password'),
            'age' => 33,
            'role' => 'user',
            'description' => 'Pekerja Swasta',
            'fp_question' => 'Sebutkan Nama Presiden Ke-4 Indonesia',
            'fp_answer' => Crypt::encryptString("Gus Dur"),
        ]);

        drivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2021-12-21',
            'endLicenseDate' => '2024-12-21',
            'licenseStatus' => 'Sudah Tervalidasi',
            'admin_id' => 2,
        ]);
        drivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2018-12-21',
            'endLicenseDate' => '2021-12-21',
            'licenseStatus' => 'Aktif',
            'admin_id' => 2,
        ]);
        drivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2023-10-21',
            'endLicenseDate' => '2025-10-21',
            'licenseStatus' => 'Aktif',
            'admin_id' => 3,
        ]);
        drivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2023-08-03',
            'endLicenseDate' => '2025-08-03',
            'licenseStatus' => 'Aktif',
            'admin_id' => 10,
        ]);
        drivingSchoolLicense::create([
            'licensePath' => '1723210503.webp',
            'startLicenseDate' => '2023-01-13',
            'endLicenseDate' => '2025-01-13',
            'licenseStatus' => 'Aktif',
            'admin_id' => 11,
        ]);

        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Sudah Divalidasi',
            'instructor_id' => 4,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2019-12-19',
            'endCertificateDate' => '2024-12-19',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 5,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2020-08-01',
            'endCertificateDate' => '2025-08-01',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 6,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2022-04-01',
            'endCertificateDate' => '2027-04-01',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 12,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2022-04-22',
            'endCertificateDate' => '2027-04-22',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 13,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2022-06-19',
            'endCertificateDate' => '2027-06-19',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 14,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2023-02-14',
            'endCertificateDate' => '2028-02-14',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 15,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2019-02-28',
            'endCertificateDate' => '2024-02-28',
            'certificateStatus' => 'Tidak Berlaku',
            'instructor_id' => 16,
        ]);
        instructorCertificate::create([
            'certificatePath' => '1722614055.jpg',
            'startCertificateDate' => '2024-02-28',
            'endCertificateDate' => '2029-02-28',
            'certificateStatus' => 'Aktif',
            'instructor_id' => 16,
        ]);

        course::create([
            'course_thumbnail' => '1732615008.png',
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
        course::create([
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
        course::create([
            'course_thumbnail' => '1732615098.png',
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
        course::create([
            'course_thumbnail' => '1732615212.png',
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

        course::create([
            'course_thumbnail' => '1732615219.png',
            'course_name' => 'Belajar Mengemudi Mobil Manual',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 1200000,
            'course_length' => 6,
            'course_duration' => 90,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 3,
        ]);
        course::create([
            'course_thumbnail' => '1732615241.png',
            'course_name' => 'Belajar Mengemudi Mobil Matic',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 8,
            'course_price' => 1400000,
            'course_length' => 6,
            'course_duration' => 90,
            'car_type' => "Automatic",
            'can_use_own_car' => false,
            'admin_id' => 3,
        ]);
        course::create([
            'course_thumbnail' => '1732615283.png',
            'course_name' => 'Kursus Mengemudi Murah di Surabaya',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 8,
            'course_price' => 900000,
            'course_length' => 5,
            'course_duration' => 90,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 3,
        ]);
        course::create([
            'course_thumbnail' => '1732615303.png',
            'course_name' => 'Kursus Mengemudi Mobil Surabaya',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 11,
            'course_price' => 1000000,
            'course_length' => 7,
            'course_duration' => 60,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 3,
        ]);
        course::create([
            'course_thumbnail' => '1732615320.png',
            'course_name' => 'Kursus Mengemudi Mobil Mandiri',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat dengan mobil anda sendiri, kursus ini tepat untuk anda.',
            'course_quota' => 5,
            'course_price' => 1700000,
            'course_length' => 6,
            'course_duration' => 90,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 3,
        ]);

        course::create([
            'course_thumbnail' => '1732615404.png',
            'course_name' => 'Kursus Mobil Manual untuk Pemula',
            'course_description' => 'Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda. Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 770000,
            'course_length' => 5,
            'course_duration' => 90,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 10,
        ]);
        course::create([
            'course_thumbnail' => '1732615432.png',
            'course_name' => 'Kursus Mobil Matic untuk Pemula',
            'course_description' => 'Untuk anda yang baru belajar mengemudi dengan mobil matic, kursus ini tepat untuk anda.',
            'course_quota' => 5,
            'course_price' => 900000,
            'course_length' => 5,
            'course_duration' => 90,
            'car_type' => "Automatic",
            'can_use_own_car' => false,
            'course_availability' => 0,
            'admin_id' => 10,
        ]);
        course::create([
            'course_thumbnail' => '1732615455.png',
            'course_name' => 'Kursus Kilat Mobil Manual',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat, kursus ini tepat untuk anda.',
            'course_quota' => 3,
            'course_price' => 650000,
            'course_length' => 3,
            'course_duration' => 90,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 10,
        ]);

        course::create([
            'course_thumbnail' => '1732615432.png',
            'course_name' => 'Kursus Mobil Paket A',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat, kursus ini tepat untuk anda.',
            'course_quota' => 4,
            'course_price' => 650000,
            'course_length' => 4,
            'course_duration' => 60,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 11,
        ]);
        course::create([
            'course_thumbnail' => '1732615419.png',
            'course_name' => 'Kursus Mobil Paket B',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan lancar & cepat, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 1150000,
            'course_length' => 5,
            'course_duration' => 120,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 11,
        ]);
        course::create([
            'course_thumbnail' => '1732615076.png',
            'course_name' => 'Kursus Mobil Paket C',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan lancar, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 950000,
            'course_length' => 6,
            'course_duration' => 90,
            'car_type' => "Both",
            'can_use_own_car' => false,
            'admin_id' => 11,
        ]);

        enrollment::create([
            'course_id' => 1,
            'instructor_id' => 5,
            'student_id' => 7,
            'student_real_name' => 'Abdul',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Madiun',
            'student_birth_of_date' => '1997-08-30',
            'student_occupation' => 'Karyawan Swasta',
            'student_phone_number' => '+6281403203103',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'Magister',
        ]);
        enrollment::create([
            'course_id' => 2,
            'instructor_id' => 6,
            'student_id' => 8,
            'student_real_name' => 'Anita Ani',
            'student_gender' => 'Wanita',
            'student_birth_of_place' => 'Trenggalek',
            'student_birth_of_date' => '1989-01-14',
            'student_occupation' => 'Wiraswasta',
            'student_phone_number' => '+6281403283713',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'SMA/SMK Sederajat',
        ]);
        enrollment::create([
            'course_id' => 4,
            'instructor_id' => 5,
            'student_id' => 9,
            'student_real_name' => 'Arya Hendra',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Gresik',
            'student_birth_of_date' => '1999-04-14',
            'student_occupation' => 'Wiraswasta',
            'student_phone_number' => '+6281403232713',
            'student_address' => 'Citra Land Surabaya',
            'student_education_level' => 'S1/D4',
        ]);
        enrollment::create([
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

        enrollment::create([
            'course_id' => 7,
            'instructor_id' => 13,
            'student_id' => 9,
            'student_real_name' => 'Erik',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Lombok',
            'student_birth_of_date' => '1988-12-01',
            'student_occupation' => 'Karyawan Swasta',
            'student_phone_number' => '+6212838123104',
            'student_address' => 'Surabaya',
            'student_education_level' => 'SMA/SMK Sederajat',
        ]);
        enrollment::create([
            'course_id' => 7,
            'instructor_id' => 13,
            'student_id' => 17,
            'student_real_name' => 'Erina',
            'student_gender' => 'Wanita',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '1995-02-03',
            'student_occupation' => 'Karyawan Swasta',
            'student_phone_number' => '+628120923164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'SMA/SMK Sederajat',
        ]);

        enrollment::create([
            'course_id' => 13,
            'instructor_id' => 16,
            'student_id' => 18,
            'student_real_name' => 'Hana',
            'student_gender' => 'Wanita',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '2002-03-05',
            'student_occupation' => 'Mahasiswa',
            'student_phone_number' => '+6283182310164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'S1/D4',
        ]);
        enrollment::create([
            'course_id' => 15,
            'instructor_id' => 16,
            'student_id' => 19,
            'student_real_name' => 'Rian',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '2000-10-29',
            'student_occupation' => 'Mahasiswa',
            'student_phone_number' => '+628391230164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'S1/D4',
        ]);

        enrollment::create([
            'course_id' => 3,
            'instructor_id' => 4,
            'student_id' => 19,
            'student_real_name' => 'Rian',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '2000-10-29',
            'student_occupation' => 'Mahasiswa',
            'student_phone_number' => '+628391230164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'S1/D4',
        ]);
        enrollment::create([
            'course_id' => 3,
            'instructor_id' => 4,
            'student_id' => 17,
            'student_real_name' => 'Diki',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '2001-06-22',
            'student_occupation' => 'Mahasiswa',
            'student_phone_number' => '+628391230164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'S1/D4',
        ]);
        enrollment::create([
            'course_id' => 4,
            'instructor_id' => 5,
            'student_id' => 18,
            'student_real_name' => 'Umar',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Bangkalan',
            'student_birth_of_date' => '1988-06-03',
            'student_occupation' => 'Pekerja Swasta',
            'student_phone_number' => '+628391230164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'SMA Sederajat',
        ]);
        enrollment::create([
            'course_id' => 13,
            'instructor_id' => 16,
            'student_id' => 20,
            'student_real_name' => 'Budiono Siregar',
            'student_gender' => 'Pria',
            'student_birth_of_place' => 'Surabaya',
            'student_birth_of_date' => '2000-06-03',
            'student_occupation' => 'Pekerja Swasta',
            'student_phone_number' => '+6283978930164',
            'student_address' => 'Surabaya',
            'student_education_level' => 'SMA Sederajat',
        ]);

        courseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 4,
        ]);
        courseInstructor::create([
            'course_id' => 1,
            'instructor_id' => 5,
        ]);
        courseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 4,
        ]);
        courseInstructor::create([
            'course_id' => 2,
            'instructor_id' => 6,
        ]);
        courseInstructor::create([
            'course_id' => 3,
            'instructor_id' => 5,
        ]);
        courseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 4,
        ]);
        courseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 5,
        ]);
        courseInstructor::create([
            'course_id' => 4,
            'instructor_id' => 6,
        ]);
        courseInstructor::create([
            'course_id' => 5,
            'instructor_id' => 12,
        ]);
        courseInstructor::create([
            'course_id' => 5,
            'instructor_id' => 13,
        ]);
        courseInstructor::create([
            'course_id' => 6,
            'instructor_id' => 12,
        ]);
        courseInstructor::create([
            'course_id' => 6,
            'instructor_id' => 13,
        ]);
        courseInstructor::create([
            'course_id' => 7,
            'instructor_id' => 12,
        ]);
        courseInstructor::create([
            'course_id' => 7,
            'instructor_id' => 13,
        ]);
        courseInstructor::create([
            'course_id' => 8,
            'instructor_id' => 12,
        ]);
        courseInstructor::create([
            'course_id' => 9,
            'instructor_id' => 13,
        ]);
        courseInstructor::create([
            'course_id' => 10,
            'instructor_id' => 14,
        ]);
        courseInstructor::create([
            'course_id' => 11,
            'instructor_id' => 15,
        ]);
        courseInstructor::create([
            'course_id' => 12,
            'instructor_id' => 14,
        ]);
        courseInstructor::create([
            'course_id' => 12,
            'instructor_id' => 15,
        ]);
        courseInstructor::create([
            'course_id' => 13,
            'instructor_id' => 16,
        ]);
        courseInstructor::create([
            'course_id' => 14,
            'instructor_id' => 16,
        ]);
        courseInstructor::create([
            'course_id' => 15,
            'instructor_id' => 16,
        ]);

        // Pertemuan 1, enrollment 1
        courseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-11-28 08:00:00',
            'end_time' => '2024-11-28 09:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 1
        courseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-12-05 08:00:00',
            'end_time' => '2024-12-05 09:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 1
        courseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-12-12 08:00:00',
            'end_time' => '2024-12-12 09:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 1
        courseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-12-19 08:00:00',
            'end_time' => '2024-12-19 09:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 1
        courseSchedule::create([
            'enrollment_id' => 1,
            'course_id' => 1,
            'instructor_id' => 5,
            'start_time' => '2024-12-26 08:00:00',
            'end_time' => '2024-12-26 09:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 2
        courseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 6,
            'start_time' => '2024-11-24 15:30:00',
            'end_time' => '2024-11-24 17:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 2
        courseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 6,
            'start_time' => '2024-12-01 15:30:00',
            'end_time' => '2024-12-01 17:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 3, enrollment 2
        courseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 6,
            'start_time' => '2024-12-08 15:30:00',
            'end_time' => '2024-12-08 17:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 4, enrollment 2
        courseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 6,
            'start_time' => '2024-12-15 15:30:00',
            'end_time' => '2024-12-15 17:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 5, enrollment 2
        courseSchedule::create([
            'enrollment_id' => 2,
            'course_id' => 2,
            'instructor_id' => 6,
            'start_time' => '2024-12-22 15:30:00',
            'end_time' => '2024-12-22 17:00:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 3
        courseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-11-29 14:00:00',
            'end_time' => '2024-11-29 15:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 3
        courseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-12-06 14:00:00',
            'end_time' => '2024-12-06 15:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 3, enrollment 3
        courseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-12-13 14:00:00',
            'end_time' => '2024-12-13 15:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 4, enrollment 3
        courseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-12-20 14:00:00',
            'end_time' => '2024-12-20 15:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 1,
        ]);
        // Pertemuan 5, enrollment 3
        courseSchedule::create([
            'enrollment_id' => 3,
            'course_id' => 4,
            'instructor_id' => 5,
            'start_time' => '2024-12-27 14:00:00',
            'end_time' => '2024-12-27 15:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 4
        courseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-11-20 08:00:00',
            'end_time' => '2024-11-20 09:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 4
        courseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-11-27 08:00:00',
            'end_time' => '2024-11-27 09:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 4
        courseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-12-04 08:00:00',
            'end_time' => '2024-12-04 09:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 4
        courseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-12-11 08:00:00',
            'end_time' => '2024-12-11 09:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 4
        courseSchedule::create([
            'enrollment_id' => 4,
            'course_id' => 1,
            'instructor_id' => 4,
            'start_time' => '2024-12-18 08:00:00',
            'end_time' => '2024-12-18 09:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 5
        courseSchedule::create([
            'enrollment_id' => 5,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-11-20 08:00:00',
            'end_time' => '2024-11-20 09:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 5
        courseSchedule::create([
            'enrollment_id' => 5,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-11-27 08:00:00',
            'end_time' => '2024-11-27 09:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 5
        courseSchedule::create([
            'enrollment_id' => 5,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-04 08:00:00',
            'end_time' => '2024-12-04 09:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 5
        courseSchedule::create([
            'enrollment_id' => 5,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-11 08:00:00',
            'end_time' => '2024-12-11 09:30:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 5
        courseSchedule::create([
            'enrollment_id' => 5,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-18 08:00:00',
            'end_time' => '2024-12-18 09:30:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 6
        courseSchedule::create([
            'enrollment_id' => 6,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-11-20 14:30:00',
            'end_time' => '2024-11-20 16:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 6
        courseSchedule::create([
            'enrollment_id' => 6,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-11-27 14:30:00',
            'end_time' => '2024-11-27 16:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 6
        courseSchedule::create([
            'enrollment_id' => 6,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-04 14:30:00',
            'end_time' => '2024-12-04 16:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 6
        courseSchedule::create([
            'enrollment_id' => 6,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-11 14:30:00',
            'end_time' => '2024-12-11 16:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 6
        courseSchedule::create([
            'enrollment_id' => 6,
            'course_id' => 7,
            'instructor_id' => 13,
            'start_time' => '2024-12-18 14:30:00',
            'end_time' => '2024-12-18 16:00:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 7
        courseSchedule::create([
            'enrollment_id' => 7,
            'course_id' => 13,
            'instructor_id' => 16,
            'start_time' => '2024-11-27 16:00:00',
            'end_time' => '2024-11-27 17:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 7
        courseSchedule::create([
            'enrollment_id' => 7,
            'course_id' => 13,
            'instructor_id' => 16,
            'start_time' => '2024-12-04 16:00:00',
            'end_time' => '2024-12-04 17:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 7
        courseSchedule::create([
            'enrollment_id' => 7,
            'course_id' => 13,
            'instructor_id' => 16,
            'start_time' => '2024-12-11 16:00:00',
            'end_time' => '2024-12-11 17:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 7
        courseSchedule::create([
            'enrollment_id' => 7,
            'course_id' => 13,
            'instructor_id' => 16,
            'start_time' => '2024-12-18 16:00:00',
            'end_time' => '2024-12-18 17:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2024-12-02 14:30:00',
            'end_time' => '2024-12-02 16:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2024-12-09 14:30:00',
            'end_time' => '2024-12-09 16:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2024-12-16 14:30:00',
            'end_time' => '2024-12-16 16:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2024-12-23 14:30:00',
            'end_time' => '2024-12-23 16:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2024-12-30 14:30:00',
            'end_time' => '2024-12-30 16:00:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 6, enrollment 8
        courseSchedule::create([
            'enrollment_id' => 8,
            'course_id' => 15,
            'instructor_id' => 16,
            'start_time' => '2025-01-06 14:30:00',
            'end_time' => '2025-01-06 16:00:00',
            'meeting_number' => 6,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 9
        courseSchedule::create([
            'enrollment_id' => 9,
            'course_id' => 3,
            'instructor_id' => 5,
            'start_time' => '2024-11-30 10:00:00',
            'end_time' => '2024-11-30 11:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 9
        courseSchedule::create([
            'enrollment_id' => 9,
            'course_id' => 3,
            'instructor_id' => 5,
            'start_time' => '2024-12-07 10:00:00',
            'end_time' => '2024-12-07 11:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 9
        courseSchedule::create([
            'enrollment_id' => 9,
            'course_id' => 3,
            'instructor_id' => 5,
            'start_time' => '2024-12-14 10:00:00',
            'end_time' => '2024-12-14 11:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 10
        courseSchedule::create([
            'enrollment_id' => 10,
            'course_id' => 3,
            'instructor_id' => 6,
            'start_time' => '2024-11-30 10:00:00',
            'end_time' => '2024-11-30 11:30:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 10
        courseSchedule::create([
            'enrollment_id' => 10,
            'course_id' => 3,
            'instructor_id' => 6,
            'start_time' => '2024-12-07 10:00:00',
            'end_time' => '2024-12-07 11:30:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 10
        courseSchedule::create([
            'enrollment_id' => 10,
            'course_id' => 3,
            'instructor_id' => 6,
            'start_time' => '2024-12-14 10:00:00',
            'end_time' => '2024-12-14 11:30:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Pertemuan 1, enrollment 11
        courseSchedule::create([
            'enrollment_id' => 11,
            'course_id' => 4,
            'instructor_id' => 6,
            'start_time' => '2024-11-27 14:00:00',
            'end_time' => '2024-11-27 16:00:00',
            'meeting_number' => 1,
            'theoryStatus' => 1,
            'quizStatus' => 1,
        ]);
        // Pertemuan 2, enrollment 11
        courseSchedule::create([
            'enrollment_id' => 11,
            'course_id' => 4,
            'instructor_id' => 6,
            'start_time' => '2024-12-04 14:00:00',
            'end_time' => '2024-12-04 16:00:00',
            'meeting_number' => 2,
            'theoryStatus' => 1,
            'quizStatus' => 0,
        ]);
        // Pertemuan 3, enrollment 11
        courseSchedule::create([
            'enrollment_id' => 11,
            'course_id' => 4,
            'instructor_id' => 6,
            'start_time' => '2024-12-11 14:00:00',
            'end_time' => '2024-12-11 16:00:00',
            'meeting_number' => 3,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 4, enrollment 11
        courseSchedule::create([
            'enrollment_id' => 11,
            'course_id' => 4,
            'instructor_id' => 6,
            'start_time' => '2024-12-18 14:00:00',
            'end_time' => '2024-12-18 16:00:00',
            'meeting_number' => 4,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);
        // Pertemuan 5, enrollment 11
        courseSchedule::create([
            'enrollment_id' => 11,
            'course_id' => 4,
            'instructor_id' => 6,
            'start_time' => '2024-12-25 14:00:00',
            'end_time' => '2024-12-25 16:00:00',
            'meeting_number' => 5,
            'theoryStatus' => 0,
            'quizStatus' => 0,
        ]);

        // Bukti Pembayaran untuk Siswa 1
        coursePayment::create([
            'enrollment_id' => 1,
            'paymentFile' => '1723140944.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 2
        coursePayment::create([
            'enrollment_id' => 2,
            'paymentFile' => '1722842843.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 3
        coursePayment::create([
            'enrollment_id' => 3,
            'paymentFile' => '1723140944.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 4
        coursePayment::create([
            'enrollment_id' => 4,
            'paymentFile' => '1722842843.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 5
        coursePayment::create([
            'enrollment_id' => 5,
            'paymentFile' => '1723140944.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 6
        coursePayment::create([
            'enrollment_id' => 6,
            'paymentFile' => '1722842843.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 7
        coursePayment::create([
            'enrollment_id' => 7,
            'paymentFile' => '1723140944.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 8
        coursePayment::create([
            'enrollment_id' => 8,
            'paymentFile' => '1722842843.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 9
        coursePayment::create([
            'enrollment_id' => 9,
            'paymentFile' => '1722842843.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 10
        coursePayment::create([
            'enrollment_id' => 10,
            'paymentFile' => '1723140944.jpg',
        ]);
        // Bukti Pembayaran untuk Siswa 11
        coursePayment::create([
            'enrollment_id' => 11,
            'paymentFile' => '1722842843.jpg',
        ]);

        paymentMethod::create([
            'payment_vendor' => "BCA",
            'payment_receiver_name' => "Agus",
            'payment_address' => Crypt::encryptString("282831039210"),
            'is_payment_active' => 1,
            'admin_id' => 2,
        ]);
        paymentMethod::create([
            'payment_vendor' => "Mandiri",
            'payment_receiver_name' => "Kursus Pulung",
            'payment_address' => Crypt::encryptString("283101263159"),
            'is_payment_active' => 1,
            'admin_id' => 3,
        ]);
        paymentMethod::create([
            'payment_vendor' => "BNI",
            'payment_receiver_name' => "Kursus Pulung",
            'payment_address' => Crypt::encryptString("2371417510"),
            'is_payment_active' => 1,
            'admin_id' => 3,
        ]);
        paymentMethod::create([
            'payment_vendor' => "BCA",
            'payment_receiver_name' => "Suwono",
            'payment_address' => Crypt::encryptString("10480171569"),
            'is_payment_active' => 1,
            'admin_id' => 10,
        ]);
        paymentMethod::create([
            'payment_vendor' => "BCA",
            'payment_receiver_name' => "Hafiz Hidayat",
            'payment_address' => Crypt::encryptString("2831840157"),
            'is_payment_active' => 1,
            'admin_id' => 11,
        ]);
        paymentMethod::create([
            'payment_vendor' => "BRI",
            'payment_receiver_name' => "Hafiz Hidayat",
            'payment_address' => Crypt::encryptString("1203104566"),
            'is_payment_active' => 1,
            'admin_id' => 11,
        ]);
    }
}
