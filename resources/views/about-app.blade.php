@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Section Header --}}
    <h1 class="text-custom-dark font-encode font-semibold text-center text-3xl lg:text-4xl my-5 lg:mt-10">Tentang Aplikasi</h1>
    <div class="flex flex-col lg:flex-row lg:items-center my-3 gap-3 lg:gap-6">
        {{-- Website Mark --}}
        <div class="flex flex-col items-center lg:my-3 lg:p-12">
            <div class="w-64 lg:w-80 lg:h-72 flex flex-col justify-center lg:bg-custom-dark p-3 lg:p-8">
                {{-- Black BG and White Logo Variant when in Large Views --}}
                <img src="img/Logo-Putih.svg" alt="" class="w-full hidden lg:block">
                {{-- Black Logo Variant when in Mobile Views --}}
                <img src="img/Logo-Hitam.svg" alt="" class="w-full lg:hidden">
            </div>
        </div>
        <div class="flex flex-col gap-5 lg:p-12">
            <p class="font-league text-lg/snug text-custom-dark">Dalam lima tahun terakhir, jumlah sekolah mengemudi terus meningkat, namun belum ada aplikasi tunggal yang mengumpulkan semua penyedia kursus ini, sehingga siswa dapat dengan mudah mengetahui tempat untuk mendaftar di sekolah mengemudi.</p>

            <p class="font-league text-lg/snug text-custom-dark">KEMUDI adalah aplikasi yang dikembangkan oleh <a href="https://yodanisesutantio.github.io/portfolio/" target="_blank" class="font-bold text-custom-green underline">Yodanis E. Sutantio</a>, merupakan platform untuk pengajar dan penyedia kursus mengemudi. Tujuan aplikasi ini adalah untuk menjembatani komunikasi antara siswa, instruktur, dan pihak admin sekolah mengemudi, sehingga mereka dapat lebih fokus pada proses pembelajaran.</p>

            <p class="font-league text-lg/snug text-custom-dark">Aplikasi ini juga dikembangkan sebagai tugas akhir kuliah, sebagai tantangan untuk membuktikan bahwa Yodanis memiliki keterampilan tidak hanya dalam merancang aplikasi, tetapi juga dalam mengembangkannya.</p>
        </div>
    </div>

    @include('partials.footer')
@endsection