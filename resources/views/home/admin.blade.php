@extends('layouts.relative')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col mt-5 mb-8 lg:mb-11 px-6 lg:px-[4.25rem]">
        <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight">Hi, {{ auth()->user()->fullname }}</p>
        @if ($incomingSchedule)
            <h1 class="mb-3 lg:mb-5 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Kursus Mendatang</h1>
        @else
            <h1 class="mb-3 lg:mb-5 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Belum ada Kursus Mendatang</h1>
        @endif

        {{-- Incoming Course Card --}}
        @if ($incomingSchedule)
            {{-- Mobile Incoming Schedule --}}
            <a href="{{ url('/admin-course-progress/' . $incomingSchedule->enrollment->student->fullname . '/' . $incomingSchedule->enrollment['id']) }}" class="w-full bg-custom-white-hover p-3.5 lg:hidden rounded-xl overflow-hidden drop-shadow-lg duration-300">
                <div class="flex flex-col gap-4">
                    {{-- Student Information --}}
                    <div class="flex flex-row gap-3 items-center lg:hidden">
                        {{-- Student Profile Picture --}}
                        @if ($incomingSchedule->enrollment->student->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->student->hash_for_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        {{-- Student Blank Profile Picture --}}
                        @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                        @endif

                        <div class="flex flex-col lg:gap-1">
                            {{-- Student Name --}}
                            <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight lg:text-xl/tight text-custom-dark">{{ $incomingSchedule->enrollment->student->fullname }}</h2>
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
                <a href="{{ url('https://wa.me/' . $incomingSchedule->enrollment->student->phone_number) }}" target="_blank" class="lg:relative lg:flex lg:flex-col lg:justify-center lg:items-center lg:gap-2 bg-custom-white-hover rounded-xl p-6 overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    @if ($incomingSchedule->enrollment->student->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->student->hash_for_profile_picture) }}" alt="Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Student Profile Picture" class="rounded-full object-cover object-center w-[4.5rem] h-[4.5rem]">
                    @endif

                    {{-- Student Name --}}
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark line-clamp-1">{{ $incomingSchedule->enrollment->student->fullname }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full hover:bg-custom-green/90 opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-league font-medium text-xl/tight text-custom-white">Hubungi Siswa</p>
                    </div>
                </a>

                {{-- Course Card --}}
                <a href="{{ url('/admin-course-progress/' . $incomingSchedule->enrollment->student->fullname . '/' . $incomingSchedule->enrollment['id']) }}" class="col-span-3 w-full bg-custom-white-hover p-3 lg:p-6 rounded-xl overflow-hidden drop-shadow-lg lg:cursor-pointer lg:drop-shadow lg:hover:drop-shadow-lg duration-300">
                    <div class="flex flex-col gap-4">
                        {{-- Student Information --}}
                        <div class="flex flex-row gap-3 items-center lg:hidden">
                            {{-- Student Profile Picture --}}
                            @if ($incomingSchedule->enrollment->student->hash_for_profile_picture)
                            <img src="{{ asset('storage/profile_pictures/' . $incomingSchedule->enrollment->student->hash_for_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                            {{-- Student Blank Profile Picture --}}
                            @else
                            <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-16 h-12 lg:h-16 rounded-full object-cover object-center">
                            @endif
    
                            <div class="flex flex-col lg:gap-1">
                                {{-- Student Name --}}
                                <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight lg:text-xl/tight text-custom-dark">{{ $incomingSchedule->enrollment->student->fullname }}</h2>
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
                    <h2 class="font-encode tracking-tight font-semibold lg:text-xl/tight text-custom-dark line-clamp-1">{{ $incomingSchedule->enrollment->instructor->fullname }}</h2>

                    {{-- Hover Overlays --}}
                    <div class="absolute top-0 flex flex-col gap-2 justify-center items-center w-full h-full hover:bg-custom-green/90 opacity-0 hover:opacity-100 duration-300">
                        {{-- Whatsapp Icons --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m3 21l1.65-3.8a9 9 0 1 1 3.4 2.9z"/><path d="M9 10a.5.5 0 0 0 1 0V9a.5.5 0 0 0-1 0za5 5 0 0 0 5 5h1a.5.5 0 0 0 0-1h-1a.5.5 0 0 0 0 1"/></g></svg>

                        {{-- Text Content --}}
                        <p class="font-league font-medium text-xl/tight text-custom-white">Hubungi Instruktur</p>
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
        <h2 class="mb-5 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-3xl/tight px-6 lg:px-[4.25rem]">Jadwal Kursus</h2>

        {{-- Tabs --}}
        <div class="overflow-x-auto px-6" style="scrollbar-width: none;">
            <ul class="flex flex-row items-center gap-3 font-league text-custom-dark text-lg/tight font-semibold text-center">
                {{-- Today's Tab --}}
                <li class="flex-shrink-0">
                    <button class="flex flex-col grow w-[5.5rem] justify-center items-center p-2 bg-custom-white-hover border-2 border-custom-dark rounded-lg duration-300">
                        {{-- Days --}}
                        <p class="font-normal">{{ \Carbon\Carbon::now()->translatedFormat('D') }}</p>
                        {{-- Date Abbreviation --}}
                        <h3 class="text-xl/tight">{{ \Carbon\Carbon::now()->translatedFormat('d M') }}</h3>
                        {{-- Horizontal Lines --}}
                        <div class="mt-2.5 mb-0.5 w-full px-3"><div class="border-b-2 border-custom-dark"></div></div>
                    </button>
                </li>

                {{-- Loop for Next Day Tabs --}}
                @for ($i = 1; $i <= 6; $i++)
                    @if ($i === 6)
                    <li class="flex-shrink-0 pr-6">
                    @else
                    <li class="flex-shrink-0">                    
                    @endif
                        <button class="flex flex-col grow w-[5.5rem] justify-center items-center p-2 bg-custom-disabled-light/40 rounded-lg duration-300">
                            {{-- Days --}}
                            <p class="font-normal">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('D') }}</p>
                            {{-- Date Abbreviation --}}
                            <h3 class="text-xl/tight">{{ \Carbon\Carbon::now()->addDays($i)->translatedFormat('d M') }}</h3>
                            {{-- Horizontal Lines --}}
                            <div class="opacity-0 mt-2.5 mb-0.5 w-full px-3"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>
                    </li>
                @endfor
            </ul>
        </div>

        <p class="font-league text-center lg:text-xl px-6 lg:px-[4.25rem] my-20">(Tidak ada kursus mendatang)</p>
    </div>

    <div class="px-6 lg:px-[4.25rem]">
        @include('partials.footer')
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection