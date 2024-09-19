@extends('layouts.relative')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col my-8 lg:my-12 px-6 lg:px-[4.25rem]">
        <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight">Selamat Datang di KEMUDI, {{ auth()->user()->fullname }}</p>
        <h1 class="text-custom-dark font-league font-semibold text-xl/tight lg:text-4xl">Ingin belajar mengemudi hari ini?</h1>
    </div>

    @if ($incomingSchedule)
        {{-- Ongoing Course, Hidden if there are no active course --}}
        <div class="flex flex-col mb-8 lg:mb-11 px-6 lg:px-[4.25rem]">
            <h2 class="text-custom-dark font-league font-semibold text-xl/tight lg:text-3xl/tight">Kursus Berlangsung</h2>
            {{-- Mobile Incoming Schedule --}}
            <a href="{{ url('/user-course-progress/' . $incomingSchedule->enrollment->student_real_name . '/' . $incomingSchedule->enrollment['id']) }}" class="w-full bg-custom-white-hover p-3.5 mt-1 lg:hidden rounded-xl overflow-hidden drop-shadow-lg duration-300">
                <div class="flex flex-col gap-4">
                    {{-- Student Information --}}
                    <div class="flex flex-row gap-3 items-center lg:hidden">
                        {{-- Student Profile Picture --}}
                        @if ($incomingSchedule->enrollment->student_profile_picture)
                        <img src="{{ asset('storage/enrollment/profile_pictures/' . $incomingSchedule->enrollment->student_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        {{-- Student Blank Profile Picture --}}
                        @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        @endif

                        <div class="flex flex-col lg:gap-1">
                            {{-- Student Name --}}
                            <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight lg:text-xl/tight text-custom-dark">{{ $incomingSchedule->enrollment->student_real_name }}</h2>
                            {{-- Instructor Name --}}
                            <p class="font-league text-[15px]/tight lg:text-lg/tight text-custom-grey">Instruktur : {{ $incomingSchedule->enrollment->instructor->fullname }}</p>
                        </div>
                    </div>

                    {{-- Course Name and Next Course Date and Time --}}
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1">
                            <h3 class="font-encode tracking-tight font-semibold text-[21px]/tight lg:text-[26px]/tight text-custom-dark">{{ $incomingSchedule->enrollment->course->course_name }}</h3>
                            <p class="font-league text-[17px]/tight lg:text-xl/tight text-custom-grey">Pertemuan ke-{{ $incomingSchedule->meeting_number }}</p>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-2">
                            {{-- Next Course Date --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                {{-- Small icons --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M22 14v-2c0-.839 0-1.585-.013-2.25H2.013C2 10.415 2 11.161 2 12v2c0 3.771 0 5.657 1.172 6.828C4.343 22 6.229 22 10 22h4c3.771 0 5.657 0 6.828-1.172C22 19.657 22 17.771 22 14M7.75 2.5a.75.75 0 0 0-1.5 0v1.58c-1.44.115-2.384.397-3.078 1.092c-.695.694-.977 1.639-1.093 3.078h19.842c-.116-1.44-.398-2.384-1.093-3.078c-.694-.695-1.639-.977-3.078-1.093V2.5a.75.75 0 0 0-1.5 0v1.513C15.585 4 14.839 4 14 4h-4c-.839 0-1.585 0-2.25.013z"/></svg>
                                <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $incomingSchedule->formattedStartDate }}</h4>
                            </div>
                            {{-- Next Course Time --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                {{-- Small icons --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M17 3.34A10 10 0 1 1 2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-1 1v5.026l.009.105l.02.107l.04.129l.048.102l.046.078l.042.06l.069.08l.088.083l.083.062l3 2a1 1 0 1 0 1.11-1.664L13 11.464V7a1 1 0 0 0-.883-.993z"/></svg>
                                <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $incomingSchedule->formattedStartTime }} - {{ $incomingSchedule->formattedEndTime }} WIB</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            {{-- Desktop Incoming Schedule --}}
            <div class="hidden lg:grid lg:grid-cols-5 lg:gap-6 lg:mt-1">
                {{-- Instructor Card --}}
                <a href="{{ url('https://wa.me/' . $incomingSchedule->instructor->phone_number) }}" target="_blank" class="lg:relative lg:flex lg:flex-col lg:justify-center lg:items-center lg:gap-2 bg-custom-white-hover rounded-xl p-6 overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    @if ($incomingSchedule->instructor->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->instructor->hash_for_profile_picture) }}" alt="Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @endif

                    {{-- Student Name --}}
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark text-center line-clamp-1">{{ $incomingSchedule->instructor->fullname }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full lg:hover:bg-custom-white opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-encode font-semibold text-xl/tight text-custom-green">Hubungi Instruktur</p>
                    </div>
                </a>

                {{-- Course Card --}}
                <a href="{{ url('/user-course-progress/' . $incomingSchedule->enrollment->student_real_name . '/' . $incomingSchedule->enrollment['id']) }}" class="col-span-3 w-full bg-custom-white-hover p-3 lg:p-6 rounded-xl overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    <div class="flex flex-col gap-4">
                        {{-- Student Information --}}
                        <div class="flex flex-row gap-3 items-center lg:hidden">
                            {{-- Student Profile Picture --}}
                            @if ($incomingSchedule->enrollment->student_profile_picture)
                            <img src="{{ asset('storage/enrollment/profile_pictures/' . $incomingSchedule->enrollment->student_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                            {{-- Student Blank Profile Picture --}}
                            @else
                            <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                            @endif
    
                            <div class="flex flex-col lg:gap-1">
                                {{-- Student Name --}}
                                <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight lg:text-xl/tight text-custom-dark">{{ $incomingSchedule->enrollment->student_real_name }}</h2>
                                {{-- Instructor Name --}}
                                <p class="font-league text-[15px]/tight lg:text-lg/tight text-custom-grey">Instruktur : {{ $incomingSchedule->enrollment->instructor->fullname }}</p>
                            </div>
                        </div>
    
                        {{-- Course Name and Next Course Date and Time --}}
                        <div class="flex flex-col gap-3">
                            <div class="flex flex-col gap-1">
                                <h3 class="font-encode tracking-tight font-semibold text-[21px]/tight lg:text-[26px]/tight text-custom-dark">{{ $incomingSchedule->enrollment->course->course_name }}</h3>
                                <p class="font-league text-[17px]/tight lg:text-xl/tight text-custom-grey">Pertemuan ke-{{ $incomingSchedule->meeting_number }}</p>
                            </div>
                            <div class="flex flex-col lg:flex-row gap-2">
                                {{-- Next Course Date --}}
                                <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                    {{-- Small icons --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M22 14v-2c0-.839 0-1.585-.013-2.25H2.013C2 10.415 2 11.161 2 12v2c0 3.771 0 5.657 1.172 6.828C4.343 22 6.229 22 10 22h4c3.771 0 5.657 0 6.828-1.172C22 19.657 22 17.771 22 14M7.75 2.5a.75.75 0 0 0-1.5 0v1.58c-1.44.115-2.384.397-3.078 1.092c-.695.694-.977 1.639-1.093 3.078h19.842c-.116-1.44-.398-2.384-1.093-3.078c-.694-.695-1.639-.977-3.078-1.093V2.5a.75.75 0 0 0-1.5 0v1.513C15.585 4 14.839 4 14 4h-4c-.839 0-1.585 0-2.25.013z"/></svg>
                                    <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $incomingSchedule->formattedStartDate }}</h4>
                                </div>
                                {{-- Next Course Time --}}
                                <div class="flex flex-row items-center w-fit gap-2 px-2 lg:px-2.5 py-1 lg:py-1.5 border border-custom-green/50 rounded-lg">
                                    {{-- Small icons --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-mt-0.5" width="22" height="22" viewBox="0 0 24 24"><path fill="#24596A" d="M17 3.34A10 10 0 1 1 2 12l.005-.324A10 10 0 0 1 17 3.34M12 6a1 1 0 0 0-1 1v5.026l.009.105l.02.107l.04.129l.048.102l.046.078l.042.06l.069.08l.088.083l.083.062l3 2a1 1 0 1 0 1.11-1.664L13 11.464V7a1 1 0 0 0-.883-.993z"/></svg>
                                    <h4 class="font-league text-base/tight lg:text-lg/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">{{ $incomingSchedule->formattedStartTime }} - {{ $incomingSchedule->formattedEndTime }} WIB</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- Admin Card --}}
                <a href="{{ url('https://wa.me/' . $incomingSchedule->enrollment->course->admin->phone_number) }}" target="_blank" class="lg:relative lg:flex lg:flex-col lg:justify-center lg:items-center lg:gap-2 bg-custom-white-hover rounded-xl p-6 overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    @if ($incomingSchedule->enrollment->course->admin->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->course->admin->hash_for_profile_picture) }}" alt="Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @endif

                    {{-- Student Name --}}
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark text-center line-clamp-1">{{ $incomingSchedule->enrollment->course->admin->fullname }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full lg:hover:bg-custom-white opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-encode font-semibold text-xl/tight text-custom-green">Hubungi Admin</p>
                    </div>
                </a>
            </div>
        </div>
    @endif

    {{-- Class Offered Recommendation --}}
    <div class="flex flex-row justify-between items-center mb-2 lg:mb-3 px-6 lg:px-[4.25rem]">
        <h2 class="text-custom-dark font-league font-semibold text-xl/tight lg:text-3xl/tight mt-1">Rekomendasi Kelas</h2>
    </div>
    {{-- Class Offered Content --}}
    <div class="relative swiper swiperRecommendation h-fit mb-5 lg:mb-11 px-6 lg:px-[4.25rem] select-none">
        <div class="swiper-wrapper px-6 lg:px-[4.25rem]">
            @foreach ($availableCourses as $courseRecommendation)
                {{-- I've added conditional padding-right since our layout is fucked, this is the only way to make it right --}}
                <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-[8.5rem]' : '' }}" style="width: auto !important;">
                {{-- Check if the course has an uploaded course_thumbnail. If non existed, use a default course_thumbnail --}}
                @if ($courseRecommendation->course_thumbnail)
                    <div class="bg-center bg-cover w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $courseRecommendation['course_thumbnail']) }}');">
                @else
                    <div class="bg-center bg-cover w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                @endif
                        {{-- Redirect to Course Details Page --}}
                        <a href="{{ url('/course/' . $courseRecommendation->course_name . '/' . $courseRecommendation->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                            {{-- Course Information --}}
                            <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $courseRecommendation->course_length }} Pertemuan</p>
                                <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $courseRecommendation->course_name }}</h3>
                                <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $courseRecommendation->admin->fullname }}</p>
                            </div>
                            {{-- Course price Label --}}
                            <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($courseRecommendation->course_price, 0, ',', '.') }},-</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Prev Slide --}}
        <div class="prevRecommendation absolute top-1/2 left-0 -mt-6 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer -translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
        </div>
        {{-- Next Slide --}}
        <div class="nextRecommendation absolute top-1/2 right-0 -mt-6 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
        </div>
    </div>

    {{-- Course Recommendation --}}
    <div class="flex flex-row justify-between items-center mt-8 mb-2 px-6 lg:px-[4.25rem]">
        <h2 class="text-custom-dark font-league font-semibold text-xl/tight lg:text-3xl/tight mt-1">Kursus Populer</h2>
    </div>
    {{-- Course Recommendation Wrapper --}}
    <div class="relative swiper swiperSchool h-fit mb-5 lg:mb-11 select-none">
        <div class="swiper-wrapper px-6 lg:px-[4.25rem]">
            {{-- Course Recommendation Card --}}
            @foreach ($randomDrivingSchool as $drivingSchoolRecommendation)
                {{-- I've added conditional padding-right since our layout is fucked, this is the only way to make it right --}}
                <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-[8.5rem]' : '' }}" style="width: auto !important;">
                    <div class="flex flex-col gap-3 bg-custom-white-hover border border-custom-disabled-light p-4 rounded-xl items-center">
                    {{-- Check if the drivingSchool has an uploaded profile picture. If non existed, use blank-profile --}}
                    @if ($drivingSchoolRecommendation['hash_for_profile_picture'])
                        <div class="border border-custom-disabled-dark bg-cover bg-center w-14 lg:w-20 h-14 lg:h-20 rounded-full" style="background-image: url('{{ asset('storage/profile_pictures/' . $drivingSchoolRecommendation['hash_for_profile_picture']) }}')"></div>                        
                    @else
                        <div class="border border-custom-disabled-dark bg-cover bg-center w-14 lg:w-20 h-14 lg:h-20 rounded-full" style="background-image: url('{{ asset('img/blank-profile.webp') }}')"></div>
                    @endif
                        {{-- Driving School Information --}}
                        <div class="flex flex-col items-center w-60 lg:w-[20.5rem] h-16 lg:h-fit overflow-hidden mb-1 px-3">
                            <p class="font-encode font-semibold text-xl/snug text-center line-clamp-2 lg:line-clamp-1">{{ $drivingSchoolRecommendation['fullname'] }}</p>
                        </div>
                        {{-- Redirect to Driving School Course Page --}}
                        <a href="{{ url('/course/' . $drivingSchoolRecommendation['username']) }}" class="w-full font-league lg:text-lg/none text-custom-secondary px-3 py-2 border border-custom-secondary text-center rounded-lg hover:bg-custom-grey/20 duration-300">
                            <div class="flex flex-row justify-center items-center gap-2">
                                <p class="mt-[2px] lg:mt-[1.5px] lg:text-lg">Lihat Kursus</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="none" stroke="#495D64" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5l6 7l-6 7"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Prev Slide --}}
        <div class="absolute top-1/2 left-0 -mt-8 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer -translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="prevSchool">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
        </div>
        {{-- Next Slide --}}
        <div class="absolute top-1/2 right-0 -mt-8 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="nextSchool">
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
        </div>
    </div>

    {{-- Recommend to do a Search --}}
    <div class="flex my-8 lg:justify-center px-6 lg:px-[4.25rem]">
        <div class="flex flex-col gap-4 bg-custom-grey/10 border border-custom-disabled-light p-4 lg:p-9 lg:w-[33rem] rounded-xl items-center">
            <div class="flex flex-col gap-1">
                <h2 class="text-custom-dark font-league font-semibold text-center text-xl/tight lg:text-3xl/tight">Tidak Menemukan yang Anda Cari?</h2>
                <p class="text-custom-grey font-league font-medium text-center text-base/snug lg:text-xl px-3">Coba cari Nama Kursus atau mobil tipe apa yang ingin anda kuasai?</p>
            </div>
            {{-- Redirect to Search Page --}}
            <a href="#" class="relative font-league lg:text-lg/none text-custom-secondary lg:-mb-1 px-8 lg:px-14 py-2.5 border border-custom-secondary text-center rounded-full hover:bg-custom-grey/20 duration-300">
                <div class="flex flex-row justify-center items-center gap-3 lg:gap-4 py-1 lg:py-0 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="#495D64" stroke-width="2"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
                    <p class="mt-[4px] lg:mt-[1.5px] text-base/[0] lg:text-lg/snug">Coba Fitur Pencarian</p>
                </div>
            </a>
        </div>
    </div>

    {{-- Footers --}}
    <div class="px-6 lg:px-[4.25rem]">
        @include('partials.footer')
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Initialize Course Class Recommendation Swiper
        const swiperRecommendation = new Swiper('.swiperRecommendation', {
            slidesPerView: "auto",
            spaceBetween: window.innerWidth >= 1024 ? 20 : 15,

            // No Navigation Button
            navigation: {
                prevEl: '.prevRecommendation',
                nextEl: '.nextRecommendation',
            },
        });

        // Initialize Driving School Recommendation Swiper
        const swiperSchool = new Swiper('.swiperSchool', {
            slidesPerView: "auto",
            spaceBetween: window.innerWidth >= 1024 ? 20 : 15,

            // No Navigation Button
            navigation: {
                prevEl: '.prevSchool',
                nextEl: '.nextSchool',
            },
        });

        // Show navigation buttons on hover for Course Class Recommendation
        $('.swiperRecommendation').hover(function() {
            $('.nextRecommendation, .prevRecommendation').removeClass('hidden');
            $('.nextRecommendation, .prevRecommendation').addClass('flex');
        }, function() {
            $('.nextRecommendation, .prevRecommendation').removeClass('flex');
            $('.nextRecommendation, .prevRecommendation').addClass('hidden');
        });

        // Show navigation buttons on hover for Driving School Recommendation
        $('.swiperSchool').hover(function() {
            $('#nextSchool, #prevSchool').removeClass('hidden');
            $('#nextSchool, #prevSchool').addClass('flex');
        }, function() {
            $('#nextSchool, #prevSchool').removeClass('flex');
            $('#nextSchool, #prevSchool').addClass('hidden');
        });
    </script>
@endsection