@extends('layouts.relative')

@section('content')
    <div class="flex flex-col lg:flex-row">
        {{-- Back Button --}}
        <a href="/user-index" class="flex absolute top-8 left-5 bg-custom-dark-low rounded-full z-20 p-3 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4m0 0l6-6m-6 6l6 6"/></svg>
        </a>

        {{-- Class Image --}}
        @if ($classProperties->course_thumbnail)
            <img src="{{ asset('storage/classOrCourse_thumbnail/' . $classProperties->course_thumbnail) }}" alt="Class Thumbnail" class="h-[360px] object-cover w-screen lg:w-2/5 lg:h-screen">
        @else
            <img src="{{ asset('img/BG-Class-4.webp') }}" alt="Class Thumbnail" class="h-[360px] object-cover w-screen lg:w-2/5 lg:h-screen">
        @endif
        
        {{-- Content --}}
        <div class="lg:flex lg:flex-col lg:w-3/5 lg:h-screen lg:overflow-y-auto">
            {{-- Class Main Info --}}
            <div class="flex flex-col px-6 mt-5 lg:px-8 lg:mt-8 gap-1">
                <h1 class="font-encode text-3xl lg:text-4xl font-semibold tracking-tight">{{ $classProperties->course_name }}</h1>
                <p class="text-custom-grey text-lg lg:text-xl font-league">oleh <span class="font-semibold text-custom-dark"><a href="/driving-school-profile">{{ $classProperties->admin->fullname }}</a></span></p>
                <p class="font-league text-custom-dark font-bold text-2xl lg:text-3xl lg:mt-2">Rp. {{ number_format($classProperties->course_price, 0, '', '.') }},-</p>
            </div>

            {{-- Class Features --}}
            <div class="flex flex-col px-6 mt-6 lg:px-8 lg:mt-8 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl font-semibold text-custom-dark">Fitur Kelas</h2>

                {{-- Feature Wrapper --}}
                <div class="grid grid-cols-2 grid-rows-2 lg:flex lg:flex-row gap-3">
                    {{-- Transmission Type --}}
                    <div class="relative flex flex-col w-full h-36 justify-end p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-0 right-0 transform translate-x-3 -translate-y-3 opacity-25" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="2"><path stroke-linecap="round" d="M8 9v6m4-6v6m-4-3h5c.932 0 1.398 0 1.765-.152a2 2 0 0 0 1.083-1.083C16 10.398 16 9.932 16 9"/><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10Z"/></g></svg>
                        <p class="font-league font-normal text-base/tight lg:text-xl/tight">Transmisi : <span class="font-semibold font-encode text-lg/tight lg:text-xl/tight">{{ $classProperties->car_type === 'Both' ? 'Manual & Matic' : $classProperties->car_type }}</span></p>
                    </div>

                    {{-- Course Length & Duration --}}
                    <div class="relative flex flex-col w-full h-36 justify-end p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-0 right-0 transform translate-x-3 -translate-y-3 opacity-25" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/></g></svg>
                        <p class="font-league font-normal text-base/tight lg:text-xl/tight">Lama Kursus : <span class="font-semibold font-encode text-lg/tight lg:text-xl/tight">{{ $classProperties->course_length }}x{{ $classProperties->course_duration }} Menit</span></p>
                    </div>

                    {{-- Can Use Own Car --}}
                    <div class="col-span-2 relative flex flex-col w-full h-36 justify-end p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2 overflow-hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute top-0 right-0 transform translate-x-3 -translate-y-3 opacity-25" width="72" height="72" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="2"><path stroke-linecap="round" d="M8 13h8m-8 0v5c0 1.886 0 2.828.586 3.414C9.172 22 10.114 22 12 22c1.886 0 2.828 0 3.414-.586C16 20.828 16 19.886 16 18v-5m-8 0a7.459 7.459 0 0 1-5.618-5.472L2 6m14 7c1.71 0 3.15 1.28 3.35 2.98L20 21.5"/><circle cx="12" cy="6" r="4"/></g></svg>
                        <p class="font-league font-normal text-base/tight lg:text-xl/tight">Bisa pakai mobil sendiri?</p>
                        <p class="font-semibold font-encode text-lg/tight lg:text-xl/tight">{{ $classProperties->can_use_own_car === 1 ? 'Ya' : 'Tidak' }}</p>
                    </div>
                </div>
            </div>

            {{-- Class Description --}}
            <div class="flex flex-col px-6 mt-6 lg:px-8 lg:mt-12 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl font-semibold text-custom-dark">Deskripsi Kelas</h2>
                <p id="content" class="font-league text-lg/snug lg:text-xl/tight line-clamp-3 text-custom-dark mb-1">{{ $classProperties->course_description }}</p>
                <button type="button" id="readMoreButton" class="font-league text-custom-green w-fit text-lg font-bold hidden hover:underline">Baca Selengkapnya</button>
            </div>  

            {{-- Darken Overlay --}}
            <div id="modal-overlay" class="hidden fixed top-0 left-0 lg:right-0 w-full h-full bg-custom-dark opacity-75"></div>

            {{-- Read More Popup --}}
            <div id="modal" class="hidden fixed bottom-0 h-4/5 py-4 z-40 bg-custom-white rounded-tl-xl rounded-tr-xl">
                <div class="flex flex-row sticky px-6 bg-custom-white justify-between items-center pt-1 pb-4">
                    <h2 class="font-league text-[27px]/[2rem] lg:text-3xl font-semibold text-custom-dark ">Deskripsi Kelas</h2>
                    <button type="button" id="closeButton" class="text-custom-green text-lg font-bold hover:underline">Tutup</button>
                </div>
                <div class="overflow-y-auto h-[32rem] px-6 pb-4">
                    <p id="contentOnModals" class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">{{ $classProperties->course_description }}</p>
                </div>
            </div>

            {{-- Instructor Section --}}
            <div class="flex flex-col mt-6 lg:px-3 lg:mt-12 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl px-6 font-semibold text-custom-dark">Instruktur Kami</h2>
                
                {{-- Available Instructor Content --}}
                <div class="relative swiper swiperInstructor w-full h-fit mb-5 lg:mb-11 px-6 lg:px-7 select-none">
                    <div class="swiper-wrapper px-6 lg:px-7">
                        @foreach ($instructorArray as $availableInstructor)
                            {{-- Instructor Card --}}
                            <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-16' : '' }}" style="width: auto !important;">
                                <div class="flex flex-col w-40 lg:w-72 flex-shrink-0 lg:flex-grow items-center p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl gap-3">
                                    @if ($availableInstructor->hash_for_profile_picture)
                                        <img src="{{ asset('storage/profile_pictures/' . $availableInstructor->instructor->hash_for_profile_picture) }}" alt="Instructor Profile Picture" class="w-16 h-16 flex-shrink-0 mt-2 rounded-full bg-cover bg-center bg-no-repeat">
                                    @else
                                        <img src="{{ asset('img/blank-profile.webp') }}" alt="Instructor Profile Picture" class="w-16 h-16 flex-shrink-0 mt-2 rounded-full bg-cover bg-center bg-no-repeat">
                                    @endif
    
                                    {{-- Instructor Information --}}
                                    <div class="flex flex-col w-full">
                                        <p class="font-league font-semibold text-xl/snug lg:text-2xl/snug text-center truncate">{{ $availableInstructor->instructor->fullname }}</p>
                                        <i class="font-league text-custom-grey text-base/none lg:text-lg/none text-center truncate">{{ $availableInstructor->instructor->age }} tahun</i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Prev Slide --}}
                    <div class="absolute top-1/2 left-0 -mt-8 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer transform -translate-x-16 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="prevInstructor">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
                    </div>
                    {{-- Next Slide --}}
                    <div class="absolute top-1/2 right-0 -mt-8 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer transform translate-x-16 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="nextInstructor">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Similar Class Recommendation --}}
            <div class="flex flex-col mt-3 lg:px-3 lg:mt-4 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl px-6 font-semibold text-custom-dark">Kelas Serupa</h2>

                {{-- Available Class Recommendation Content --}}
                <div class="relative swiper swiperRecommendation w-full h-fit mb-5 lg:mb-5 px-6 lg:px-7 select-none">
                    <div class="swiper-wrapper px-6 lg:px-7">
                        @foreach ($offered as $recommendedClass)
                            {{-- Class Card --}}
                            <div class="swiper-slide {{ $loop->last ? 'pr-12 lg:pr-16' : '' }}" style="width: auto !important;">
                            {{-- Similar Class Card --}}
                            @if ($recommendedClass->course_thumbnail)
                                <div class="bg-center bg-cover rounded-xl" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $recommendedClass->course_thumbnail) }}');">
                            @else
                                <div class="bg-center bg-cover rounded-xl" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}');">
                            @endif
                                    <a href="{{ url('/course/' . $recommendedClass->course_name . '/' . $recommendedClass->id) }}" class="relative flex flex-col flex-shrink-0 w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] justify-end gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                        <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                            <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $recommendedClass->course_length }} Pertemuan</p>
                                            <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $recommendedClass->course_name }}</h3>
                                            <p class="text-sm/tight lg:text-lg/tight font-light">{{ $recommendedClass->admin->fullname }}</p>
                                        </div>
                                        <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 pt-2 pb-1 lg:px-4 lg:pt-3 lg:pb-2 rounded-bl-xl rounded-tr-xl">
                                            <p class="text-md lg:text-xl lg:font-medium">Rp. {{ number_format($recommendedClass->course_price, 0, ',', '.') }},-</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Prev Slide --}}
                    <div class="absolute top-1/2 left-0 -mt-8 ml-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer transform -translate-x-16 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="prevClass">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
                    </div>
                    {{-- Next Slide --}}
                    <div class="absolute top-1/2 right-0 -mt-8 mr-[4.25rem] hidden justify-center items-center w-16 h-16 flex-shrink-0 bg-custom-white-hover rounded-full cursor-pointer transform translate-x-16 lg:shadow lg:hover:shadow-lg lg:hover:bg-custom-white z-40 duration-300" id="nextClass">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="30" height="30" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Button for Large Screen --}}
            <div class="lg:flex sticky bottom-0 z-20 px-6 py-4 items-center bg-custom-white hidden">
                <a href="{{ Auth::check() ? url('/course/registration-form/' . $classProperties->course_name . '/' . $classProperties->id) : url('/login') }}" class="flex justify-center items-center bg-custom-green hover:bg-custom-green-hover text-custom-white py-3 w-full font-league lg:text-lg font-medium rounded-md duration-300">Daftar Kelas</a>
            </div>
        </div>
    </div>

    {{-- Button for Mobile --}}
    <div class="flex sticky bottom-0 z-20 px-6 py-4 items-center bg-custom-white lg:hidden">
        <a href="{{ Auth::check() ? url('/course/registration-form/' . $classProperties->course_name . '/' . $classProperties->id) : url('/login') }}" class="flex justify-center items-center bg-custom-green text-custom-white py-3 w-full font-league lg:text-lg font-medium rounded-md">Daftar Kelas</a>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const $contentEl = $('#content');
        const $modal = $('#modal');
        const $readMoreButton = $('#readMoreButton');
        const $closeButton = $('#closeButton');
        const $modalOverlay = $('#modal-overlay');

        function checkContentHeight() {
            const contentHeight = $contentEl.outerHeight();
            const lineHeight = parseFloat($contentEl.css('line-height')); // Get line height
            const maxHeight = lineHeight * 3; // Calculate max height for 3 lines

            if ($contentEl[0].scrollHeight > maxHeight) {
                $readMoreButton.removeClass('hidden');
            } else {
                $readMoreButton.addClass('hidden');
            }
        }
        checkContentHeight();
        $(window).on('resize', checkContentHeight);

        $readMoreButton.on('click', function() {
            $modal.removeClass('hidden');
            $modalOverlay.removeClass('hidden');
        });

        $closeButton.on('click', function() {
            $modal.addClass('hidden');
            $modalOverlay.addClass('hidden');
        });

        // Initialize Course Class Recommendation Swiper
        const swiper = new Swiper('.swiperInstructor', {
            slidesPerView: "auto",
            spaceBetween: 15,

            // No Navigation Button
            navigation: {
                prevEl: '#prevInstructor',
                nextEl: '#nextInstructor',
            },
        });

        // Show navigation buttons on hover for Course Instructor
        $('.swiper').hover(function() {
            $('#nextInstructor, #prevInstructor').removeClass('hidden');
            $('#nextInstructor, #prevInstructor').addClass('flex');
        }, function() {
            $('#nextInstructor, #prevInstructor').removeClass('flex');
            $('#nextInstructor, #prevInstructor').addClass('hidden');
        });

        // Initialize Course Class Recommendation Swiper
        const swiperRecommendation = new Swiper('.swiperRecommendation', {
            slidesPerView: "auto",
            spaceBetween: 15,

            // No Navigation Button
            navigation: {
                prevEl: '#prevClass',
                nextEl: '#nextClass',
            },
        });

        // Show navigation buttons on hover for Course Instructor
        $('.swiperRecommendation').hover(function() {
            $('#nextClass, #prevClass').removeClass('hidden');
            $('#nextClass, #prevClass').addClass('flex');
        }, function() {
            $('#nextClass, #prevClass').removeClass('flex');
            $('#nextClass, #prevClass').addClass('hidden');
        });
    </script>
@endsection