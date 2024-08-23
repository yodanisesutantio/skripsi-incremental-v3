@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Ajukan Jadwal Kursus Baru</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ubah jadwal <span class="font-semibold">{{ $enrollment->course->course_name }}</span> untuk siswa <span class="font-semibold">{{ $enrollment->student_real_name }}</span></p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Ajukan Jadwal Kursus Baru</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ubah jadwal <span class="font-semibold">{{ $enrollment->course->course_name }}</span> untuk siswa <span class="font-semibold">{{ $enrollment->student_real_name }}</span></p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:mt-7 lg:px-24"></div>
    </div>
@endsection