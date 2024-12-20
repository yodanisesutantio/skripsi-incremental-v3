@extends('layouts.relative')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col mt-5 mb-8 lg:mb-11 px-6 lg:px-[4.25rem]">
        {{-- When Admin doesn't have any instructor or courses --}}
        @if (auth()->user()->instructors()->count() == 0 && auth()->user()->courses()->count() == 0)
            <div class="flex flex-col gap-3 mb-5">
                <div class="p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                    <div class="flex flex-row justify-between font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                        <p>Anda belum mempunyai Instruktur Kursus!</p>
                        <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-manage-instructor/create') }}">Tambah Instruktur</a>
                    </div>
                </div>
    
                <div class="p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                    <div class="flex flex-row justify-between font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                        <p>Anda belum mempunyai Kelas Kursus yang ditawarkan</p>
                        <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-manage-course/create') }}">Tambah Kelas</a>
                    </div>
                </div>
            </div>
        {{-- When Admin doesn't have any courses --}}
        @elseif (auth()->user()->courses()->count() == 0)
            <div class="mb-4 p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                <div class="flex flex-row justify-between items-center gap-4 font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                    <p>Anda belum mempunyai Kelas Kursus yang ditawarkan</p>
                    <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-manage-course/create') }}">Tambah Kelas</a>
                </div>
            </div>
        {{-- When Admin doesn't have any instructor --}}
        @elseif (auth()->user()->courses()->count() == 0)
            <div class="mb-4 p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                <div class="flex flex-row justify-between items-center gap-4 font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                    <p>Anda belum mempunyai Instruktur Kursus!</p>
                    <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-manage-instructor/create') }}">Tambah Instruktur</a>
                </div>
            </div>
        {{-- When Admin doesn't have Active Driving School Licenses --}}
        @elseif (!auth()->user()->drivingSchoolLicense()->where('licenseStatus', 'Aktif')->exists())
            <div class="mb-4 p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                <div class="flex flex-row justify-between items-center gap-4 font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                    <p>Anda tidak memiliki izin kursus aktif. Segera unggah izin kursus baru!</p>
                    <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-driving-school-license') }}">Kelola Izin</a>
                </div>
            </div>
        @endif

        {{-- Warning for expiring driving school license --}}
        @php
            $endLicenseDate = auth()->user()->drivingSchoolLicense()->where('licenseStatus', 'Aktif')->first()->endLicenseDate;
            $daysUntilExpiration = now()->diffInDays($endLicenseDate);

            $hasTriedToExtend = auth()->user()->drivingSchoolLicense()->where('licenseStatus', 'Sudah Tervalidasi')->exists();
        @endphp
        @if ($daysUntilExpiration < 90 && !$hasTriedToExtend)
            <div class="mb-4 p-3 lg:p-5 bg-custom-warning/15 w-full rounded-lg lg:rounded-xl">
                <div class="flex flex-row justify-between items-center gap-4 font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                    <p>Masa berlaku izin kursus anda kurang {{ $daysUntilExpiration }} hari lagi</p>
                    <a class="underline lg:hover:no-underline text-right" href="{{ url('/admin-driving-school-license') }}">Kelola Izin</a>
                </div>
            </div>
        @endif
        
        <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight">Hi, {{ auth()->user()->fullname }}</p>
        @if ($incomingSchedule)
            <h1 class="mb-3 lg:mb-5 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Kursus Mendatang</h1>
        @else
            <h1 class="mb-3 lg:mb-5 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Belum ada Kursus Mendatang</h1>
        @endif

        {{-- Incoming Course Card --}}
        @if ($incomingSchedule)
            {{-- Mobile Incoming Schedule --}}
            <a href="{{ url('/admin-course-progress/' . $incomingSchedule->enrollment->student_real_name . '/' . $incomingSchedule->enrollment['id']) }}" class="w-full bg-custom-white-hover p-3.5 lg:hidden rounded-xl overflow-hidden drop-shadow-lg duration-300">
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
            <div class="hidden lg:grid lg:grid-cols-5 lg:gap-6">
                {{-- Student Card --}}
                <a href="{{ url('https://wa.me/' . $incomingSchedule->enrollment->student_phone_number) }}" target="_blank" class="lg:relative lg:flex lg:flex-col lg:justify-center lg:items-center lg:gap-2 bg-custom-white-hover rounded-xl p-6 overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    @if ($incomingSchedule->enrollment->student->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->student->hash_for_profile_picture) }}" alt="Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @endif

                    {{-- Student Name --}}
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark text-center line-clamp-1">{{ $incomingSchedule->enrollment->student_real_name }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full lg:hover:bg-custom-white opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-encode font-semibold text-xl/tight text-custom-green">Hubungi Siswa</p>
                    </div>
                </a>

                {{-- Course Card --}}
                <a href="{{ url('/admin-course-progress/' . $incomingSchedule->enrollment->student_real_name . '/' . $incomingSchedule->enrollment['id']) }}" class="col-span-3 w-full bg-custom-white-hover p-3 lg:p-6 rounded-xl overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
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

                {{-- Instructor Card --}}
                <a href="{{ url('https://wa.me/' . $incomingSchedule->enrollment->instructor->phone_number) }}" target="_blank" class="lg:relative lg:flex lg:flex-col lg:justify-center lg:items-center lg:gap-2 bg-custom-white-hover rounded-xl p-6 overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    @if ($incomingSchedule->enrollment->instructor->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->instructor->hash_for_profile_picture) }}" alt="Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @endif

                    {{-- Student Name --}}
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark text-center line-clamp-1">{{ $incomingSchedule->enrollment->instructor->fullname }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full lg:hover:bg-custom-white opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-encode font-semibold text-xl/tight text-custom-green">Hubungi Instruktur</p>
                    </div>
                </a>
            </div>

        {{-- No Incoming Course --}}
        @else
            <div class="flex flex-col mb-8 lg:mb-11">
                <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus mendatang)</p>
            </div>
        @endif
    </div>    

    {{-- Schedule Interface --}}
    <div class="flex flex-col">
        <div class="flex flex-row justify-between items-center mb-3 lg:mb-4 px-6 lg:px-[4.25rem]">
            <h2 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-3xl/tight">Jadwal Kursus</h2>

            <div class="lg:flex flex-row gap-2 hidden">
                {{-- Prev Days --}}
                <button type="button" class="prevWeek flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="rotate-180" width="28" height="28" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M0 0h24v24H0z"/><path fill="#040B0D" d="M6 4v16a1 1 0 0 0 1.524.852l13-8a1 1 0 0 0 0-1.704l-13-8A1 1 0 0 0 6 4"/></g></svg>
                </button>

                {{-- Next Days --}}
                <button type="button" class="nextWeek flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M0 0h24v24H0z"/><path fill="#040B0D" d="M6 4v16a1 1 0 0 0 1.524.852l13-8a1 1 0 0 0 0-1.704l-13-8A1 1 0 0 0 6 4"/></g></svg>
                </button>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="swiper swiperTabs w-full py-1" style="scrollbar-width: none;">
            <ul class="swiper-wrapper font-league text-custom-dark text-base/tight font-semibold text-center">
                {{-- Today's Tab --}}
                <li class="swiper-slide pl-6 lg:pl-[4.25rem]" style="width: auto !important;">
                    <button class="flex flex-col grow w-[5.5rem] lg:w-40 justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-white-hover border-2 border-custom-dark rounded-lg duration-300 days-button" id="todays-tab" data-index="0">
                        <div class="flex flex-col lg:hidden">
                            {{-- Days for Mobile --}}
                            <p class="font-normal">{{ \Carbon\Carbon::now()->translatedFormat('D') }}</p>
                            {{-- Date Abbreviation Mobile --}}
                            <h3 class="text-lg/tight line-clamp-1">{{ \Carbon\Carbon::now()->translatedFormat('d M') }}</h3>
                        </div>

                        <div class="lg:flex lg:flex-col hidden">
                            {{-- Days for Desktop --}}
                            <p class="font-normal">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</p>
                            {{-- Date Abbreviation Desktop --}}
                            <h3 class="text-xl/tight line-clamp-1">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</h3>
                        </div>

                        {{-- Horizontal Lines --}}
                        <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                    </button>
                </li>

                {{-- Loop for Next Day Tabs --}}
                @for ($i = 1; $i <= 29; $i++)
                    @if ($i === 29)
                    <li class="swiper-slide pr-6 lg:pr-[4.25rem]" style="width: auto !important;">
                    @else
                    <li class="swiper-slide" style="width: auto !important;">
                    @endif
                        <button class="flex flex-col grow w-[5.5rem] lg:w-40 justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-disabled-light/40 rounded-lg duration-300 days-button" id="today+{{ $i }}" data-index="{{ $i }}">
                            <div class="flex flex-col lg:hidden">
                                {{-- Days for Mobile --}}
                                <p class="font-normal">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('D') }}</p>
                                {{-- Date Abbreviation Mobile --}}
                                <h3 class="text-lg/tight line-clamp-1">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('d M') }}</h3>
                            </div>
    
                            <div class="lg:flex lg:flex-col hidden">
                                {{-- Days for Desktop --}}
                                <p class="font-normal">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('l') }}</p>
                                {{-- Date Abbreviation Desktop --}}
                                <h3 class="text-xl/tight line-clamp-1">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('d M Y') }}</h3>
                            </div>
    
                            {{-- Horizontal Lines --}}
                            <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="swiper swiperResults w-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide px-6 lg:px-[4.25rem]">
                    @if ($todaySchedule && !$todaySchedule->isEmpty())
                        <div class="mt-5 lg:mt-8 mb-8 font-league lg:grid lg:grid-cols-2 lg:gap-12">
                            @foreach ($todaySchedule as $todayCourse)
                                {{-- Past Course --}}
                                @if (Carbon\Carbon::parse($todayCourse->formattedEndTime)->isPast())
                                <div class="grid grid-cols-7 gap-3.5 lg:gap-1 items-start h-fit">
                                    {{-- Decorative Element --}}
                                    <div class="flex flex-col py-0.5 h-full">
                                        {{-- Checkmark Icons --}}
                                        <div class="flex justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="32" height="32" viewBox="0 0 24 24"><path fill="#646464" fill-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10m-5.97-3.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l2.235-2.235L14.97 8.97a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                        </div>

                                        {{-- If this is the last item in the collection, abandon this decorative element --}}
                                        @if ($todayCourse !== $todaySchedule->last())
                                            <div class="w-1/2 ml-0.5 h-full border-r-2 border-dashed border-custom-grey flex-grow lg:hidden"></div>                                            
                                        @endif
                                    </div>

                                    {{-- If this is the last item in the collection, do not add padding-bottom-7 --}}
                                    @if ($todayCourse !== $todaySchedule->last())
                                        <div class="col-span-6 flex flex-row justify-between items-center text-custom-grey pb-7 lg:pb-0 gap-5">
                                    @else
                                        <div class="col-span-6 flex flex-row justify-between items-center text-custom-grey gap-5">
                                    @endif
                                        <div class="flex flex-col gap-2 lg:gap-4">
                                            {{-- Name, Meeting Number and Course Start and End Time --}}
                                            <div class="flex flex-col">
                                                {{-- Student Name --}}
                                                <h3 class="font-semibold text-lg/tight lg:text-2xl/tight">{{ $todayCourse->enrollment['student_real_name'] }}</h3>

                                                {{-- Course Start and End Time --}}
                                                <p class="font-normal text-base/tight lg:text-lg/tight line-clamp-1">Pertemuan {{ $todayCourse['meeting_number'] }} | {{ $todayCourse->formattedStartTime }} - {{ $todayCourse->formattedEndTime }} WIB</p>
                                            </div>

                                            {{-- CTA --}}
                                            <a href="{{ url('/admin-course-progress/' . $todayCourse->enrollment->student_real_name . '/' . $todayCourse->enrollment['id']) }}" class="flex flex-row gap-1 items-center w-fit underline lg:hover:no-underline font-light lg:font-normal text-base/tight lg:text-lg/tight duration-300">Lihat Detail</a>
                                        </div>

                                        {{-- Course Status --}}
                                        <div class="flex items-center h-10 lg:h-[42px] bg-custom-grey text-custom-white text-base/tight lg:text-lg/tight flex-shrink-0 rounded-full px-4 lg:px-6">Selesai</div>
                                    </div>
                                </div>                                    

                                {{-- Present Course --}}
                                @elseif(Carbon\Carbon::parse($todayCourse->formattedStartTime)->isPast() && Carbon\Carbon::parse($todayCourse->formattedEndTime)->isFuture())
                                <div class="grid grid-cols-7 gap-3.5 lg:gap-1 items-start h-fit">
                                    {{-- Decorative Element --}}
                                    <div class="flex flex-col py-0.5 lg:py-1.5 flex-grow h-full">
                                        {{-- Checkmark Icons --}}
                                        <div class="flex justify-center"><div class="w-[26px] h-[26px] flex-shrink-0 bg-custom-white border-4 border-custom-dark rounded-full"></div></div>

                                        {{-- If this is the last item in the collection, abandon this decorative element --}}
                                        @if ($todayCourse !== $todaySchedule->last())
                                            <div class="w-1/2 ml-0.5 h-full border-r-2 border-dashed border-custom-dark flex-grow lg:hidden"></div>
                                        @endif
                                    </div>
                                    
                                    {{-- If this is the last item in the collection, do not add padding-bottom-7 --}}
                                    @if ($todayCourse !== $todaySchedule->last())
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark pb-7 lg:pb-0 gap-5">
                                    @else
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark gap-5">
                                    @endif
                                        <div class="flex flex-col gap-2 lg:gap-4">
                                            {{-- Name, Meeting Number and Course Start and End Time --}}
                                            <div class="flex flex-col">
                                                {{-- Student Name --}}
                                                <h3 class="font-semibold text-lg/tight lg:text-2xl/tight">{{ $todayCourse->enrollment['student_real_name'] }}</h3>

                                                {{-- Course Start and End Time --}}
                                                <p class="font-normal text-base/tight lg:text-lg/tight line-clamp-1">Pertemuan {{ $todayCourse['meeting_number'] }} | {{ $todayCourse->formattedStartTime }} - {{ $todayCourse->formattedEndTime }} WIB</p>
                                            </div>

                                            {{-- CTA --}}
                                            <a href="{{ url('/admin-course-progress/' . $todayCourse->enrollment->student_real_name . '/' . $todayCourse->enrollment['id']) }}" class="flex flex-row gap-1 items-center w-fit underline lg:hover:no-underline font-light lg:font-normal text-base/tight lg:text-lg/tight duration-300">Lihat Detail</a>
                                        </div>

                                        {{-- Course Status --}}
                                        <div class="flex items-center h-10 lg:h-[42px] bg-custom-dark text-custom-white text-base/tight lg:text-lg/tight flex-shrink-0 rounded-full px-4 lg:px-6">Berlangsung</div>
                                    </div>
                                </div>

                                {{-- Future Course --}}
                                @else
                                <div class="grid grid-cols-7 gap-3.5 lg:gap-1 items-start h-fit">
                                    {{-- Decorative Element --}}
                                    <div class="flex flex-col py-0.5 lg:py-1.5 flex-grow h-full">
                                        {{-- Checkmark Icons --}}
                                        <div class="flex justify-center"><div class="w-[26px] h-[26px] flex-shrink-0 bg-custom-white border-4 border-custom-green rounded-full"></div></div>

                                        {{-- If this is the last item in the collection, abandon this decorative element --}}
                                        @if ($todayCourse !== $todaySchedule->last())
                                            <div class="w-1/2 ml-0.5 h-full border-r-2 border-dashed border-custom-green flex-grow lg:hidden"></div>
                                        @endif
                                    </div>

                                    {{-- If this is the last item in the collection, do not add padding-bottom-7 --}}
                                    @if ($todayCourse !== $todaySchedule->last())
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark pb-7 lg:pb-0 gap-5">
                                    @else
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark gap-5">
                                    @endif
                                        <div class="flex flex-col gap-2 lg:gap-4">
                                            {{-- Name, Meeting Number and Course Start and End Time --}}
                                            <div class="flex flex-col">
                                                {{-- Student Name --}}
                                                <h3 class="font-semibold text-lg/tight lg:text-2xl/tight">{{ $todayCourse->enrollment['student_real_name'] }}</h3>

                                                {{-- Course Start and End Time --}}
                                                <p class="font-normal text-base/tight lg:text-lg/tight line-clamp-1">Pertemuan {{ $todayCourse['meeting_number'] }} | {{ $todayCourse->formattedStartTime }} - {{ $todayCourse->formattedEndTime }} WIB</p>
                                            </div>

                                            {{-- CTA --}}
                                            <a href="{{ url('/admin-course-progress/' . $todayCourse->enrollment->student_real_name . '/' . $todayCourse->enrollment['id']) }}" class="flex flex-row gap-1 items-center w-fit underline lg:hover:no-underline font-light lg:font-normal text-base/tight lg:text-lg/tight duration-300">Lihat Detail</a>
                                        </div>

                                        {{-- Course Status --}}
                                        <div class="flex items-center h-10 lg:h-[42px] bg-custom-green text-custom-white text-base/tight lg:text-lg/tight flex-shrink-0 rounded-full px-4 lg:px-6">Mendatang</div>
                                    </div>
                                </div>                                    
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="font-league text-center lg:text-xl my-12 lg:my-20">(Tidak ada kursus untuk {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }})</p>
                    @endif
                </div>

                @foreach ($nextDaySchedules as $day => $schedules)
                    <div class="swiper-slide px-6 lg:px-[4.25rem]">
                        @if ($schedules->isNotEmpty())
                        <div class="mt-5 lg:mt-8 mb-8 font-league lg:grid lg:grid-cols-2 lg:gap-12">
                            @foreach ($schedules as $schedule)
                                <div class="grid grid-cols-7 gap-3.5 lg:gap-1 items-start h-fit overflow-hidden"> <!-- Adjusted here -->
                                    {{-- Decorative Element --}}
                                    <div class="flex flex-col py-0.5 lg:py-1.5 flex-grow h-full">
                                        {{-- Checkmark Icons --}}
                                        <div class="flex justify-center"><div class="w-[26px] h-[26px] flex-shrink-0 bg-custom-white border-4 border-custom-green rounded-full"></div></div>

                                        {{-- If this is the last item in the collection, abandon this decorative element --}}
                                        @if ($schedule !== $schedules->last())
                                            <div class="w-1/2 ml-0.5 h-full border-r-2 border-dashed border-custom-green flex-grow lg:hidden"></div>
                                        @endif
                                    </div>

                                    {{-- If this is the last item in the collection, do not add padding-bottom-7 --}}
                                    @if ($schedule !== $schedules->last())
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark pb-7 lg:pb-0 gap-5">
                                    @else
                                    <div class="col-span-6 flex flex-row justify-between items-center text-custom-dark gap-5">
                                    @endif
                                        <div class="flex flex-col gap-2 lg:gap-4">
                                            {{-- Name, Meeting Number and Course Start and End Time --}}
                                            <div class="flex flex-col">
                                                {{-- Student Name --}}
                                                <h3 class="font-semibold text-lg/tight lg:text-2xl/tight">{{ $schedule->enrollment['student_real_name'] }}</h3>

                                                {{-- Course Start and End Time --}}
                                                <p class="font-normal text-base/tight lg:text-lg/tight line-clamp-1">Pertemuan {{ $schedule['meeting_number'] }} | {{ $schedule->formattedStartTime }} - {{ $schedule->formattedEndTime }} WIB</p>
                                            </div>

                                            {{-- CTA --}}
                                            <a href="{{ url('/admin-course-progress/' . $schedule->enrollment->student_real_name . '/' . $schedule->enrollment['id']) }}" class="flex flex-row gap-1 items-center w-fit underline lg:hover:no-underline font-light lg:font-normal text-base/tight lg:text-lg/tight duration-300">Lihat Detail</a>
                                        </div>

                                        {{-- Course Status --}}
                                        <div class="flex items-center h-10 lg:h-[42px] bg-custom-green text-custom-white text-base/tight lg:text-lg/tight flex-shrink-0 rounded-full px-4 lg:px-6">Mendatang</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                        <p class="font-league text-center lg:text-xl my-12 lg:my-20">(Tidak ada kursus untuk {{ \Carbon\Carbon::now()->addDays($day)->translatedFormat('d F Y') }})</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="px-6 lg:px-[4.25rem]">
        @include('partials.footer')
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const swiper = new Swiper('.swiperResults', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,
            autoHeight: true,
            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex;
                    const buttons = $('.days-button');

                    buttons.each(function() {
                        const buttonIndex = $(this).data('index');
                        if (buttonIndex == currentIndex) {
                            $(this).removeClass('bg-custom-disabled-light/40');
                            $(this).addClass('bg-custom-white-hover border-2 border-custom-dark');
                        } else {
                            $(this).removeClass('bg-custom-white-hover border-2 border-custom-dark');
                            $(this).addClass('bg-custom-disabled-light/40');
                        }
                    });
                },
                init: function () {
                    this.update();
                }
            }
        });

        // Initialize Days Tab Swiper
        const swiperTabs = new Swiper('.swiperTabs', {
            slidesPerView: "auto",
            spaceBetween: window.innerWidth >= 1024 ? 15 : 10,
        });

        // Jump back 7 slides
        $('.prevWeek').on('click', function() {
            const currentIndex = swiperTabs.activeIndex;
            const newIndex = Math.max(currentIndex - 7, 0); // Ensure it doesn't go below 0
            swiperTabs.slideTo(newIndex);
        });

        // Jump forward 7 slides
        $('.nextWeek').on('click', function() {
            const currentIndex = swiperTabs.activeIndex;
            const lastIndex = swiperTabs.slides.length - 1;
            const newIndex = Math.min(currentIndex + 7, lastIndex); // Ensure it doesn't exceed the last index
            swiperTabs.slideTo(newIndex);
        });

        $(document).on('click', '.days-button', function() {
            const index = $(this).data('index');
            swiper.slideTo(index);
        });
    </script>
@endsection