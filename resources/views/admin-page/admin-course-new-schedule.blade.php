@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Ajukan Jadwal Kursus Baru</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ubah jadwal <span class="font-semibold">{{ $enrollment->course->course_name }}</span> untuk siswa <span class="font-semibold">{{ $enrollment->student_real_name }}</span></p>
        </div>

        {{-- Tabs --}}
        <div class="overflow-x-auto px-6 lg:px-[4.25rem]" style="scrollbar-width: none;">
            <ul class="flex flex-row lg:grid lg:grid-cols-7 items-center gap-3 lg:gap-3 font-league text-custom-dark text-base/tight font-semibold text-center">
                @foreach ($upcomingSchedule as $nextCourseSchedule)

                {{-- if this is the last item, add an extra padding right --}}
                @if ($nextCourseSchedule === $upcomingSchedule->last())
                <li class="flex-shrink-0 pr-6">
                @else
                <li class="flex-shrink-0">
                @endif
                    {{-- If this is the first item, make it in active state --}}
                    @if ($nextCourseSchedule === $upcomingSchedule->first())
                    <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-white-hover border-2 border-custom-dark rounded-lg duration-300 days-button" id="todays-tab" data-index="0">
                        <div class="flex flex-col">
                            <p class="font-normal">Pertemuan</p>
                            {{-- Meetings Number --}}
                            <h3 class="text-lg/tight line-clamp-1">{{ $nextCourseSchedule->meeting_number }}</h3>
                        </div>

                        {{-- Horizontal Lines --}}
                        <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                    </button>

                    @else
                    <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-disabled-light/40 rounded-lg duration-300 days-button" id="todays-tab" data-index="0">
                        <div class="flex flex-col">
                            <p class="font-normal">Pertemuan</p>
                            {{-- Meetings Number --}}
                            <h3 class="text-lg/tight line-clamp-1">{{ $nextCourseSchedule->meeting_number }}</h3>
                        </div>

                        {{-- Horizontal Lines --}}
                        <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                    </button>
                    @endif

                </li>
                @endforeach
            </ul>
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