@extends('layouts.main')

@section('content')
    {{-- Mobile Headers --}}
    <header class="z-30 bg-custom-white sticky top-0">
        <div class="flex flex-row lg:hidden pt-8 pb-4 px-5 lg:px-10 border-b border-custom-grey gap-5 items-center">
            <a href="#" class="back-nav-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4m0 0l6-6m-6 6l6 6"/></svg></a>
            <p class="font-encode tracking-tight font-medium text-lg/none">Kursus Saya</p>
        </div>
    </header>

    {{-- Sub Headers --}}
    <div class="flex flex-col mt-5 px-5 lg:mt-8">
        <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl lg:text-4xl">Nama Kelas</h1>
        <p class="text-custom-grey font-league font-medium text-base lg:text-2xl">Instruktur : Nama Instruktur</p>

        {{-- Unpaid Status --}}
        <div class="flex flex-row justify-between items-center p-3 lg:p-5 mt-3 rounded-lg bg-custom-destructive/30 font-league hidden">
            <p class="text-custom-dark text-lg/tight w-3/5">Anda belum melakukan pembayaran</p>
            <a href="" class="text-custom-destructive w-fit font-medium underline text-lg lg:text-xl">Cara Bayar</a>
        </div>

        {{-- Under Verification Status --}}
        <div class="flex flex-row items-center gap-4 p-3 lg:p-4 mt-3 rounded-lg bg-custom-warning/30 font-league hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 -mt-1 lg:mt-0" width="36" height="36" viewBox="0 0 24 24"><path fill="#FAB530" fill-rule="evenodd" d="M3 10.417c0-3.198 0-4.797.378-5.335c.377-.537 1.88-1.052 4.887-2.081l.573-.196C10.405 2.268 11.188 2 12 2c.811 0 1.595.268 3.162.805l.573.196c3.007 1.029 4.51 1.544 4.887 2.081C21 5.62 21 7.22 21 10.417v1.574c0 5.638-4.239 8.375-6.899 9.536C13.38 21.842 13.02 22 12 22s-1.38-.158-2.101-.473C7.239 20.365 3 17.63 3 11.991zm9-3.167a.75.75 0 0 1 .75.75v4a.75.75 0 0 1-1.5 0V8a.75.75 0 0 1 .75-.75M12 16a1 1 0 1 0 0-2a1 1 0 0 0 0 2" clip-rule="evenodd"/></svg>
            <p class="text-custom-dark lg:mt-1.5 text-lg/tight">Pihak Kursus sedang memverifikasi pembayaranmu</p>
        </div>
    </div>

    {{-- Contents --}}
    <div class="flex flex-col lg:mt-2 lg:mb-12 lg:px-5 lg:flex-row lg:gap-8">
        {{-- Menu Button Groups --}}
        <div class="flex flex-col px-5 lg:px-0 lg:w-2/5">
            <div class="flex flex-col mt-6 lg:mt-12 text-custom-white gap-3">
                <a href="choose-new-course-schedule">
                    <div class="w-full h-20 lg:h-24 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('img/Course-Schedule-BG.jpg');">
                        <div class="flex flex-col justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/10 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                            <h2 class="text-lg/snug lg:text-2xl/[1.5rem] font-semibold">Jadwal Kursus</h2>
                            <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Kamu belum memilih jadwal kursus</p>
                        </div>
                    </div>
                </a>
                <div class="flex flex-row gap-3 h-[252px] lg:h-[332px]">
                    <div class="flex flex-col gap-3 w-1/2">
                        <a href="course-theory">
                            <div class="w-full h-[120px] lg:h-[160px] bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('img/Guide-BG.jpg')">
                                <div class="flex flex-col justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/10 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                                    <h2 class="text-lg/snug lg:text-2xl/[1.5rem] font-semibold">Baca Panduan</h2>
                                    <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ikuti langkah-langkah nya</p>
                                </div>
                            </div>
                        </a>
                        <button type="button" id="button-open-contact-party">
                            <div class="w-full h-[120px] lg:h-[160px] bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('img/Contact-Course-BG.jpg')">
                                <div class="flex flex-col justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/10 to-70% font-league text-left w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                                    <h2 class="text-lg/snug lg:text-2xl/[1.75rem] font-semibold">Hubungi Pihak Kursus</h2>
                                    <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Ajukan Pertanyaan</p>
                                </div>
                            </div>
                        </button>
                    </div>
    
                    <div class="w-1/2 h-full bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('img/Quiz-BG.jpg')">
                        <a href="course-quiz">
                            <div class="flex flex-col justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/10 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                                <h2 class="text-lg/snug lg:text-2xl/[2rem] font-semibold">Quiz</h2>
                                <p class="text-sm/tight lg:text-base/[1.35rem] text-custom-white font-light">Uji tingkat pemahaman anda</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- Achievement Tabs --}}
        <div class="flex flex-col mt-9 lg:mt-0 px-5 lg:px-0 lg:w-3/5">
            <h2 class="font-encode tracking-tight text-custom-dark font-semibold text-2xl">Capaian</h2>
            <div class="flex flex-col mt-4 mb-6 gap-3">
                    <div class="flex flex-col">
                        <div class="flex flex-row h-[50px] bg-custom-white-hover border border-custom-green justify-between p-4 items-center rounded-xl lg:cursor-pointer" onclick="openDetails(this)">
                            <h3 class="w-4/5 text-custom-green font-league text-lg/[0] font-medium">Pertemuan Ke-1</h3>
                            <svg id="closeState" class="hidden" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>
                            <svg id="openState" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                        </div>
                        <div class="flex flex-col gap-3 pt-6 pb-3.5 -z-20 bg-custom-white-hover border border-custom-green -mt-3 rounded-b-xl">
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-dark text-base">Pilih Jadwal</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                            </div>
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-dark text-base">Baca Panduan</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                            </div>
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-dark text-base">Selesaikan Quiz</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex flex-row h-[50px] bg-custom-green justify-between p-4 items-center rounded-xl lg:cursor-pointer" onclick="openDetails(this)">
                            <h3 class="w-4/5 text-custom-white font-league text-lg/[0] font-medium">Pertemuan Ke-1</h3>
                            <svg id="openState" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>
                            <svg id="closeState" class="hidden" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                        </div>
                        <div class="flex flex-col gap-3 pt-6 pb-3.5 -z-20 bg-custom-green-hover -mt-3 rounded-b-xl hidden">
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-white text-base">Pilih Jadwal</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-white text-base">Baca Panduan</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                            </div>
                            <div class="flex flex-row px-4 justify-between items-center">
                                <p class="font-league font-light text-custom-white text-base">Selesaikan Quiz</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                    </div>
    
                        <div class="flex flex-col">
                            <div class="flex flex-row h-[50px] bg-custom-disabled-dark justify-between p-4 items-center rounded-xl" onclick="//openDetails(this)">
                                <h3 class="w-4/5 text-custom-grey font-league text-lg/[0] font-medium">Pertemuan Ke-</h3>
                                <svg id="openState" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>
                                <svg id="closeState" class="hidden" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#646464" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                            </div>
                            <div class="flex flex-col gap-3 pt-6 pb-3.5 -z-20 bg-custom-disabled-dark -mt-3 rounded-b-xl hidden">
                                <div class="flex flex-row px-4 justify-between items-center">
                                    <p class="font-league font-light text-custom-grey text-base">Baca Panduan</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="flex flex-row px-4 justify-between items-center">
                                    <p class="font-league font-light text-custom-grey text-base">Selesaikan Quiz</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                </div>
                            </div>
                        </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row h-[50px] bg-custom-white-hover border border-custom-green justify-between p-4 items-center rounded-xl lg:cursor-pointer" onclick="openDetails(this)">
                                    <h3 class="w-4/5 text-custom-green font-league text-lg/[0] font-medium">Pertemuan Ke-</h3>
                                    <svg id="closeState" class="hidden" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>
                                    <svg id="openState" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </div>
                                <div class="flex flex-col gap-3 pt-6 pb-3.5 -z-20 bg-custom-white-hover border border-custom-green -mt-3 rounded-b-xl">
                                    <div class="flex flex-row px-4 justify-between items-center">
                                        <p class="font-league font-light text-custom-dark text-base">Baca Panduan</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#24596A" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="flex flex-row px-4 justify-between items-center">
                                        <p class="font-league font-light text-custom-dark text-base">Selesaikan Quiz</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><path d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></g></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex flex-row h-[50px] bg-custom-green justify-between p-4 items-center rounded-xl lg:cursor-pointer" onclick="openDetails(this)">
                                    <h3 class="w-4/5 text-custom-white font-league text-lg/[0] font-medium">Pertemuan Ke-</h3>
                                    <svg id="openState" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>
                                    <svg id="closeState" class="hidden" xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                </div>
                                <div class="flex flex-col gap-3 pt-6 pb-3.5 -z-20 bg-custom-green-hover -mt-3 rounded-b-xl hidden">
                                    <div class="flex flex-row px-4 justify-between items-center">
                                        <p class="font-league font-light text-custom-white text-base">Baca Panduan</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                    </div>
                                    <div class="flex flex-row px-4 justify-between items-center">
                                        <p class="font-league font-light text-custom-white text-base">Selesaikan Quiz</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#EBF0F2" fill-rule="evenodd" d="M12 22c-4.714 0-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12s0-7.071 1.464-8.536C4.93 2 7.286 2 12 2c4.714 0 7.071 0 8.535 1.464C22 4.93 22 7.286 22 12c0 4.714 0 7.071-1.465 8.535C19.072 22 16.714 22 12 22m4.03-13.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l4.47-4.47a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                            </div>
            </div>
        </div>
    </div>

    <div class="hidden lg:hidden flex flex-col lg:grid lg:grid-cols-2 lg:items-center justify-center gap-6 fixed top-0 left-0 font-league w-full h-full bg-custom-dark/70 text-custom-white z-40 pt-12 lg:pt-0 px-6 lg:px-16" id="contact-other-party">
        {{-- Close Button --}}
        <button type="button" id="close-modal-button" class="fixed top-7 right-6"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#EBF0F2" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
        {{-- Contact Instructor --}}
        <a href="#">
            <div class="lg:w-full bg-cover bg-center rounded-xl border-2 border-custom-secondary" style="background-image: url('img/.jpg')">
                <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                    <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Instruktur Anda</h2>
                    <p class="font-light text-base/tight lg:text-xl/tight text-center">Anda punya pertanyaan tentang kursus yang anda ikuti?</p>
                </div>
            </div>
        </a>
        {{-- Contact Driving School Admin --}}
        <a href="#">
            <div class="lg:w-full bg-cover bg-center rounded-xl border-2 border-custom-secondary" style="background-image: url('img/.jpg')">
                <div class="flex flex-col gap-2 w-full h-72 justify-center items-center rounded-xl px-6 pt-2 lg:pt-0 bg-custom-dark/75 lg:px-20 lg:hover:bg-custom-dark-low duration-300">
                    <h2 class="font-semibold text-2xl/snug lg:text-4xl/snug">Hubungi Admin Kursus</h2>
                    <p class="font-light text-base/tight lg:text-xl/tight text-center">Anda ingin bertanya tentang administrasi kursus anda?</p>
                </div>
            </div>
        </a>
    </div>

    @include('partials.footer')

    <script>
        function openDetails(clickedDiv) {
            const openState = clickedDiv.querySelector('#openState');
            const closeState = clickedDiv.querySelector('#closeState');
            const detailsDiv = clickedDiv.nextElementSibling;

            openState.style.display = openState.style.display === 'none' ? 'block' : 'none';
            closeState.style.display = closeState.style.display === 'block' ? 'none' : 'block';

            openState.classList.toggle('hidden');
            closeState.classList.toggle('hidden');
            detailsDiv.classList.toggle('hidden');
        }

        const contactOtherPartyButton = document.getElementById('button-open-contact-party');
        const hiddenModal = document.getElementById('contact-other-party');
        const closeContactOtherPartyButton = document.getElementById('close-modal-button');

        contactOtherPartyButton.addEventListener('click', () => {
            hiddenModal.classList.remove('hidden', 'lg:hidden');
        })
        closeContactOtherPartyButton.addEventListener('click', () => {
            hiddenModal.classList.add('hidden', 'lg:hidden');
        })

        document.querySelector('.back-nav-icon').addEventListener('click', function(event) {
            event.preventDefault(); 
            history.back();
        });
    </script>
@endsection