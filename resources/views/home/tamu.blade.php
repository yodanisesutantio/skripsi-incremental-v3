@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col px-5 my-8 lg:my-12">
        <p class="text-custom-grey font-league font-medium text-xl lg:text-2xl">Halo, Selamat Datang di KEMUDI</p>
        <h1 class="text-custom-dark font-league font-semibold text-2xl lg:text-4xl">Ingin belajar mengemudi hari ini?</h1>
    </div>

    {{-- Ongoing Course, Hidden if there are no active course --}}
    <div class="flex flex-col px-5 mb-8 lg:mb-11">
        <h2 class="text-custom-dark font-league font-semibold text-2xl lg:text-3xl">Kursus Berlangsung</h2>

        <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus berlangsung)</p>
    </div>

    {{-- Class Offered Recommendation --}}
    <div class="flex flex-row px-5 justify-between items-center mb-4">
        <h2 class="text-custom-dark font-league font-semibold text-2xl lg:text-3xl">Rekomendasi Kelas</h2>
        <a href="" class="text-custom-green font-medium text-base lg:text-lg hover:underline">Lihat Semua</a>
    </div>
    {{-- Class Offered Wrapper --}}
    <div class="relative flex items-center mb-5 px-5 lg:mb-11 cursor-pointer" id="classOfferedContainer">
        <p class="font-league w-full text-center lg:text-xl my-3 lg:my-6">(Belum ada kelas kursus)</p>
    </div>

    {{-- Course Recommendation --}}
    <div class="flex flex-row px-5 justify-between items-center mt-8 mb-4">
        <h2 class="text-custom-dark font-league font-semibold text-2xl lg:text-3xl">Kursus Terdekat</h2>
        <a href="" class="text-custom-green font-medium text-base lg:text-lg hover:underline">Lihat Semua</a>
    </div>
    {{-- Course Recommendation Wrapper --}}
    <div class="relative flex items-center mb-4 lg:mb-8" id="courseRecommendationContainer">
        <p class="font-league w-full text-center lg:text-xl my-3 lg:my-6">(Belum ada penyedia kursus)</p>
    </div>

    {{-- Recommend to do a Search --}}
    <div class="flex px-5 my-8 lg:justify-center">
        <div class="flex flex-col gap-4 bg-custom-grey/10 border border-custom-disabled-light p-4 lg:p-9 lg:w-[33rem] rounded-xl items-center">
            <div class="flex flex-col gap-1">
                <h2 class="text-custom-dark font-league font-semibold text-center text-2xl lg:text-3xl">Tidak Menemukan yang Anda Cari?</h2>
                <p class="text-custom-grey font-league font-medium text-center text-base/snug lg:text-xl px-3">Coba cari Nama Kursus atau Daerah yang terdekat dari anda</p>
            </div>
            <a href="" class="relative font-league lg:text-lg/none text-custom-secondary lg:-mb-1 px-8 lg:px-14 py-2.5 border border-custom-secondary text-center rounded-full hover:bg-custom-grey/20 duration-300">
                <div class="flex flex-row justify-center items-center gap-4 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><g fill="none" stroke="#495D64" stroke-width="2"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
                    <p class="mt-[1.2px] lg:mt-[1.5px] text-lg/snug">Coba Fitur Pencarian</p>
                </div>
            </a>
        </div>
    </div>

    @include('partials.footer')
@endsection