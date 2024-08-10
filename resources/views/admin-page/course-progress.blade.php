@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="sticky z-20 top-0 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1">
            <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">{{ $enrollment->course->course_name }}</h1>
            <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Instruktur : {{ $enrollment->instructor->fullname }}</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3">
        <div class="py-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl lg:text-4xl/snug text-custom-dark font-encode tracking-tight font-semibold">{{ $enrollment->course->course_name }}</h1>
                <p class="text-custom-grey text-base/tight font-league font-medium lg:text-xl">Instruktur : {{ $enrollment->instructor->fullname }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">

        </div>
    </div>

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection