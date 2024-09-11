@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Greetings --}}
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">Daftar Siswa Aktif</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Berikut adalah seluruh siswa yang memiliki kursus aktif dengan anda!</p>

    {{-- If there's no active student, do this --}}
    @if ($activeEnrolledStudent->isEmpty() || $activeEnrolledStudent->every(fn($student) => !$student->next_course_date))
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai siswa aktif)</p>
    
    {{-- If there's active student, do this instead --}}
    @else
        {{-- Class List --}}
        <div class="flex lg:grid flex-col lg:grid-cols-2 gap-6 mt-5 lg:mt-10 mb-7 lg:mb-14">
            {{-- Call every active student --}}
            @foreach ($activeEnrolledStudent->filter(fn($student) => $student->next_course_date) as $activeStudent)
            {{-- To open the course progress for each student --}}
            <a href="{{ url('/admin-course-progress/' . $activeStudent->student_real_name . '/' . $activeStudent['id']) }}" class="w-full bg-custom-white-hover p-3 lg:p-5 rounded-xl overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                <div class="flex flex-col gap-4">
                    {{-- Student Information --}}
                    <div class="flex flex-row gap-3 items-center">
                        {{-- Student Profile Picture --}}
                        @if ($activeStudent->student_profile_picture)
                        <img src="{{ asset('storage/enrollment/profile_pictures/' . $activeStudent->student_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        {{-- Student Blank Profile Picture --}}
                        @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        @endif
    
                        <div class="flex flex-col lg:gap-1">
                            {{-- Student Name --}}
                            <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight lg:text-xl/tight text-custom-dark">{{ $activeStudent->student_real_name }}</h2>
                            {{-- Instructor Name --}}
                            <p class="font-league text-[15px]/tight lg:text-lg/tight text-custom-grey">Instruktur : {{ $activeStudent->instructor->fullname }}</p>
                        </div>
                    </div>

                    {{-- Course Name and Next Course Date and Time --}}
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1">
                            {{-- Course Name --}}
                            <h3 class="font-encode tracking-tight font-semibold text-[21px]/tight lg:text-[25px]/tight text-custom-dark">{{ $activeStudent->course->course_name }}</h3>
                            {{-- Course Meeting Number --}}
                            <p class="font-league text-[17px]/tight lg:text-xl/tight text-custom-grey">Pertemuan ke-{{ $activeStudent->meeting_number }}</p>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-2">
                            {{-- Next Course Date --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                {{-- Small icons --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M22 14v-2c0-.839 0-1.585-.013-2.25H2.013C2 10.415 2 11.161 2 12v2c0 3.771 0 5.657 1.172 6.828C4.343 22 6.229 22 10 22h4c3.771 0 5.657 0 6.828-1.172C22 19.657 22 17.771 22 14M7.75 2.5a.75.75 0 0 0-1.5 0v1.58c-1.44.115-2.384.397-3.078 1.092c-.695.694-.977 1.639-1.093 3.078h19.842c-.116-1.44-.398-2.384-1.093-3.078c-.694-.695-1.639-.977-3.078-1.093V2.5a.75.75 0 0 0-1.5 0v1.513C15.585 4 14.839 4 14 4h-4c-.839 0-1.585 0-2.25.013z"/></svg>
                                <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $activeStudent->next_course_date }}</h4>
                            </div>
                            {{-- Next Course Time --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                {{-- Small icons --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M17 3.34A10 10 0 1 1 2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-1 1v5.026l.009.105l.02.107l.04.129l.048.102l.046.078l.042.06l.069.08l.088.083l.083.062l3 2a1 1 0 1 0 1.11-1.664L13 11.464V7a1 1 0 0 0-.883-.993z"/></svg>
                                <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $activeStudent->course_time }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif

    @include('partials.footer')
@endsection