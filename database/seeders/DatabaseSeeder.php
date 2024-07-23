<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

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
        Course::create([
            'course_name' => 'Kursus Mobil Manual untuk Pemula',
            'course_description' => 'Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda. Untuk anda yang baru belajar mengemudi dengan mobil manual, kursus ini tepat untuk anda.',
            'course_quota' => 10,
            'course_price' => 770000,
            'course_length' => 5,
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
            'car_type' => "Automatic",
            'can_use_own_car' => false,
            'admin_id' => 1,
        ]);
        Course::create([
            'course_name' => 'Kursus Kilat Mobil Manual',
            'course_description' => 'Untuk anda yang ingin bisa mengemudi dengan cepat, kursus ini tepat untuk anda.',
            'course_quota' => 3,
            'course_price' => 650000,
            'course_length' => 3,
            'car_type' => "Manual",
            'can_use_own_car' => false,
            'admin_id' => 1,
        ]);
        Enrollment::create([
            'course_id' => 3,
            'instructor_id' => 1,
            'student_id' => 2,
        ]);
        Enrollment::create([
            'course_id' => 1,
            'instructor_id' => 1,
            'student_id' => 2,
        ]);
    }
}
