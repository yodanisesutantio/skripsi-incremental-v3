@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Greetings --}}
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">Riwayat Kursus</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Berikut adalah daftar kelas kursus yang pernah anda ikuti</p>

    @if ()
        
    @else
        
    @endif

    @include('partials.footer')
@endsection