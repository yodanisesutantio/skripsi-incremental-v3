@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Kelas Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Pilih salah satu kelas untuk anda kelola!</p>

    @if ($activeEnrolledStudent->isEmpty())
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai kursus)</p>
    @else
        {{-- Class List --}}
        <div class="flex lg:grid flex-col lg:grid-cols-2 gap-6 mt-8 lg:mt-10 mb-7 lg:mb-14">
            @foreach ($activeEnrolledStudent as $activeStudent)
            <div class="w-full bg-custom-white-hover rounded-xl overflow-hidden drop-shadow-lg">
                <div class="flex flex-row gap-3">
                    @if ($activeStudent->instructor->hash_for_profile_picture)
                    <img src="{{ asset('storage/profile_pictures/' . $activeStudent->instructor->hash_for_profile_picture) }}" alt="Instructor Profile Picture" class="w-16 lg:w-20 h-16 lg:h-20 rounded-full object-cover object-center">
                    @else
                    <img src="{{ asset('img/blank-profile.webp') }}" alt="Blank Instructor Profile Picture" class="w-16 lg:w-20 h-16 lg:h-20 rounded-full object-cover object-center">
                    @endif

                    <div class="flex flex-col">
                        <h2 class="font-encode tracking-tight font-semibold text-lg/tight text-custom-dark">{{ $activeStudent->instructor->fullname }}</h2>
                        <p class="font-league font-medium text-base text-custom-grey">Instruktur</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection