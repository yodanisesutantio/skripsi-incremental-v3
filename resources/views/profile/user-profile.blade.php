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

        
    </div>

    <div class="mt-4">
        @include('partials.footer')
    </div>
@endsection