@extends('layouts.main')

@include('partials.navbar')

@section('content')
    {{-- Profile Information --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:px-60">
        <div class="profile-header flex flex-col lg:flex-row lg:gap-8 w-full items-center lg:items-start lg:justify-center">
            {{-- Admin Profile Picture --}}
            @if (auth()->user()->hash_for_profile_picture)
                <img src="{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}" alt="profile-picture" class="w-24 lg:w-32 h-24 lg:h-32 object-cover rounded-full">

            {{-- Admin Blank Profile Picture --}}
            @else
                <img src="{{ asset('img/blank-profile.webp') }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 rounded-full">
            @endif

            <div class="flex flex-col lg:gap-2">
                <div class="flex flex-col gap-1">
                    {{-- Admin Fullname --}}
                    <h1 class="font-encode tracking-tight font-semibold text-center lg:-mt-1 lg:text-left text-2xl/tight lg:text-4xl text-custom-dark">{{ auth()->user()->fullname }}</h1>

                    {{-- Show Admin Open and Close Hours --}}
                    <p class="font-league font-normal text-center lg:text-left text-lg/tight lg:text-2xl/tight text-custom-grey">Jam Buka : {{ $formattedOpenHours }} - {{ $formattedCloseHours }} WIB</p>
                </div>
                
                {{-- For Mobile Screen --}}
                <div class="flex flex-row my-5 lg:hidden">
                    {{-- Course Price Range. For marketing purpose --}}
                    <div class="flex flex-col items-center justify-center w-1/2 border-r border-custom-grey px-2 py-1">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark whitespace-nowrap">{{ $minCoursePrice }} - {{ $maxCoursePrice }}</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey whitespace-nowrap">Rentang Harga Kursus</p>
                    </div>
                    {{-- Course Length Average. For student consideration --}}
                    <div class="flex flex-col items-center justify-center w-1/2 px-2 py-1">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark whitespace-nowrap">{{ $averageCourseLength }}x</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey whitespace-nowrap">Rata-Rata Pertemuan</p>
                    </div>
                </div>

                {{-- For Large Screen --}}
                <div class="lg:flex lg:flex-col lg:my-0 hidden">
                    {{-- Course Price Range. For marketing purpose --}}
                    <div id="coursePrice" class="flex flex-col lg:flex-row items-center justify-center lg:justify-start lg:w-80 lg:gap-2 border-r lg:border-r-0 border-custom-grey px-2 lg:px-0 py-1 lg:py-0">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark whitespace-nowrap">{{ $minCoursePrice }} - {{ $maxCoursePrice }}</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey whitespace-nowrap">Rentang Harga Kursus</p>
                    </div>
                    {{-- Course Length Average. For student consideration --}}
                    <div id="courseLength" class="flex flex-col lg:flex-row items-center justify-center lg:justify-start lg:w-80 lg:gap-2 px-2 lg:px-0 py-1 lg:py-0">
                        <h2 class="font-league font-semibold text-[21px] text-center text-custom-dark whitespace-nowrap">{{ $averageCourseLength }}x</h2>
                        <p class="font-league font-normal text-[14px]/tight lg:text-[21px]/tight text-center text-custom-grey whitespace-nowrap">Rata-Rata Pertemuan</p>
                    </div>
                </div>
                
                {{-- CTA Button to redirect Admin to show all active student --}}
                <a href="admin-course/active-student-list" class="lg:mt-2 lg:w-fit"><div class="hidden lg:block lg:px-5 py-3 lg:py-2 gap-2 rounded-lg cursor-pointer border border-custom-green lg:hover:bg-custom-grey/15 text-center text-custom-green font-semibold duration-500">Lihat Daftar Siswa Aktif</div></a>
            </div>
        </div>
    </div>

    {{-- Kinda CTA --}}
    <a href="admin-course/active-student-list" class="lg:hidden"><div class="w-full py-3 gap-2 rounded-lg cursor-pointer border border-custom-green text-center lg:text-lg text-custom-green font-semibold duration-500">Lihat Daftar Siswa Aktif</div></a>

    {{-- Tabs --}}
    <div class="overflow-x-auto mt-8" style="scrollbar-width: none;">
        <ul class="flex flex-row gap-5 justify-between px-1 lg:px-60 font-league text-custom-dark text-lg font-semibold text-center">
            {{-- All Course Tab --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 border-b-2 text-custom-green border-custom-green opacity-100 duration-300" id="allCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="0"><path fill="none" stroke="#24596A" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm10 0a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zM4 15a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm10 0a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1z"/></svg>
                    <p>Semua</p>
                </button>
            </li>

            {{-- Manual Course Tab --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 opacity-40 duration-300" id="manualCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="1"><g fill="none" stroke="#040B0D" stroke-width="2"><path stroke-linecap="round" d="M8 9v6m4-6v6m-4-3h5c.932 0 1.398 0 1.765-.152a2 2 0 0 0 1.083-1.083C16 10.398 16 9.932 16 9"/><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10Z"/></g></svg>
                    <p>Manual</p>
                </button>
            </li>

            {{-- Matic Course Tab --}}
            <li class="rounded-lg duration-300">
                <button class="flex flex-col items-center gap-1 lg:hover:bg-custom-grey/25 py-1 lg:px-12 opacity-40 duration-300" id="maticCourseButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="tab-icon" data-index="2"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 4h6a5 5 0 0 1 5 5v6a5 5 0 0 1-5 5H7z"/></svg>
                    <p>Matic</p>
                </button>
            </li>

            {{-- Quick Course Tab --}}
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
                {{-- Empty Course Message --}}
                @if ($course->isEmpty())
                    <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Belum Ada Kursus yang Ditambahkan)</p>
                @endif

                {{-- All Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($course as $allCourse)
                    @if ($allCourse->course_thumbnail)
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $allCourse['course_thumbnail']) }}');">
                    @else
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                    @endif
                            {{-- Redirect to Course Details Page --}}
                            <a href="{{ url('/course/' . $allCourse->course_name . '/' . $allCourse->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-full h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                {{-- Course Information --}}
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $allCourse->course_length }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $allCourse->course_name }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $allCourse->admin->fullname }}</p>
                                </div>
                                {{-- Course price Label --}}
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($allCourse->course_price, 0, ',', '.') }},-</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Manual Transmission Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Course Message --}}
                @if ($courseManual->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus untuk Mobil Manual)</p>
                @endif

                {{-- Manual Transmission Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($courseManual as $manualCourse)
                    @if ($manualCourse->course_thumbnail)
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $manualCourse['course_thumbnail']) }}');">
                    @else
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                    @endif
                            {{-- Redirect to Course Details Page --}}
                            <a href="{{ url('/course/' . $manualCourse->course_name . '/' . $manualCourse->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-full h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                {{-- Course Information --}}
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $manualCourse->course_length }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $manualCourse->course_name }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $manualCourse->admin->fullname }}</p>
                                </div>
                                {{-- Course price Label --}}
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($manualCourse->course_price, 0, ',', '.') }},-</p>
                                </div>
                            </a>
                        </div>  
                    @endforeach
                </div>
            </div>

            {{-- Matic Transmission Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Course Message --}}
                @if ($courseMatic->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus untuk Mobil Matic)</p>
                @endif

                {{-- Matic Transmission Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-4">
                    @foreach ($courseMatic as $maticCourse)
                    @if ($maticCourse->course_thumbnail)
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $maticCourse['course_thumbnail']) }}');">
                    @else
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                    @endif
                            {{-- Redirect to Course Details Page --}}
                            <a href="{{ url('/course/' . $maticCourse->course_name . '/' . $maticCourse->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-full h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                {{-- Course Information --}}
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $maticCourse->course_length }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $maticCourse->course_name }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $maticCourse->admin->fullname }}</p>
                                </div>
                                {{-- Course price Label --}}
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($maticCourse->course_price, 0, ',', '.') }},-</p>
                                </div>
                            </a>
                        </div>  
                    @endforeach
                </div>
            </div>

            {{-- Quick Course Slide --}}
            <div class="swiper-slide font-league">
                {{-- Empty Course Message --}}
                @if ($courseQuick->isEmpty())
                <p class="font-league font-medium text-center text-base lg:text-xl px-6 my-20 lg:my-14">(Penyedia Kursus belum Menambahkan Kursus Kilat)</p>
                @endif

                {{-- Quick Course Displayed --}}
                <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6">
                    @foreach ($courseQuick as $quickCourse)
                    @if ($quickCourse->course_thumbnail)
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="
                        : url('{{ asset('storage/classOrCourse_thumbnail/' . $quickCourse['course_thumbnail']) }}');">
                    @else
                        <div class="bg-center bg-cover w-full h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                    @endif
                            {{-- Redirect to Course Details Page --}}
                            <a href="{{ url('/course/' . $quickCourse->course_name . '/' . $quickCourse->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-full h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                {{-- Course Information --}}
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $quickCourse->course_length }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $quickCourse->course_name }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $quickCourse->admin->fullname }}</p>
                                </div>
                                {{-- Course price Label --}}
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($quickCourse->course_price, 0, ',', '.') }},-</p>
                                </div>
                            </a>
                        </div>
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
        // Initialize Swipers
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false, // Swiper cant be looped
            spaceBetween: 40,
            autoHeight: true, // Make the swiper-slide auto resize

            // No Navigation Button
            navigation: {
                prevEl: '',
                nextEl: '',
            },

            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex; // Initialize swiper index
                    const buttons = ['#allCourseButton', '#manualCourseButton', '#maticCourseButton', '#quickCourseButton']; // Setup all the tabs

                    // Change the color of the icons based on the current slide
                    $('.tab-icon path').each(function() {
                        const index = $(this).closest('button').find('.tab-icon').data('index');
                        const strokeColor = index === currentIndex ? '#24596A' : '#040B0D';
                        $(this).attr('stroke', strokeColor);
                    });

                    // Change the active states, depend on which slide we currently are
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

        // When "Semua" tabs is clicked, slide to the first slide
        $('#allCourseButton').on('click', function() {
            swiper.slideTo(0);
        });
        // When "Manual" tabs is clicked, slide to the second slide
        $('#manualCourseButton').on('click', function() {
            swiper.slideTo(1);
        });
        // When "Matic" tabs is clicked, slide to the third slide
        $('#maticCourseButton').on('click', function() {
            swiper.slideTo(2);
        });
        // When "Kilat" tabs is clicked, slide to the Last slide
        $('#quickCourseButton').on('click', function() {
            swiper.slideTo(3);
        });

        // Change the course provider info, min max course_price and average course_Length
        let currentIndex = 0;
        const sections = ['#coursePrice', '#courseLength'];
        const toggleDuration = 5500; // Duration to show each section in milliseconds

        // Fade Out animation
        function toggleSections() {
            $(sections[currentIndex]).fadeOut(500, function() {
                currentIndex = (currentIndex + 1) % sections.length; // Cycle through sections
                // Fade in animation
                $(sections[currentIndex]).fadeIn(500);
            });
        }

        $(sections[0]).show(); // Show the first section initially
        $(sections[1]).hide(); // Hide the second section initially
        setInterval(toggleSections, toggleDuration); // Toggle sections every 5,5 seconds
    </script>
@endsection