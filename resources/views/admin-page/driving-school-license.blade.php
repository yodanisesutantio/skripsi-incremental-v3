@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Izin Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Berikut Daftar Izin Kursus Anda!</p>

    <div class="flex">
        <a href="admin-driving-school-license/create"><div class="w-fit px-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">Unggah Izin Baru</div></a>
    </div>

    {{-- @if ($course->isEmpty()) --}}
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai kursus)</p>
    {{-- @else --}}

    {{-- @endif --}}

    @include('partials.footer')
@endsection