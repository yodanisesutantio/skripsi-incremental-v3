@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Headers --}}
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">{{ $enrollment->course->course_name }}</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Instruktur : {{ $enrollment->instructor->fullname }} &nbsp; | &nbsp; Siswa : {{ $enrollment->student->fullname }}</p>
    
    <div class="lg:grid lg:grid-cols-5">
        <div class="lg:col-span-2 bg-custom-white flex flex-col gap-5">
            {{-- Menu Button Groups --}}
            <div class="flex flex-col font-league text-custom-white gap-3 my-6 lg:my-8">
                {{-- Propose New Schedule Button --}}
                <a href="/choose-new-course-schedule" class="w-full h-24 lg:h-28 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Course-Schedule-BG.webp') }}');">
                    {{-- Overlays --}}
                    <div class="flex flex-col gap-0.5 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                        <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Jadwal Kursus</h2>
                        <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Kamu belum memilih jadwal kursus</p>
                    </div>
                </a>

                <div class="grid grid-cols-2 gap-3">
                    <div class="flex flex-col gap-3">
                        {{-- Registration Form Button --}}
                        <a href="{{ url('/admin-course/registration-form/' . $enrollment->student->fullname . '/' . $enrollment['id']) }}" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/Guide-BG.webp') }}')">
                            {{-- Overlays --}}
                            <div class="flex flex-col gap-0.5 justify-end p-2.5 bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% w-full h-full rounded-xl lg:hover:bg-custom-dark/40 lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Formulir Pendaftaran</h2>
                                <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Lihat formulir pendaftaran siswa</p>
                            </div>
                        </a>

                        {{-- Course Payment Button --}}
                        <a href="{{ url('/admin-course/payment-verification/' . $enrollment->student->fullname . '/' . $enrollment['id']) }}" class="w-full h-32 lg:h-44 bg-cover bg-center rounded-xl cursor-pointer" style="background-image: url('{{ asset('img/course-payment.webp') }}')">
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

            {{-- Achievement Accordions --}}
            <h3 class="font-encode font-semibold text-custom-dark text-xl/tight lg:text-3xl/tight block lg:hidden">Capaian Siswa</h3>
            <div class="flex flex-col gap-4 font-league mb-6 lg:mb-8 lg:hidden">
                @for ($i = 1; $i <= $enrollment->course->course_length; $i++)
                    @if ($i < $currentMeetingNumber)
                        <div class="font-league text-custom-white relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-3.5 bg-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-green-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-4 px-3.5 hidden">
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
                                            
                                            @if ($enrollment->coursePayment->paymentStatus === 1)
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Read Theory Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Baca Panduan Kursus
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                        {{-- @endif --}}
                                    </div>

                                    {{-- Finish the Quiz Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Selesaikan Quiz
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($i === $currentMeetingNumber)
                        <div class="font-league text-custom-green relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-3.5 bg-custom-white-hover border border-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-white-hover border border-custom-green text-custom-grey rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-4 px-3.5 lg:py-3">
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
                                            
                                            @if ($enrollment->coursePayment->paymentStatus === 1)
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            @else
                                                {{-- Unchecked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Read Theory Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Baca Panduan Kursus
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                     --}}
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                        {{-- @endif --}}
                                    </div>

                                    {{-- Finish the Quiz Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Selesaikan Quiz
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                     --}}
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else                                            
                        <div class="font-league text-custom-grey relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-3.5 bg-custom-disabled-dark drop-shadow rounded-lg disabled-achievement" data-number="{{ $i }}">
                                <div class="flex flex-row justify-between items-center w-full text-left" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </div>
                            </h2>
                        </div>
                    @endif
                @endfor
            </div>
        </div>

        <div class="lg:col-span-3 lg:pl-24">
            {{-- Achievement Accordions --}}
            <h3 class="font-encode font-semibold text-custom-dark text-xl/tight lg:text-3xl/tight hidden lg:mt-6 lg:block">Capaian Siswa</h3>
            <div class="lg:flex lg:flex-col lg:gap-4 font-league lg:mt-5 lg:mb-8 hidden">
                @for ($i = 1; $i <= $enrollment->course->course_length; $i++)
                    @if ($i < $currentMeetingNumber)
                        <div class="font-league text-custom-white relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-3.5 bg-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-green-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-4 px-3.5 hidden">
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
                                            
                                            {{-- @if ($enrollment->schedule) --}}
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            {{-- @else --}}
                                                {{-- Unchecked Checkbox --}}
                                                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                            {{-- @endif --}}
                                        </div>
                                    @endif

                                    {{-- Read Theory Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Baca Panduan Kursus
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                        {{-- @endif --}}
                                    </div>

                                    {{-- Finish the Quiz Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Selesaikan Quiz
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($i === $currentMeetingNumber)
                        <div class="font-league text-custom-green relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-3.5 bg-custom-white-hover border border-custom-green drop-shadow rounded-lg">
                                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </button>
                            </h2>

                            {{-- Accordion Content --}}
                            <div id="collapseOne" class="bg-custom-white-hover border border-custom-green text-custom-grey rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-4 px-3.5">
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
                                            
                                            {{-- @if ($enrollment->schedule) --}}
                                                {{-- Checked Checkbox --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                    
                                            {{-- @else --}}
                                                {{-- Unchecked Checkbox --}}
                                                {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                 --}}
                                            {{-- @endif --}}
                                        </div>
                                    @endif

                                    {{-- Read Theory Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Baca Panduan Kursus
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                     --}}
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                        {{-- @endif --}}
                                    </div>

                                    {{-- Finish the Quiz Achievement --}}
                                    <div class="flex flex-row justify-between items-center">
                                        Selesaikan Quiz
                                        
                                        {{-- @if ($enrollment->schedule) --}}
                                            {{-- Checked Checkbox --}}
                                            {{-- <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>                                     --}}
                                        {{-- @else --}}
                                            {{-- Unchecked Checkbox --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>                                
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @else                                            
                        <div class="font-league text-custom-grey relative">
                            {{-- Accordion Button --}}
                            <h2 class="font-medium text-lg/tight lg:text-xl/tight relative z-10 p-3.5 bg-custom-disabled-dark drop-shadow rounded-lg disabled-achievement" data-number="{{ $i }}">
                                <div class="flex flex-row justify-between items-center w-full text-left" aria-expanded="false" aria-controls="collapseOne">
                                    Pertemuan {{ $i }}

                                    {{-- Arrow Down --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                    {{-- Arrow Up --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </div>
                            </h2>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>

    <div class="hidden flex-col lg:grid-cols-2 lg:items-center justify-center gap-6 fixed top-0 left-0 font-league w-full h-full bg-custom-dark/70 text-custom-white z-40 pt-12 lg:pt-0 px-6 lg:px-[4.25rem]" id="contact-other-party">
        {{-- Close Button --}}
        <button type="button" id="close-contact-other-party" class="fixed top-7 right-6"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#EBF0F2" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>

        {{-- Contact Instructor --}}
        {{-- When Instructor has uploaded profile picture, show it as background --}}
        @if ($enrollment->instructor->hash_for_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->instructor->phone_number) }}" target="_blank" id="contact-instructor" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/profile_pictures/' . $enrollment->instructor->hash_for_profile_picture) }}')">

        {{-- When Instructor has no profile picture, show the default picture --}}
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->instructor->phone_number) }}" target="_blank" id="contact-instructor" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif

            {{-- Overlays --}}
            <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Instruktur Anda</h2>
                <p class="font-light text-base/tight lg:text-xl/tight text-center">Hubungi Instruktur Kursus {{ $enrollment->instructor->fullname }}</p>
            </div>
        </a>

        {{-- Contact Driving School Admin --}}
        {{-- When Student has uploaded profile picture, show it as background --}}
        @if ($enrollment->student->hash_for_profile_picture)
        <a href="{{ url('https://wa.me/' . $enrollment->student->phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('storage/profile_pictures/' . $enrollment->student->hash_for_profile_picture) }}')">

        {{-- When Student has no profile picture, show the default picture --}}
        @else
        <a href="{{ url('https://wa.me/' . $enrollment->student->phone_number) }}" target="_blank" id="contact-student" class="lg:w-full bg-cover bg-center rounded-xl lg:mt-10" style="background-image: url('{{ asset('img/blank-profile.webp') }}')">
        @endif

            {{-- Overlays --}}
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
        // Open Contact Other Party Modals
        $('#button-contact-other-party').on('click', function() {
            $('#contact-other-party').removeClass('hidden');
            $('#contact-other-party').addClass('flex lg:grid');
        });
        // Close them when user either click the X icons or chooses to contact one of the options
        $('#close-contact-other-party, #contact-instructor, #contact-student').on('click', function() {
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

        // Error Toastr Message to Show When Users force to click the accordion when it can't be clicked yet
        $('.disabled-achievement').on('click', function() {
            const meeting_number = $(this).data('number');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning('Saat ini capaian untuk Pertemuan ' + meeting_number + ' belum bisa dibuka');
        });
    </script>
@endsection