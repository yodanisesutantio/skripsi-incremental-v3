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
                    <div class="flex flex-col justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                        <h2 class="text-lg/snug lg:text-2xl/[1.5rem] font-semibold">Jadwal Kursus</h2>
                        <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Kamu belum memilih jadwal kursus</p>
                    </div>
                </a>
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-3">
                        {{-- Read Theory Button --}}
                        <a href="/course-theory" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Guide-BG.jpg') }}')">
                            <div class="flex flex-col justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/snug lg:text-2xl/[1.5rem] font-semibold">Baca Panduan</h2>
                                <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ikuti langkah-langkah nya</p>
                            </div>
                        </a>
                        {{-- Contact Other Parties Button --}}
                        <button type="button" id="button-open-contact-party" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Contact-Course-BG.webp') }}')">
                            <div class="flex flex-col justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% text-left w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/snug lg:text-2xl/[1.75rem] font-semibold">Hubungi Pihak Kursus</h2>
                                <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ajukan Pertanyaan</p>
                            </div>
                        </button>
                    </div>
    
                    {{-- Open Quiz Button --}}
                    <a href="/course-quiz" class="w-full bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Quiz-BG.jpg') }}')">
                        <div class="flex flex-col justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/20 to-70% text-left w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                            <h2 class="text-lg/snug lg:text-2xl/[2rem] font-semibold">Quiz</h2>
                            <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Uji tingkat pemahaman anda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3 lg:px-24">

        </div>
    </div>

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection