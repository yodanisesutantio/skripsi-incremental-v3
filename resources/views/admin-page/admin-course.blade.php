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
    <div class="flex flex-col gap-1 mt-3">
        <h1 class="font-encode font-semibold text-center text-2xl lg:text-4xl text-custom-dark">{{ auth()->user()->fullname }}</h1>
        @if (auth()->user()->description)
        <p class="font-league font-normal text-center text-lg/tight lg:text-xl/tight text-custom-grey">{{ auth()->user()->description }}</p>    
        @else
        <p class="font-league font-normal text-center text-custom-grey/40 text-lg/tight lg:text-xl/tight">Belum ada deskripsi</p>    
        @endif
    </div>

    @include('partials.footer')
@endsection