@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Headers --}}
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">{{ $enrollment->course->course_name }}</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Instruktur : {{ $enrollment->instructor->fullname }} &nbsp; | &nbsp; Siswa : {{ $enrollment->student_real_name }}</p>

    @if (!$enrollment->CoursePayment || $enrollment->CoursePayment->paymentStatus === 0)
        <div class="mt-4 p-3 lg:p-5 bg-custom-destructive/15 w-full rounded-lg lg:rounded-xl">
            <h2 class="font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">Bukti Pembayaran Kursus belum diverifikasi!</h2>
        </div>
    @endif

    @php
        $pendingInstructorApprovals = [];
        $pendingStudentApprovals = [];
        foreach ($enrollment->schedule as $schedule) {
            if ($schedule->proposedSchedule && $schedule->proposedSchedule->instructor_decision === 0) {
                $pendingInstructorApprovals[] = $schedule->meeting_number;
            }
            if ($schedule->proposedSchedule && $schedule->proposedSchedule->student_decision === 0) {
                $pendingStudentApprovals[] = $schedule->meeting_number;
            }
        }
    @endphp

    @if (!empty($pendingInstructorApprovals))
        <div class="mt-4 p-3 lg:p-5 bg-custom-warning/40 w-full rounded-lg lg:rounded-xl">
            <h2 class="font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                Jadwal Baru untuk Pertemuan {{ implode(' & ', $pendingInstructorApprovals) }} belum disetujui oleh Instruktur!
            </h2>
        </div>
    @endif

    @if (!empty($pendingStudentApprovals))
        <div class="mt-4 p-3 lg:p-5 bg-custom-warning/40 w-full rounded-lg lg:rounded-xl">
            <h2 class="font-league font-normal text-lg/tight lg:text-xl/tight text-custom-destructive">
                Jadwal Baru untuk Pertemuan {{ implode(' & ', $pendingStudentApprovals) }} belum disetujui oleh Siswa!
            </h2>
        </div>
    @endif
    
    <div class="lg:grid lg:grid-cols-5">
        <div class="lg:col-span-2 bg-custom-white flex flex-col gap-5">
            {{-- Menu Button Groups --}}
            <div class="flex flex-col font-league text-custom-white gap-3 my-5 lg:my-8">
                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-3">
                        {{-- Registration Form Button --}}
                        <a href="{{ url('/admin-course/registration-form/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Guide-BG.webp') }}')">
                            {{-- Overlays --}}
                            <div class="flex flex-col gap-0.5 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Formulir Pendaftaran</h2>
                                <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Lihat formulir pendaftaran siswa</p>
                            </div>
                        </a>

                        {{-- Course Payment Button --}}
                        <a href="{{ url('/admin-course/payment-verification/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/course-payment.webp') }}')">
                            {{-- Overlays --}}
                            <div class="flex flex-col gap-0.5 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Bukti Pembayaran</h2>
                                <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Lihat bukti pembayaran siswa</p>
                            </div>
                        </a>
                    </div>
    
                    {{-- Open Quiz Button --}}
                    <button type="button" id="button-contact-other-party" class="w-full bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Contact-Course-BG.webp') }}')">
                        {{-- Overlays --}}
                        <div class="flex flex-col gap-0.5 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% text-left w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                            <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Hubungi Pihak Lain</h2>
                            <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Ajukan Pertanyaan</p>
                        </div>
                    </button>
                </div>
            </div>

            
            {{-- Meeting Dropdown FOR MOBILE, PLEASE SEE BELOW FOR THE LARGE SCREEN --}}
            <div class="flex flex-col gap-4 font-league mb-6 lg:mb-8 lg:hidden">
                <h2 class="font-semibold font-encode text-xl/tight lg:text-3xl/tight">Informasi Pertemuan</h2>
                @for ($i = 1; $i <= $enrollment->course->course_length; $i++)
                    @if ($i < $currentMeetingNumber)
                        <div class="font-league text-custom-white relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-4 bg-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-green-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 hidden">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-white flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-custom-green rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-white w-full"></div>

                                    {{-- Student Achievement --}}
                                    <div class="flex flex-col gap-5">
                                        @if ($i === 1)
                                            {{-- Select Schedule Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Pilih Jadwal
                                                
                                                @if ($enrollment->schedule)
                                                    {{-- Checked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                @endif
                                            </div>
    
                                            {{-- Course Payment Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Lunasi Pembayaran
                                                
                                                @if ($enrollment->coursePayment)
                                                    @if ($enrollment->coursePayment->paymentStatus === 1)
                                                        {{-- Checked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                                    @else
                                                        {{-- Unchecked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                    @endif
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                @endif
                                            </div>
                                        @endif
    
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->theoryStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->quizStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($i === $currentMeetingNumber)
                        <div class="font-league text-custom-green relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-4 bg-custom-white-hover border border-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-white-hover border border-custom-green text-custom-grey rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-white-hover border border-custom-green flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-custom-green rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-grey w-full"></div>

                                    <div class="flex flex-col gap-5">
                                        @if ($i === 1)
                                            {{-- Select Schedule Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Pilih Jadwal
                                                
                                                @if ($enrollment->schedule)
                                                    {{-- Checked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                                @endif
                                            </div>
    
                                            {{-- Course Payment Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Lunasi Pembayaran
                                                
                                                @if ($enrollment->coursePayment)
                                                    @if ($enrollment->coursePayment->paymentStatus === 1)
                                                        {{-- Checked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                                    @else
                                                        {{-- Unchecked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                    @endif
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                @endif
                                            </div>
                                        @endif
    
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->theoryStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->quizStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>

                    @else                                            
                        <div class="font-league text-custom-dark/75 relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-4 bg-custom-disabled-dark drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D99" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D99" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-[#8A8A8A] rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 hidden">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-dark/75 flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-[#8A8A8A] rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-dark/75 w-full"></div>

                                    <div class="flex flex-col gap-5">
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D99" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>         
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D99" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        {{-- This is the dropdown for large screen. PLEASE SEE ABOVE FOR THE MOBILE  --}}
        <div class="lg:col-span-3 lg:pl-24 lg:mt-8">
            <div class="lg:flex lg:flex-col lg:gap-4 font-league lg:mb-8 hidden">
                <h2 class="font-semibold font-encode text-xl/tight lg:text-3xl/tight">Informasi Pertemuan</h2>
                @for ($i = 1; $i <= $enrollment->course->course_length; $i++)
                    @if ($i < $currentMeetingNumber)
                        <div class="font-league text-custom-white relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-4 bg-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-green-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 hidden">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-dark/75 flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-[#8A8A8A] rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-white w-full"></div>

                                    <div class="flex flex-col gap-5">
                                        @if ($i === 1)
                                            {{-- Select Schedule Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Pilih Jadwal
                                                
                                                @if ($enrollment->schedule)
                                                    {{-- Checked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                                @endif
                                            </div>
    
                                            {{-- Course Payment Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Lunasi Pembayaran
                                                
                                                @if ($enrollment->coursePayment)
                                                    @if ($enrollment->coursePayment->paymentStatus === 1)
                                                        {{-- Checked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                                    @else
                                                        {{-- Unchecked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                    @endif
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                @endif
                                            </div>
                                        @endif
    
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->theoryStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->quizStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($i === $currentMeetingNumber)
                        <div class="font-league text-custom-green relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-4 bg-custom-white-hover border border-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-white-hover border border-custom-green text-custom-grey rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-white-hover border border-custom-green flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-custom-green rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-grey w-full"></div>

                                    <div class="flex flex-col gap-5">
                                        @if ($i === 1)
                                            {{-- Select Schedule Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Pilih Jadwal
                                                
                                                @if ($enrollment->schedule)
                                                    {{-- Checked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0DBB" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                                @endif
                                            </div>
    
                                            {{-- Course Payment Achievement --}}
                                            <div class="flex flex-row justify-between items-center">
                                                Lunasi Pembayaran
                                                
                                                @if ($enrollment->coursePayment)
                                                    @if ($enrollment->coursePayment->paymentStatus === 1)
                                                        {{-- Checked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                                    @else
                                                        {{-- Unchecked Checkbox --}}
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0DBB" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                    @endif
                                                @else
                                                    {{-- Unchecked Checkbox --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                                @endif
                                            </div>
                                        @endif
    
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->theoryStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            @if ($enrollment->schedule->contains(function ($schedule) use ($i) {
                                                return $schedule->meeting_number === $i && $schedule->quizStatus === 1;
                                            }))
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else                                            
                        <div class="font-league text-custom-dark/70 relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-4 bg-custom-disabled-dark drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D99" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D99" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-[#8A8A8A] rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 hidden">
                                <div class="flex flex-col gap-6">
                                    {{-- Display Day, Date Month Year --}}
                                    @php
                                        $schedule = $enrollment->schedule->where('meeting_number', $i)->first();
                                    @endphp
                                    
                                    <div class="flex flex-col gap-4">
                                        {{-- Course Schedule Content --}}
                                        <div class="flex flex-row gap-10 justify-between">
                                            @if ($schedule)
                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight">{{ $schedule->formatted_date ?? '' }}</h3>

                                                <h3 class="font-league font-semibold text-lg/tight lg:text-xl/tight text-right whitespace-nowrap">{{ $schedule->formatted_time ?? '' }} WIB</h3>
                                            @else
                                                <h3 class="w-full font-league font-semibold text-center text-lg/tight lg:text-xl/tight">Belum ada Jadwal yang dipilih</h3>
                                            @endif
                                        </div>

                                        {{-- Course Schedule Header --}}
                                        {{-- I kinda need to change this to open a popup that let instructor decide whether they confirm or deny the schedule proposal instead of having the ability to propose a new schedule by themselves --}}
                                        @if ($schedule && \Carbon\Carbon::parse($schedule->start_time)->isFuture() && \Carbon\Carbon::now()->addHours(24)->lessThan(\Carbon\Carbon::parse($schedule->start_time)) && !$schedule->proposedSchedule)
                                            <a href="{{ url('/admin-course/new-schedule/schedule/' . $schedule->id) }}" class="bg-custom-dark/75 flex items-center justify-center p-3 font-encode font-semibold text-base/tight text-[#8A8A8A] rounded-lg">Ubah Jadwal</a>
                                        @endif
                                    </div>

                                    <div class="border-b border-custom-dark/75 w-full"></div>

                                    <div class="flex flex-col gap-5">
                                        {{-- Read Theory Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Baca Panduan Kursus
                                            
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D99" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>         
                                        </div>
    
                                        {{-- Finish the Quiz Achievement --}}
                                        <div class="flex flex-row justify-between items-center">
                                            Selesaikan Quiz
                                            
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D99" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>

    {{-- Confirm Schedule Changes --}}
    <div class="hidden flex-col lg:grid-cols-2 lg:items-center justify-center gap-6 fixed top-0 left-0 font-league w-full h-full bg-custom-dark/70 z-40 pt-12 lg:pt-0 px-6 lg:px-[4.25rem]" id="confirm-schedule-overlay">
        {{-- Close Button --}}
        <button type="button" id="close-confirm-schedule-overlay" class="fixed top-7 right-6"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#EBF0F2" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>

        {{-- Old Schedule --}}
        <button type="button" class="lg:w-full lg:mt-10" id="reject-schedule">
            {{-- Overlays --}}
            <div class="flex flex-col gap-5 w-full h-72 rounded-xl px-6 pt-2 lg:pt-0 justify-center items-center border-2 border-custom-green text-custom-dark bg-custom-white lg:px-20 lg:hover:bg-custom-white-hover duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Pilih Jadwal Lama</h2>
                <div class="flex flex-col gap-1">
                    <p class="font-normal text-base/tight lg:text-lg/tight">Pertemuan ke-4</p>
                    <h4 class="font-medium text-xl/tight lg:text-2xl/tight">08:00 - 09:30 WIB</h4>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-normal text-base/tight lg:text-lg/tight">Instruktur :</p>
                    <h4 class="font-medium text-xl/tight lg:text-2xl/tight">Nama Instruktur</h4>
                </div>
            </div>
        </button>

        {{-- New Schedule --}}
        <button type="button" class="lg:w-full lg:mt-10" id="confirm-schedule">
            {{-- Overlays --}}
            <div class="flex flex-col gap-5 w-full h-72 rounded-xl px-6 pt-2 lg:pt-0 justify-center items-center text-custom-white bg-custom-green lg:px-20 lg:hover:bg-custom-green-hover duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Pilih Jadwal Baru</h2>
                <div class="flex flex-col gap-1">
                    <p class="font-normal text-base/tight lg:text-lg/tight">Pertemuan ke-4</p>
                    <h4 class="font-medium text-xl/tight lg:text-2xl/tight">10:00 - 11:30 WIB</h4>
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-normal text-base/tight lg:text-lg/tight">Instruktur :</p>
                    <h4 class="font-medium text-xl/tight lg:text-2xl/tight">Nama Instruktur</h4>
                </div>
            </div>
        </button>
    </div>

    {{-- Contact Other Parties Overlay --}}
    <div class="hidden flex-col lg:grid-cols-2 lg:items-center justify-center gap-6 fixed top-0 left-0 font-league w-full h-full bg-custom-dark/70 text-custom-white z-40 pt-12 lg:pt-0 px-6 lg:px-[4.25rem]" id="contact-other-party">
        {{-- Close Button --}}
        <button type="button" id="close-contact-other-party" class="fixed top-7 right-6"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#EBF0F2" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>

        {{-- Contact Admin --}}
        {{-- When Admin has uploaded profile picture, show it as background --}}
        @if ($enrollment->course->admin->hash_for_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->course->admin->phone_number) }}" target="_blank" id="contact-admin" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/profile_pictures/' . $enrollment->course->admin->hash_for_profile_picture) }}')">

        {{-- When Admin has no profile picture, show the default picture --}}
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->course->admin->phone_number) }}" target="_blank" id="contact-admin" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif

            {{-- Overlays --}}
            <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Admin Kursus</h2>
                <p class="font-light text-base/tight lg:text-xl/tight text-center">Hubungi Admin Kursus {{ $enrollment->course->admin->fullname }}</p>
            </div>
        </a>

        {{-- Contact Student --}}
        {{-- When Student has uploaded profile picture, show it as background --}}
        @if ($enrollment->student_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->student_phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/enrollment/profile_pictures/' . $enrollment->student_profile_picture) }}')">

        {{-- When Student has no profile picture, show the default picture --}}
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->student_phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif

            {{-- Overlays --}}
            <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Siswa</h2>
                <p class="font-light text-base/tight lg:text-xl/tight text-center">Mulai percakapan dengan {{ $enrollment->student_real_name }}</p>
            </div>
        </a>
    </div>

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Open Confirm Schedule Modals
        $('#button-contact-other-party').on('click', function() {
            $('#confirm-schedule-overlay').removeClass('hidden');
            $('#confirm-schedule-overlay').addClass('flex lg:grid');
        });
        // Close them when user either click the X icons or chooses to contact one of the options
        $('#close-confirm-schedule-overlay, #reject-schedule, #confirm-schedule').on('click', function() {
            $('#confirm-schedule-overlay').removeClass('flex lg:grid');
            $('#confirm-schedule-overlay').addClass('hidden');
        });

        // Open Contact Other Party Modals
        $('#button-contact-other-party').on('click', function() {
            $('#contact-other-party').removeClass('hidden');
            $('#contact-other-party').addClass('flex lg:grid');
        });
        // Close them when user either click the X icons or chooses to contact one of the options
        $('#close-contact-other-party, #contact-admin, #contact-student').on('click', function() {
            $('#contact-other-party').removeClass('flex lg:grid');
            $('#contact-other-party').addClass('hidden');
        });

        $('.accordion-button').click(function() {
            const content = $(this).closest('h2').next('div');
            const arrowDown = $(this).find('.arrow-down');
            const arrowUp = $(this).find('.arrow-up');

            content.toggleClass('hidden');
            arrowDown.toggleClass('hidden');
            arrowUp.toggleClass('hidden'); 

            $(this).attr('aria-expanded', content.is(':visible')); 
        });

        // Open Delete Student Popups
        $('#openDeleteStudentConfirmation').click(function(event) {
            $('#delete-overlay').removeClass('hidden');
            $('#delete-overlay').addClass('flex');
        });

        // Close Delete Student Popups
        $('#closeDelete, #XDelete').click(function(event) {
            $('#delete-overlay').removeClass('flex');
            $('#delete-overlay').addClass('hidden');
        });

        // Confirm Delete Function
        $('#yesDelete').click(function(event) {
            event.preventDefault();
            $('#yesDelete').next().submit();
        });
    </script>
@endsection