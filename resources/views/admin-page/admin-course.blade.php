@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Profile Information --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:px-60">
        <div class="profile-header flex flex-col lg:flex-row lg:gap-8 w-full items-center lg:items-start lg:justify-center">
            @if (auth()->user()->hash_for_profile_picture)
                <img src="{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}" alt="profile-picture" class="w-24 lg:w-32 h-24 lg:h-32 object-cover rounded-full">
            @else
                <img src="{{ asset('img/blank-profile.webp') }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 rounded-full">
            @endif
            <div class="flex flex-col lg:gap-2">
                <div class="flex flex-col gap-1">
                    <h1 class="font-encode tracking-tight font-semibold text-center lg:-mt-1 lg:text-left text-2xl lg:text-3xl text-custom-dark">{{ auth()->user()->fullname }}</h1>
                    @if (auth()->user()->description)
                    <p class="font-league font-normal text-center lg:text-left text-lg/tight lg:text-xl/tight text-custom-grey">{{ auth()->user()->description }}</p>    
                    @else
                    <i class="font-league font-normal text-center lg:text-left text-custom-grey/40 text-lg/tight lg:text-xl/tight">Belum ada deskripsi</i>    
                    @endif
                </div>
                
                {{-- For Mobile Screen --}}
                <div class="flex flex-row my-5 lg:hidden">
                    {{-- Course Price Range. For marketing purpose --}}
                    <div class="flex flex-col items-center justify-center w-1/2 border-r border-custom-grey px-2 py-1">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $minCoursePrice }} - {{ $maxCoursePrice }}</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey">Rentang Harga Kursus</p>
                    </div>
                    {{-- Course Length Average. For student consideration --}}
                    <div class="flex flex-col items-center justify-center w-1/2 px-2 py-1">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $averageCourseLength }}x</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey">Rata-Rata Pertemuan</p>
                    </div>
                </div>

                {{-- For Large Screen --}}
                <div class="lg:flex lg:flex-col lg:my-0 hidden">
                    {{-- Course Price Range. For marketing purpose --}}
                    <div id="coursePrice" class="flex flex-col lg:flex-row items-center justify-center lg:justify-start lg:w-80 lg:gap-2 border-r lg:border-r-0 border-custom-grey px-2 lg:px-0 py-1 lg:py-0">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $minCoursePrice }} - {{ $maxCoursePrice }}</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey">Rentang Harga Kursus</p>
                    </div>
                    {{-- Course Length Average. For student consideration --}}
                    <div id="courseLength" class="flex flex-col lg:flex-row items-center justify-center lg:justify-start lg:w-80 lg:gap-2 px-2 lg:px-0 py-1 lg:py-0">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark">{{ $averageCourseLength }}x</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey">Rata-Rata Pertemuan</p>
                    </div>
                </div>
                
                <a href="admin-course/active-student-list" class="lg:mt-2 lg:w-fit"><div class="hidden lg:block lg:px-5 py-3 lg:py-2 gap-2 rounded-lg cursor-pointer border border-custom-green lg:hover:bg-custom-grey/15 text-center text-custom-green font-semibold duration-500">Lihat Daftar Siswa Aktif</div></a>
            </div>
        </div>
    </div>

    {{-- Kinda CTA --}}
    <a href="admin-course/active-student-list" class="lg:hidden"><div class="w-full py-3 gap-2 rounded-lg cursor-pointer border border-custom-green text-center lg:text-lg text-custom-green font-semibold duration-500">Lihat Daftar Siswa Aktif</div></a>

    {{-- Tabs --}}
    <div class="overflow-x-auto mt-8" style="scrollbar-width: none;">
        <ul class="flex flex-row gap-5 justify-between px-1 lg:px-60 font-league text-custom-dark text-lg font-semibold text-center">
            {{-- All Course --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 border-b-2 text-custom-green border-custom-green opacity-100 duration-300" id="allCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="0"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm10 0a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zM4 15a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm10 0a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z"/></svg>
                    <p>Semua</p>
                </button>
            </li>
            {{-- Manual Course --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 opacity-40 duration-300" id="manualCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="1"><g fill="none" stroke="#040B0D" stroke-width="2"><path stroke-linecap="round" d="M8 9v6m4-6v6m-4-3h5c.932 0 1.398 0 1.765-.152a2 2 0 0 0 1.083-1.083C16 10.398 16 9.932 16 9"/><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10Z"/></g></svg>
                    <p>Manual</p>
                </button>
            </li>
            {{-- Matic Course --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 opacity-40 duration-300" id="maticCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="2"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 4h6a5 5 0 0 1 5 5v6a5 5 0 0 1-5 5H7z"/></svg>
                    <p>Matic</p>
                </button>
            </li>
            {{-- Quick Course --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 opacity-40 duration-300" id="quickCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="3"><path fill="none" stroke="#040B0D" stroke-width="2" d="m5.67 9.914l3.062-4.143c1.979-2.678 2.969-4.017 3.892-3.734c.923.283.923 1.925.923 5.21v.31c0 1.185 0 1.777.379 2.148l.02.02c.387.363 1.003.363 2.236.363c2.22 0 3.329 0 3.704.673l.018.034c.354.683-.289 1.553-1.574 3.29l-3.062 4.144c-1.98 2.678-2.969 4.017-3.892 3.734c-.923-.283-.923-1.925-.923-5.21v-.31c0-1.185 0-1.777-.379-2.148l-.02-.02c-.387-.363-1.003-.363-2.236-.363c-2.22 0-3.329 0-3.703-.673a1.084 1.084 0 0 1-.019-.034c-.354-.683.289-1.552 1.574-3.29Z"/></svg>
                    <p>Kilat</p>
                </button>
            </li>
        </ul>
    </div>

    <div class="swiper my-6">
        <div class="swiper-wrapper">
            {{-- All Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Message --}}
                @if ($course->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Belum Ada Kursus yang Ditambahkan)</p>
                @endif

                {{-- All Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($course as $allCourse)
                        @if ($allCourse['course_thumbnail'])
                            {{-- Course Thumbnail --}}
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $allCourse['course_thumbnail']) }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/80 to-custom-dark/25 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $allCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white">{{ $allCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($allCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @else
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/80 to-custom-dark/25 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $allCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white line-clamp-2">{{ $allCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($allCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @endif     
                    @endforeach
                </div>
            </div>
            {{-- Manual Transmission Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Message --}}
                @if ($courseManual->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus untuk Mobil Manual)</p>
                @endif

                {{-- Manual Transmission Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($courseManual as $manualCourse)
                        @if ($manualCourse['course_thumbnail'])
                            {{-- Course Thumbnail --}}
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $manualCourse['course_thumbnail']) }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $manualCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white">{{ $manualCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($manualCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @else
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $manualCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white line-clamp-2">{{ $manualCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($manualCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @endif     
                    @endforeach
                </div>
            </div>
            {{-- Matic Transmission Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Message --}}
                @if ($courseMatic->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus untuk Mobil Matic)</p>
                @endif

                {{-- Matic Transmission Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($courseMatic as $maticCourse)
                        @if ($maticCourse['course_thumbnail'])
                            {{-- Course Thumbnail --}}
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $maticCourse['course_thumbnail']) }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $maticCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white">{{ $maticCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($maticCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @else
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $maticCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white line-clamp-2">{{ $maticCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($maticCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @endif     
                    @endforeach
                </div>
            </div>
            {{-- Quick Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Message --}}
                @if ($courseQuick->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus Kilat)</p>
                @endif

                {{-- Quick Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6">
                    @foreach ($courseQuick as $quickCourse)
                        @if ($quickCourse['course_thumbnail'])
                            {{-- Course Thumbnail --}}
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $quickCourse['course_thumbnail']) }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $quickCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white">{{ $quickCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($quickCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @else
                            <a href="#" class="w-full h-44 rounded-xl overflow-hidden drop-shadow-lg bg-cover bg-center" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}')">
                                <div class="flex flex-col justify-between lg:hover:bg-custom-dark/35 bg-gradient-to-r from-custom-dark/90 to-custom-dark/35 w-full h-full py-5 pl-5 pr-16 duration-300">
                                    <div class="flex flex-col">
                                        {{-- Course Length --}}
                                        <p class="text-base/tight font-normal text-custom-white">{{ $quickCourse['course_length'] }} Pertemuan</p>
                                        <h3 class="text-2xl/tight font-semibold text-custom-white line-clamp-2">{{ $quickCourse['course_name'] }}</h3>
                                    </div>
                                    <h4 class="text-lg/tight font-medium text-custom-white">Rp. {{ number_format($quickCourse['course_price'], 0, ',', '.') }},-</h4>
                                </div>
                            </a>
                        @endif     
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            autoHeight: true,

            navigation: {
                prevEl: '',
                nextEl: '',
            },

            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex;
                    const buttons = ['#allCourseButton', '#manualCourseButton', '#maticCourseButton', '#quickCourseButton'];

                    // Change stroke color based on the current slide
                    $('.tab-icon path').each(function() {
                        const index = $(this).closest('button').find('.tab-icon').data('index');
                        const strokeColor = index === currentIndex ? '#24596A' : '#040B0D';
                        $(this).attr('stroke', strokeColor);
                    });

                    // For Mobile Tabs
                    buttons.forEach((button, index) => {
                        if (index === currentIndex) {
                            $(button).addClass('border-b-2 text-custom-green border-custom-green opacity-100');
                            $(button).removeClass('opacity-40');
                        } else {
                            $(button).removeClass('border-b-2 text-custom-green border-custom-green opacity-100');
                            $(button).addClass('opacity-40');
                        }
                    });
                },
                init: function () {
                    this.update();
                }
            }
        });

        $('#allCourseButton').on('click', function() {
            swiper.slideTo(0);
        });
        $('#manualCourseButton').on('click', function() {
            swiper.slideTo(1);
        });
        $('#maticCourseButton').on('click', function() {
            swiper.slideTo(2);
        });
        $('#quickCourseButton').on('click', function() {
            swiper.slideTo(3);
        });

        let currentIndex = 0;
        const sections = ['#coursePrice', '#courseLength'];
        const toggleDuration = 5500; // Duration to show each section in milliseconds

        function toggleSections() {
            $(sections[currentIndex]).fadeOut(500, function() {
                currentIndex = (currentIndex + 1) % sections.length; // Cycle through sections
                $(sections[currentIndex]).fadeIn(500);
            });
        }

        $(sections[0]).show(); // Show the first section initially
        $(sections[1]).hide(); // Show the first section initially
        setInterval(toggleSections, toggleDuration); // Toggle sections every 3 seconds
    </script>
@endsection