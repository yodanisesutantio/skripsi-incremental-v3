@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="flex flex-col items-center w-full">
        {{-- Profile Information --}}
        <div class="profile-header flex flex-col lg:flex-row gap-3 lg:gap-10 w-full items-center lg:justify-center">
            @if (auth()->user()->hash_for_profile_picture)
                <img src="{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 object-cover rounded-full">
            @else
                <img src="{{ asset('img/blank-profile.webp') }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 rounded-full">
            @endif
            <div class="text-content text-center lg:text-left flex flex-col gap-1 lg:gap-2 w-full lg:w-[24rem] px-12 lg:px-0">
                @if (auth()->user()->age === NULL && auth()->user()->description === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}</h1>
                    <i class="font-league text-custom-grey/40 text-lg/tight lg:text-2xl/tight">Belum ada deskripsi</i>
                @elseif (auth()->user()->age === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}</h1>
                    <p class="font-league text-custom-grey text-lg/tight lg:text-2xl/tight">{{ auth()->user()->description }}</p>
                @elseif (auth()->user()->description === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}, {{ auth()->user()->age }}</h1>
                    <i class="font-league text-custom-grey/40 text-lg/tight lg:text-2xl/tight">Belum ada deskripsi</i>
                @else
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}, {{ auth()->user()->age }}</h1>
                    <p class="font-league text-custom-grey text-lg/tight lg:text-2xl/tight">{{ auth()->user()->description }}</p>
                @endif
            </div>
        </div>

        {{-- Menu --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 grid-rows-3 lg:grid-rows-1 w-full mt-6 lg:mt-14 mb-3 lg:mb-8 text-custom-white gap-3">
            {{-- Edit Profile --}}
            <a href="{{ url('/instructor-profile/edit') }}" class="row-span-2 lg:row-auto lg:w-full lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/edit-profile.webp') }}')">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Ubah Profil</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Perbarui informasi personal anda</p>
                </div>
            </a>
            {{-- About App --}}
            <a href="{{ url('/about-app') }}" class="w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/about-app.webp') }}');">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Tentang Aplikasi</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Informasi tentang kami</p>
                </div>
            </a>
            {{-- Contact Us --}}
            <a href="{{ url('/contact-us') }}" class="w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/contact-us.webp') }}');">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Hubungi Kami</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Laporkan masalah</p>
                </div>
            </a>
            {{-- Instructor Certificate --}}
            <a href="{{ url('/instructor-certificate') }}" class="col-span-2 lg:col-auto w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/add-driving-school.webp') }}');">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Sertifikat Instruktur</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Pastikan sertifikat instruktur anda sah dan aktif</p>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-4">
        @include('partials.footer')
    </div>
@endsection