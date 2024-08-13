@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Headers --}}
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl/snug mt-5 lg:mt-10">{{ $enrollment->course->course_name }}</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl mt-1">Instruktur : {{ $enrollment->instructor->fullname }} &nbsp; | &nbsp; Siswa : {{ $enrollment->student->fullname }}</p>
    
    <div class="lg:grid lg:grid-cols-5">
        <div class="lg:col-span-2 bg-custom-white flex flex-col gap-5">
            {{-- Menu Button Groups --}}
            <div class="flex flex-col font-league text-custom-white gap-3 my-6 lg:my-8">
                {{-- Propose New Schedule Button --}}
                <a href="/choose-new-course-schedule" class="w-full h-24 lg:h-28 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Course-Schedule-BG.webp') }}');">
                    <div class="flex flex-col gap-1 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                        <h2 class="text-lg/none lg:text-2xl/snug font-semibold">Jadwal Kursus</h2>
                        <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Kamu belum memilih jadwal kursus</p>
                    </div>
                </a>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-3">
                        {{-- Read Theory Button --}}
                        <a href="/course-theory" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Guide-BG.webp') }}')">
                            <div class="flex flex-col gap-1 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/none lg:text-2xl/snug font-semibold">Baca Panduan</h2>
                                <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ikuti langkah-langkah nya</p>
                            </div>
                        </a>
                        {{-- Contact Other Parties Button --}}
                        <button type="button" id="button-contact-other-party" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Contact-Course-BG.webp') }}')">
                            <div class="flex flex-col gap-1 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% text-left w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/none lg:text-2xl/snug font-semibold">Hubungi Pihak Kursus</h2>
                                <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ajukan Pertanyaan</p>
                            </div>
                        </button>
                    </div>
    
                    {{-- Open Quiz Button --}}
                    <a href="/course-quiz" class="w-full bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Quiz-BG.webp') }}')">
                        <div class="flex flex-col gap-1 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% text-left w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                            <h2 class="text-lg/none lg:text-2xl/snug font-semibold">Quiz</h2>
                            <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Uji tingkat pemahaman anda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 lg:px-24">

        </div>
    </div>

    <div class="hidden flex-col lg:grid-cols-2 lg:items-center justify-center gap-6 fixed top-0 left-0 font-league w-full h-full bg-custom-dark/70 text-custom-white z-40 pt-12 lg:pt-0 px-6 lg:px-[4.25rem]" id="contact-other-party">
        {{-- Close Button --}}
        <button type="button" id="close-contact-other-party" class="fixed top-7 right-6"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#EBF0F2" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
        {{-- Contact Instructor --}}
        @if ($enrollment->instructor->hash_for_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->instructor->phone_number) }}" target="_blank" id="contact-instructor" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/profile_pictures/' . $enrollment->instructor->hash_for_profile_picture) }}')">
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->instructor->phone_number) }}" target="_blank" id="contact-instructor" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif
            <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Instruktur Anda</h2>
                <p class="font-light text-base/tight lg:text-xl/tight text-center">Hubungi Instruktur Kursus {{ $enrollment->instructor->fullname }}</p>
            </div>
        </a>
        {{-- Contact Driving School Admin --}}
        @if ($enrollment->student->hash_for_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->student->phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/profile_pictures/' . $enrollment->student->hash_for_profile_picture) }}')">
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->student->phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif
            <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Siswa</h2>
                <p class="font-light text-base/tight lg:text-xl/tight text-center">Mulai percakapan dengan {{ $enrollment->student->fullname }}</p>
            </div>
        </a>
    </div>

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $('#button-contact-other-party').on('click', function() {
            $('#contact-other-party').removeClass('hidden');
            $('#contact-other-party').addClass('flex lg:grid');
        });
        $('#close-contact-other-party, #contact-instructor, #contact-student').on('click', function() {
            $('#contact-other-party').removeClass('flex lg:grid');
            $('#contact-other-party').addClass('hidden');
        });
    </script>
@endsection