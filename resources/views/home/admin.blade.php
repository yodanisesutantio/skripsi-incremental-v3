@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Greetings Element --}}
    <div class="flex flex-col my-8">
        <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight">Hi, {{ auth()->user()->fullname }}</p>
        <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Belum ada kursus berlangsung</h1>
    </div>

    {{-- Ongoing Course, Hidden if there are no active course --}}
    <div class="flex flex-col mb-8 lg:mb-11">
        <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus mendatang)</p>
    </div>

    {{-- Schedule Interface --}}
    <div class="flex flex-col mb-8 lg:mb-11">
        <h1 class="mb-8 text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl/tight">Jadwal Kursus</h1>
        <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Tidak ada kursus mendatang)</p>
    </div>

    @include('partials.footer')
@endsection