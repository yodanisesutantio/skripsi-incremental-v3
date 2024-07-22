@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col px-5 my-8">
        <p class="text-custom-grey font-league font-medium text-xl lg:text-2xl">Hi, {{ auth()->user()->fullname }}</p>
        <h1 class="text-custom-dark font-league font-semibold text-2xl lg:text-4xl">Belum ada kursus berlangsung</h1>
    </div>

    {{-- Ongoing Course, Hidden if there are no active course --}}
    <div class="flex flex-col px-5 mb-8 lg:mb-11">
        <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus mendatang)</p>
    </div>

    {{-- Schedule Interface --}}
    <div class="flex flex-col px-5 mb-8 lg:mb-11">
        <h2 class="text-custom-dark font-league font-semibold text-2xl lg:text-3xl">Jadwal Kursus</h2>
        <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus mendatang)</p>
    </div>

    @include('partials.footer')
@endsection