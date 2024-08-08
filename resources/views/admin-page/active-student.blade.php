@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Kelas Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Pilih salah satu kelas untuk anda kelola!</p>

    @if ($activeEnrolledStudent->isEmpty())
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai kursus)</p>
    @else
        {{-- Class List --}}
        <div class="flex lg:grid flex-col lg:grid-cols-2 gap-6 mt-5 lg:mt-10 mb-7 lg:mb-14">
            @foreach ($activeEnrolledStudent as $activeStudent)
            <div class="w-full bg-custom-white-hover p-3 rounded-xl overflow-hidden drop-shadow-lg">
                <div class="flex flex-col gap-4">
                    {{-- Instructors Information --}}
                    <div class="flex flex-row gap-3 items-center">
                        {{-- Instructors Profile Picture --}}
                        @if ($activeStudent->instructor->hash_for_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/' . $activeStudent->instructor->hash_for_profile_picture) }}" alt="Instructor Profile Picture" class="w-12 lg:w-20 h-12 lg:h-20 rounded-full object-cover object-center">
                        {{-- Instructors Blank Profile Picture --}}
                        @else
                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-12 lg:w-20 h-12 lg:h-20 rounded-full object-cover object-center">
                        @endif
    
                        {{-- Instructors Name --}}
                        <div class="flex flex-col">
                            <h2 class="font-encode tracking-tight font-semibold text-[17px]/tight text-custom-dark">{{ $activeStudent->instructor->fullname }}</h2>
                            <p class="font-league text-[15px]/tight text-custom-grey">Instruktur</p>
                        </div>
                    </div>

                    {{-- Course Name and Next Course Date and Time --}}
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1">
                            <h3 class="font-encode tracking-tight font-semibold text-[21px]/tight text-custom-dark">{{ $activeStudent->course->course_name }}</h3>
                            <p class="font-league text-[17px]/tight text-custom-grey">Pertemuan ke-3</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            {{-- Next Course Date --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 py-1 border border-custom-green/50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" d="M22 14v-2c0-.839 0-1.585-.013-2.25H2.013C2 10.415 2 11.161 2 12v2c0 3.771 0 5.657 1.172 6.828C4.343 22 6.229 22 10 22h4c3.771 0 5.657 0 6.828-1.172C22 19.657 22 17.771 22 14M7.75 2.5a.75.75 0 0 0-1.5 0v1.58c-1.44.115-2.384.397-3.078 1.092c-.695.694-.977 1.639-1.093 3.078h19.842c-.116-1.44-.398-2.384-1.093-3.078c-.694-.695-1.639-.977-3.078-1.093V2.5a.75.75 0 0 0-1.5 0v1.513C15.585 4 14.839 4 14 4h-4c-.839 0-1.585 0-2.25.013z"/></svg>
                                <h4 class="font-league text-base/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">10 Agustus 2024</h4>
                            </div>
                            {{-- Next Course Time --}}
                            <div class="flex flex-row items-center w-fit gap-2 px-2 py-1 border border-custom-green/50 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><defs><mask id="solarClockCircleBold0"><g fill="none"><path fill="#fff" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10"/><path fill="#000" fill-rule="evenodd" d="M12 7.25a.75.75 0 0 1 .75.75v3.69l2.28 2.28a.75.75 0 1 1-1.06 1.06l-2.5-2.5a.75.75 0 0 1-.22-.53V8a.75.75 0 0 1 .75-.75" clip-rule="evenodd"/></g></mask></defs><path fill="#24596A" d="M0 0h24v24H0z" mask="url(#solarClockCircleBold0)"/></svg>
                                <h4 class="font-league text-base/tight mt-1 text-custom-green font-medium line-clamp-1 whitespace-nowrap">09:00 - 10:30 WIB</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection