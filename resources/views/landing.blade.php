@extends('layouts.no-padding')

@section('content')
    {{-- Website Mark --}}
    <img src="img/Logo-Putih.svg" alt="" class="hidden lg:inline lg:fixed top-6 left-6 w-1/5">

    <div class="flex flex-col lg:flex-row justify-end lg:justify-end bg-cover h-screen w-screen bg-center" style="background-image: url('img/BG-Image-Landing.webp')">
        {{-- Content with a Blurred Background --}}
        <div class="flex flex-col w-screen lg:w-1/2 h-50 bg-center bg-[#040B0D99] lg:bg-gradient-to-l lg:from-custom-dark lg:to-[#040B0D01] border-0 lg:gap-4 justify-end lg:justify-center rounded-2xl lg:rounded-5xl backdrop-blur">
            <div class="flex flex-col px-8 pt-6 lg:px-20 lg:py-8 gap-3">
                <h1 class="text-center text-[26px]/snug lg:text-4xl/snug text-custom-white font-encode font-semibold">Tingkatkan Keahlian Mengemudi Anda Bersama Kami</h1>
                <p class="text-center text-base lg:text-xl text-custom-white font-league font-light">Jalanan tidak dapat diprediksi. Jadilah pengemudi yang bertanggung jawab, belajar dengan instruktur berpengalaman.</p>
            </div>
            
            {{-- Button Group --}}
            <div class="px-6 lg:px-20 py-5 lg:py-0 flex flex-col lg:flex-row gap-3 lg:gap-5">
                <a href="/login" class="w-full py-3 lg:py-3 rounded-lg lg:rounded-xl bg-custom-white text-center lg:text-lg text-custom-dark font-semibold lg:order-2 hover:bg-custom-white-hover duration-500">Login / Daftar</a>
                <a href="/tamu" class="w-full py-3 lg:py-3 rounded-lg lg:rounded-xl bg-custom-dark text-center lg:text-lg text-custom-white font-semibold lg:order-1 hover:bg-custom-dark-hover duration-500">Lewati Dulu</a>
            </div>
        </div>
    </div>
@endsection