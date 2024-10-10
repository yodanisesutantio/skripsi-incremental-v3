@extends('layouts.relative')

@include('partials.navbar')

@section('content')
    <div class="px-6 lg:px-[4.25rem]">
        <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl my-5 lg:mt-10 mb-8">Hasil Pencarian untuk "{{ $searchQuery }}"</h1>
    </div>

    {{-- Related Course Search Results --}}
    @if ($courseResults->isNotEmpty())
        <div class="px-6 lg:px-[4.25rem]">
            <h2 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-2xl my-4 lg:mt-10 mb-3">Kelas Kursus Terkait</h2>
        </div>

        {{-- Class Offered Content --}}
        <div class="relative swiper swiperRecommendation h-fit mb-5 lg:mb-11 px-6 lg:px-[4.25rem] select-none">
            <div class="swiper-wrapper px-6 lg:px-[4.25rem]">
                @foreach ($courseResults as $searchedCourses)
                    {{-- I've added conditional padding-right since our layout is fucked, this is the only way to make it right --}}
                    <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-[8.5rem]' : '' }}" style="width: auto !important;">
                    {{-- Check if the course has an uploaded course_thumbnail. If non existed, use a default course_thumbnail --}}
                    @if ($searchedCourses->course_thumbnail)
                        <div class="bg-center bg-cover w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $searchedCourses['course_thumbnail']) }}');">
                    @else
                        <div class="bg-center bg-cover w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                    @endif
                            {{-- Redirect to Course Details Page --}}
                            <a href="{{ url('/course/' . $searchedCourses->course_name . '/' . $searchedCourses->id) }}" class="relative flex flex-col flex-shrink-0 justify-end w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                {{-- Course Information --}}
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $searchedCourses->course_length }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $searchedCourses->course_name }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light mt-0.5 lg:mt-2">{{ $searchedCourses->admin->fullname }}</p>
                                </div>
                                {{-- Course price Label --}}
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 py-2 lg:px-4 lg:py-2.5 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($searchedCourses->course_price, 0, ',', '.') }},-</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Prev Slide --}}
            <div class="prevRecommendation absolute top-1/2 left-0 -mt-6 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer -translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
            </div>
            {{-- Next Slide --}}
            <div class="nextRecommendation absolute top-1/2 right-0 -mt-6 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
            </div>
        </div>
    @endif

    @if ($drivingSchoolResults->isNotEmpty())
        <div class="px-6 lg:px-[4.25rem]">
            <h2 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-2xl my-4 lg:mt-10 mb-3">Penyedia Kursus Terkait</h2>
        </div>

        {{-- DrivingSchool Recommendation Wrapper --}}
        <div class="relative swiper swiperSchool h-fit mb-5 lg:mb-11 select-none">
            <div class="swiper-wrapper px-6 lg:px-[4.25rem]">
                {{-- DrivingSchool Recommendation Card --}}
                @foreach ($drivingSchoolResults as $searchedDrivingSchool)
                    {{-- I've added conditional padding-right since our layout is fucked, this is the only way to make it right --}}
                    <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-[8.5rem]' : '' }}" style="width: auto !important;">
                        <div class="flex flex-col gap-3 bg-custom-white-hover border border-custom-disabled-light p-4 rounded-xl items-center">
                        {{-- Check if the drivingSchool has an uploaded profile picture. If non existed, use blank-profile --}}
                        @if ($searchedDrivingSchool['hash_for_profile_picture'])
                            <div class="border border-custom-disabled-dark bg-cover bg-center w-14 lg:w-20 h-14 lg:h-20 rounded-full" style="background-image: url('{{ asset('storage/profile_pictures/' . $searchedDrivingSchool['hash_for_profile_picture']) }}')"></div>                        
                        @else
                            <div class="border border-custom-disabled-dark bg-cover bg-center w-14 lg:w-20 h-14 lg:h-20 rounded-full" style="background-image: url('{{ asset('img/blank-profile.webp') }}')"></div>
                        @endif
                            {{-- Driving School Information --}}
                            <div class="flex flex-col items-center w-60 lg:w-[20.5rem] h-16 lg:h-fit overflow-hidden mb-1 px-3">
                                <p class="font-encode font-semibold text-xl/snug text-center line-clamp-2 lg:line-clamp-1">{{ $searchedDrivingSchool['fullname'] }}</p>
                            </div>
                            {{-- Redirect to Driving School Course Page --}}
                            <a href="{{ url('/course/' . $searchedDrivingSchool['username']) }}" class="w-full font-league lg:text-lg/none text-custom-secondary px-3 py-2 border border-custom-secondary text-center rounded-lg hover:bg-custom-grey/20 duration-300">
                                <div class="flex flex-row justify-center items-center gap-2">
                                    <p class="mt-[2px] lg:mt-[1.5px] lg:text-lg">Lihat Kursus</p>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path fill="none" stroke="#495D64" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5l6 7l-6 7"/></svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Prev Slide --}}
            <div class="absolute top-1/2 left-0 -mt-8 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer -translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="prevSchool">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
            </div>
            {{-- Next Slide --}}
            <div class="absolute top-1/2 right-0 -mt-8 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer translate-x-1/2 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="nextSchool">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
            </div>
        </div>
    @endif

    <div class="px-6 lg:px-[4.25rem]">
        @include('partials.footer')
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Initialize Course Class Recommendation Swiper
        const swiperRecommendation = new Swiper('.swiperRecommendation', {
            slidesPerView: "auto",
            spaceBetween: window.innerWidth >= 1024 ? 20 : 15,

            // No Navigation Button
            navigation: {
                prevEl: '.prevRecommendation',
                nextEl: '.nextRecommendation',
            },
        });

        // Initialize Driving School Recommendation Swiper
        const swiperSchool = new Swiper('.swiperSchool', {
            slidesPerView: "auto",
            spaceBetween: window.innerWidth >= 1024 ? 20 : 15,

            // No Navigation Button
            navigation: {
                prevEl: '#prevSchool',
                nextEl: '#nextSchool',
            },
        });

        // Show navigation buttons on hover for Course Class Recommendation
        $('.swiperRecommendation').hover(function() {
            $('.nextRecommendation, .prevRecommendation').removeClass('hidden');
            $('.nextRecommendation, .prevRecommendation').addClass('flex');
        }, function() {
            $('.nextRecommendation, .prevRecommendation').removeClass('flex');
            $('.nextRecommendation, .prevRecommendation').addClass('hidden');
        });

        // Show navigation buttons on hover for Driving School Recommendation
        $('.swiperSchool').hover(function() {
            $('#nextSchool, #prevSchool').removeClass('hidden');
            $('#nextSchool, #prevSchool').addClass('flex');
        }, function() {
            $('#nextSchool, #prevSchool').removeClass('flex');
            $('#nextSchool, #prevSchool').addClass('hidden');
        });
    </script>
@endsection