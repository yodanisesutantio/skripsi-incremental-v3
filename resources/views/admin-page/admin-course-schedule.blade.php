@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Jadwal Kursus</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Jadwal Kursus untuk <span class="font-semibold">{{ $enrollment->student_real_name }}</span> di <span class="font-semibold">{{ $enrollment->course->course_name }}</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Jadwal Kursus</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Jadwal Kursus untuk <span class="font-semibold">{{ $enrollment->student_real_name }}</span> di <span class="font-semibold">{{ $enrollment->course->course_name }}</span></p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:mt-7 lg:px-24">
            @foreach ($courseSchedule as $schedule)
                <div class="flex flex-col gap-2 my-3 mx-6 lg:mx-0 mb-5 lg:mb-12">
                    {{-- Meeting Number Header --}}
                    <div class="flex flex-row justify-between items-center">
                        <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">Pertemuan {{ $schedule->meeting_number }}</h2>

                        @if (\Carbon\Carbon::parse($schedule->start_time)->isFuture())
                            <a href="" class="text-custom-green font-medium text-base/tight lg:text-lg/tight underline hover:no-underline">Ubah Jadwal</a>
                        @endif
                    </div>
            
                    <div class="flex flex-col lg:flex-row gap-3 lg:w-full p-4 lg:p-0 bg-custom-white-hover lg:bg-custom-white-hover/0 rounded-lg lg:rounded-none">
                        {{-- Course Start Date --}}
                        <div class="flex flex-col gap-1 lg:w-2/3 bg-custom-white-hover lg:p-4 lg:rounded-xl">
                            <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Hari & Tanggal Kursus</p>
                            <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('l, d F Y') }}</h3>
                        </div>
                
                        {{-- Course Start & End Time --}}
                        <div class="flex flex-col gap-1 lg:w-1/3 bg-custom-white-hover lg:p-4 lg:rounded-xl">
                            <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Jam Kursus</p>
                            <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ \Carbon\Carbon::parse($schedule->start_time)->translatedFormat('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->translatedFormat('H:i') }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });
    </script>
@endsection