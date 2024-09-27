@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="mt-3 mb-6 lg:mt-6 lg:mb-16 lg:px-32 flex flex-row h-dvh">
        <form class="w-full mx-auto font-league">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
                </div>
                <input type="search" id="search" class="block w-full p-4 ps-12 text-base/tight placeholder:text-base/tight text-custom-grey border border-custom-grey rounded-lg bg-custom-white-hover focus:ring-custom-dark" placeholder="Coba 'Kursus Mobil Manual'" required />
            </div>
        </form>
    </div>
@endsection