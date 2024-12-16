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

        <div class="lg:col-span-2 lg:mt-10 lg:px-24">
            <form action="{{ url('/user-confirm/schedule/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" method="post" id="confirmScheduleForm" class="px-6 pb-20 lg:pb-0 -mt-2 lg:-mt-8">
            @csrf

            @foreach ($meetings as $meetingData)
                {{-- Personal Information Data --}}
                <h2 class="font-encode font-semibold lg:mx-0 mt-5 lg:mt-8 text-xl/tight lg:text-[26px]/tight text-custom-dark">Pertemuan {{ $loop->iteration }}</h2>
                <div class="flex flex-col lg:grid lg:grid-cols-2 gap-3 lg:gap-8 mt-3 lg:mt-5 pb-5 lg:pb-8 {{ $loop->last ? '' : 'border-b-2 border-custom-dark' }}">            
                    {{-- Meeting Date --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Tanggal Kursus</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ \Carbon\Carbon::parse($meetingData['date'])->translatedFormat('l, d F Y') }}</h3>
                        <input type="hidden" name="meetings[{{ $loop->iteration }}][date]" value="{{ $meetingData['date'] }}">
                    </div>
                    {{-- Meeting Time --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Sesi Kursus</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $meetingData['time'] }} WIB</h3>
                        <input type="hidden" name="meetings[{{ $loop->iteration }}][start_time]" value="{{ explode(' - ', $meetingData['time'])[0] }}">
                        <input type="hidden" name="meetings[{{ $loop->iteration }}][end_time]" value="{{ explode(' - ', $meetingData['time'])[1] }}">
                    </div>
                </div>
            @endforeach

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-6 py-3 rounded-lg lg:rounded-lg bg-custom-green text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Simpan Jadwal</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#confirmScheduleForm').submit();
        });

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