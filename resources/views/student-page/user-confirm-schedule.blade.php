@extends('layouts.relative')

@section('content')
    {{-- Mobile View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Konfirmasi Jadwal Anda</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Berikut adalah jadwal kursus yang anda pilih</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop View Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Konfirmasi Jadwal Anda</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Berikut adalah jadwal kursus yang anda pilih</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:mt-7 lg:px-24">
            @foreach ($meetings as $meetingData)
                <div class="flex flex-col gap-5 lg:gap-8 my-3 mx-6 lg:mx-0 p-6 bg-custom-white-hover rounded-lg lg:rounded-xl">
                    {{-- Personal Information Data --}}
                    <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">Pertemuan {{ $loop->iteration }}</h2>
            
                    {{-- Meeting Date --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Tanggal Kursus</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ \Carbon\Carbon::parse($meetingData['date'])->translatedFormat('l, d F Y') }}</h3>
                    </div>
                    {{-- Meeting Time --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Sesi Kursus</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $meetingData['time'] }} WIB</h3>
                    </div>
                </div>                
            @endforeach
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });
    </script>
@endsection