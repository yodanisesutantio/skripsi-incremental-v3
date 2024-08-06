@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Profile Information --}}
    <div class="profile-header flex flex-col lg:flex-row gap-3 lg:gap-10 w-full items-center lg:justify-center">
        @if (auth()->user()->hash_for_profile_picture)
            <img src="{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}" alt="profile-picture" class="w-24 lg:w-32 h-20 lg:h-32 object-cover rounded-full">
        @else
            <img src="img/blank-profile.webp" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 rounded-full">
        @endif
    </div>
    
    {{-- Course Price Range. For marketing purpose --}}
    <div class="flex flex-col gap-1 mt-3">
        <h1 class="font-encode font-semibold text-center text-2xl lg:text-4xl text-custom-dark">{{ auth()->user()->fullname }}</h1>
        @if (auth()->user()->description)
        <p class="font-league font-normal text-center text-lg/tight lg:text-xl/tight text-custom-grey">{{ auth()->user()->description }}</p>    
        @else
        <p class="font-league font-normal text-center text-custom-grey/40 text-lg/tight lg:text-xl/tight">Belum ada deskripsi</p>    
        @endif
    </div>

    {{-- Course Length Average. For student consideration --}}
    <div class="flex flex-row w-full my-5">
        <div class="flex flex-col items-center justify-center border-r border-custom-grey px-2 py-1 w-1/2">
            <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $minCoursePrice }} - {{ $maxCoursePrice }}</h2>
            <p class="font-league font-normal text-[14px]/tight text-center text-custom-grey">Rentang Harga Kursus</p>
        </div>
        <div class="flex flex-col items-center justify-center px-2 py-1 w-1/2">
            <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $averageCourseLength }}x</h2>
            <p class="font-league font-normal text-[14px]/tight text-center text-custom-grey">Rata-Rata Pertemuan</p>
        </div>
    </div>

    {{-- Kinda CTA --}}
    <a href="admin-course/active-student-list"><div class="w-full py-3 rounded-lg cursor-pointer border border-custom-green lg:hover:bg-custom-grey/20 text-center lg:text-lg text-custom-green font-semibold duration-500">Lihat Daftar Siswa Aktif</div></a>

    @include('partials.footer')
@endsection