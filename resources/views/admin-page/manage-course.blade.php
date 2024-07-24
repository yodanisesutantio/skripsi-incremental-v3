@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Kelas Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Kelola kelas anda agar lebih menarik</p>

    <a href="admin-manage-course/create"> <div class="w-fit pl-3.5 pr-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+ Tambah Kelas</div></a>

    {{-- Class List --}}
    <div class="flex flex-col gap-6 mt-8 mb-7 lg:mb-8">
        @if ($course->isEmpty())
            <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Anda belum mempunyai kursus)</p>
        @else
            @foreach ($course as $myCourse)
                <div class="w-full rounded-xl overflow-hidden drop-shadow-lg">
                    @if ($myCourse['course_thumbnail'])
                        <img src="{{ asset($myCourse['course_thumbnail']) }}" alt="Course Thumbnail" class="">
                    @else
                        {{-- Course Thumbnail --}}
                        <div class="relative w-full h-36 bg-cover bg-center" style="background-image: url('img/BG-Class-4.webp')">
                            <div class="absolute top-3 right-3 flex flex-row gap-2">
                                {{-- Edit --}}
                                <a href="" class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-width="1.5" d="m14.36 4.079l.927-.927a3.932 3.932 0 0 1 5.561 5.561l-.927.927m-5.56-5.561s.115 1.97 1.853 3.707C17.952 9.524 19.92 9.64 19.92 9.64m-5.56-5.561l-8.522 8.52c-.577.578-.866.867-1.114 1.185a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.094 3.281m17.6-10.162L11.4 18.16c-.577.577-.866.866-1.184 1.114a6.554 6.554 0 0 1-1.211.749c-.364.173-.751.302-1.526.56l-3.281 1.094m0 0l-.802.268a1.06 1.06 0 0 1-1.342-1.342l.268-.802m1.876 1.876l-1.876-1.876"/></svg></a>
                                {{-- Delete --}}
                                <a href="" class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></a>
                            </div>
                        </div>

                        <div class="flex flex-col p-3 bg-custom-white-hover font-league text-custom-dark">
                            <div class="flex flex-row justify-between">
                                {{-- Course Length --}}
                                <p class="font-medium text-base/tight text-custom-grey/80">{{ $myCourse['course_length'] }} Pertemuan</p>
                                {{-- Course Quota --}}
                                <p class="font-medium text-base/tight text-custom-grey/80"><span class="text-custom-dark font-semibold">{{ $myCourse->enrollments()->count() }}</span> / {{ $myCourse['course_quota'] }} Siswa</p>
                            </div>
                            {{-- Course Name --}}
                            <h2 class="mt-1.5 mb-5 font-encode font-semibold text-xl/tight">{{ $myCourse['course_name'] }}</h2>
                            <div class="flex flex-row justify-between">
                                {{-- Course Availability Toggle --}}
                                @if ($myCourse['course_availability'] === 1)
                                    <div class="flex flex-row items-center gap-2.5">
                                        <button type="submit" class="relative flex items-center deactivate-course">
                                            <div class="flex-shrink-0 w-12 h-4 bg-custom-green rounded-full"></div>
                                            <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg right-0"></div>
                                        </button>
                                        <form action="/admin-deactivate-course" method="post" class="mb-1 hidden">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $myCourse['id'] }}">
                                            <input type="hidden" name="course_availability" value="0">
                                        </form>
                                        <p class="text-base/tight mt-1">Aktif</p>
                                    </div>
                                @else
                                    <div class="flex flex-row items-center gap-2.5">
                                        <button type="submit" class="relative flex items-center activate-course">
                                            <div class="flex-shrink-0 w-12 h-4 bg-custom-disabled-light/50 rounded-full"></div>
                                            <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg left-0"></div>
                                        </button>
                                        <form action="/admin-activate-course" method="post" class="mb-1 hidden">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $myCourse['id'] }}">
                                            <input type="hidden" name="course_availability" value="1">
                                        </form>
                                        <p class="text-base/tight mt-1">Nonaktif</p>
                                    </div>
                                @endif
                                {{-- Course Price --}}
                                <h3 class="font-semibold text-right text-lg/tight">Rp. {{ number_format($myCourse['course_price'], 0, ',', '.') }},-</h3>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @include('partials.footer')

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Deactivate Course
        $('.deactivate-course').on('click', function() {
            $(this).closest('div').find('form[action="/admin-deactivate-course"]').submit();
        });

        // Activate Course
        $('.activate-course').on('click', function() {
            $(this).closest('div').find('form[action="/admin-activate-course"]').submit();
        });
    </script>
@endsection