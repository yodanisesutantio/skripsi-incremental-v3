@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="mt-3 mb-6 lg:mt-20 lg:mb-16 lg:px-40 flex flex-row lg:items-center h-fit">
        <form action="{{ route('search.results') }}" method="GET" class="w-full h-fit mx-auto font-league">
            <label for="default-search" class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">Pencarian</label>
            <div class="relative mt-3 lg:mt-5">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
                </div>
                <input type="search" name="searchQuery" id="search" class="block w-full p-4 ps-12 text-base/tight placeholder:text-base/tight lg:text-xl/snug lg:placeholder:text-xl/snug text-custom-grey border border-custom-grey rounded-lg bg-custom-white-hover focus:ring-custom-dark" placeholder="Coba 'Manual' atau 'Surabaya'" required />
            </div>
        </form>

        {{-- The Query History --}}
    </div>
@endsection