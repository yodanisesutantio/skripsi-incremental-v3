@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-3 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Ajukan Jadwal Kursus Baru</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ubah jadwal <span class="font-semibold">{{ $enrollment->course->course_name }}</span> untuk siswa <span class="font-semibold">{{ $enrollment->student_real_name }}</span></p>
        </div>

        {{-- Tabs --}}
        <div class="overflow-x-auto px-6 lg:px-[4.25rem]" style="scrollbar-width: none;">
            <ul class="flex flex-row lg:grid lg:grid-cols-7 items-center gap-3 font-league text-custom-dark text-base/tight font-semibold text-center">
                @foreach ($upcomingSchedule as $i => $nextCourseSchedule)
                    {{-- if this is the last item, add an extra padding right --}}
                    @if ($nextCourseSchedule === $upcomingSchedule->last())
                    <li class="flex-shrink-0 pr-6">
                    @else
                    <li class="flex-shrink-0">
                    @endif
                        {{-- If this is the first item, make it in active state --}}
                        @if ($nextCourseSchedule === $upcomingSchedule->first())
                        <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-white-hover border-2 border-custom-dark rounded-lg duration-300 meeting_numberButton" data-index="{{ $i }}">
                            <div class="flex flex-col line-clamp-1">
                                <p class="font-normal">Pertemuan</p>
                                {{-- Meetings Number --}}
                                <h3 class="text-lg/tight">{{ $nextCourseSchedule->meeting_number }}</h3>
                            </div>

                            {{-- Horizontal Lines --}}
                            <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>

                        @else
                        <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-disabled-light/40 rounded-lg duration-300 meeting_numberButton" data-index="{{ $i }}">
                            <div class="flex flex-col line-clamp-1">
                                <p class="font-normal">Pertemuan</p>
                                {{-- Meetings Number --}}
                                <h3 class="text-lg/tight">{{ $nextCourseSchedule->meeting_number }}</h3>
                            </div>

                            {{-- Horizontal Lines --}}
                            <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5 lg:px-8"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>
                        @endif

                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Ajukan Jadwal Kursus Baru</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ubah jadwal <span class="font-semibold">{{ $enrollment->course->course_name }}</span> untuk siswa <span class="font-semibold">{{ $enrollment->student_real_name }}</span></p>
            </div>

            {{-- Tabs --}}
            <ul class="lg:grid lg:grid-cols-3 items-center gap-3 font-league text-custom-dark text-base/tight font-semibold text-center px-6">
                @foreach ($upcomingSchedule as $i => $nextCourseSchedule)
                    <li class="flex-shrink-0">
                        {{-- If this is the first item, make it in active state --}}
                        @if ($nextCourseSchedule === $upcomingSchedule->first())
                        <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-white-hover border-2 border-custom-dark rounded-lg duration-300 meeting_numberButton" data-index="{{ $i }}">
                            <div class="flex flex-col line-clamp-1">
                                <p class="font-normal">Pertemuan</p>
                                {{-- Meetings Number --}}
                                <h3 class="text-lg/tight">{{ $nextCourseSchedule->meeting_number }}</h3>
                            </div>

                            {{-- Horizontal Lines --}}
                            <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>

                        @else
                        <button class="flex flex-col grow w-[5.5rem] lg:w-full justify-center items-center p-2 lg:pt-3 lg:pb-2 lg:px-3 bg-custom-disabled-light/40 rounded-lg duration-300 meeting_numberButton" data-index="{{ $i }}">
                            <div class="flex flex-col line-clamp-1">
                                <p class="font-normal">Pertemuan</p>
                                {{-- Meetings Number --}}
                                <h3 class="text-lg/tight">{{ $nextCourseSchedule->meeting_number }}</h3>
                            </div>

                            {{-- Horizontal Lines --}}
                            <div class="mt-2.5 lg:mt-3 mb-0.5 w-full px-3.5"><div class="border-b-2 border-custom-dark"></div></div>
                        </button>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Schedule Forms --}}
        <div class="lg:col-span-2 lg:mt-10 lg:px-24">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($upcomingSchedule as $i => $nextCourseSchedule)
                        <div class="swiper-slide flex flex-col gap-5 overflow-y-auto px-6 pb-24 lg:pb-0">
                            <h4 class="font-semibold font-encode text-xl/tight lg:text-2xl/tight text-custom-dark hidden lg:block">Pertemuan {{ $nextCourseSchedule->meeting_number }}</h4>
                        </div>
                    @endforeach
    
                </div>
            </div>

            {{-- Button Groups for Desktop View --}}
            <div class="lg:flex flex-row w-full lg:mt-5 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                <a href="{{ url('/admin-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
                <button type="button" class="next-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Lanjut</button>
                <button type="submit" id="submitNewSchedule" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 hidden">Ajukan</button>
            </div>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/admin-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="button" class="next-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Lanjut</button>
        <button type="submit" id="submitNewSchedule" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 hidden">Ajukan</button>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,
            autoHeight: true,
            navigation: {
                prevEl: '',
                nextEl: '.next-button',
            },

            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex;
                    const totalSlides = swiper.slides.length;
                    const buttons = $('.meeting_numberButton');

                    // Toggle button visibility based on slide index
                    if (currentIndex === totalSlides - 1) {
                        $('.submit-button').removeClass('hidden'); // Show submit button
                        $('.next-button').addClass('hidden'); // Hide next button
                    } else {
                        $('.submit-button').addClass('hidden'); // Hide submit button
                        $('.next-button').removeClass('hidden'); // Show next button
                    }

                    buttons.each(function() {
                        const buttonIndex = $(this).data('index');
                        if (buttonIndex == currentIndex) {
                            $(this).removeClass('bg-custom-disabled-light/40');
                            $(this).addClass('bg-custom-white-hover border-2 border-custom-dark');
                        } else {
                            $(this).removeClass('bg-custom-white-hover border-2 border-custom-dark');
                            $(this).addClass('bg-custom-disabled-light/40');
                        }
                    });
                },
                init: function () {
                    this.update();
                }
            }
        });

        $(document).on('click', '.meeting_numberButton', function() {
            const index = $(this).data('index');
            swiper.slideTo(index);
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