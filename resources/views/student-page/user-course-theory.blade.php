@extends('layouts.relative')

@section('content')
    <div class="flex flex-col w-full h-full">
        <style>
            .swiper-pagination-bullet-active {
                background: #24596A;
            }
        </style>

        {{-- Course Theory Content --}}
        <div class="swiper w-full h-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide select-none">
                    {{-- Mobile Cover Slide --}}
                    <div class="w-full h-dvh lg:hidden bg-cover bg-center" style="background-image: url('{{ asset("img/cover/{$content['title-image-mobile']}") }}')">
                        <div class="relative flex flex-col justify-between w-full h-full bg-custom-dark/45 p-6">
                            <div class="w-full h-full flex flex-col items-center justify-center">
                                <div class="px-3 py-1 bg-custom-dark w-fit rounded-md">
                                    <p class="font-league text-lg/snug text-custom-white">Pertemuan {{ $meeting_number }}</p>
                                </div>
                                <h1 class="mt-3 font-encode font-extrabold text-center text-custom-white text-4xl/snug">{{ $content['title'] }}</h1>
                            </div>

                            {{-- Start Button --}}
                            <button type="button" id="jump-to-next-slide-mobile" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-white text-center text-custom-dark font-semibold lg:order-2">Mulai Belajar</button>
                        </div>
                    </div>

                    {{-- Desktop Cover Slide --}}
                    <div class="w-full h-dvh hidden lg:block bg-cover bg-center" style="background-image: url('{{ asset("img/cover/{$content['title-image-desktop']}") }}')">
                        <div class="relative flex flex-col justify-center w-full h-full bg-custom-dark/45 p-6">
                            <div class="w-full h-full flex flex-col items-center justify-center">
                                <div class="px-4 py-2 bg-custom-dark w-fit rounded-md">
                                    <p class="font-league text-2xl/snug text-custom-white">Pertemuan {{ $meeting_number }}</p>
                                </div>
                                <h1 class="mt-3 font-encode font-extrabold text-center text-custom-white text-5xl/snug">{{ $content['title'] }}</h1>

                                {{-- Start Button --}}
                                <button type="button" id="jump-to-next-slide-desktop" class="mt-8 px-12 py-3 rounded-lg lg:rounded-lg bg-custom-white hover:bg-custom-white-hover text-xl/snug text-center text-custom-dark font-semibold lg:order-2 duration-300">Mulai Belajar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($content['slides'] as $slide)
                    <div class="swiper-slide pt-4 lg:-mt-8 select-none overflow-y-auto lg:overflow-hidden">
                        <div class="flex flex-col lg:flex-row items-center lg:justify-between gap-2 lg:gap-16 w-full py-2 px-5 lg:px-20 lg:py-11 h-auto lg:h-dvh">
                            <img src="{{ asset("img/theory-image/{$slide['image']}") }}" alt="Theory Image" class="w-full lg:w-1/2 h-52 lg:h-auto mb-3 lg:mb-0 object-cover object-center flex-shrink-0 rounded-md shadow-lg lg:order-2">
                            <div class="flex flex-col gap-2 lg:gap-4 lg:justify-center w-full h-full lg:order-2 lg:overflow-y-auto pb-24 lg:pb-0">
                                <p class="font-league text-lg/snug lg:text-xl/snug text-custom-dark font-normal">{!! $slide['content'] !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Left and Right Button --}}
        <div class="hidden fixed bottom-0 flex-row flex-shrink-0 w-full px-3 pt-6 lg:pt-5 pb-4 items-center justify-between bg-custom-white select-none z-30" id="nav-wrapper">
            {{-- Left Button --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="left-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 5l-6 7l6 7"/></svg>

            {{-- Swiper Pagination Divs --}}
            <div class="swiper-pagination h-8"></div>

            {{-- Right Button --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="right-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5l6 7l-6 7"/></svg>

            {{-- Done Reading Button, Only shown when student arrived at last slide --}}
            <form action="{{ url('/user-course/theory/' . $enrollment['id'] . '/' . $meeting_number) }}" id="done-reading" class="hidden" method="POST">
                @csrf
                <button type="submit" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg font-league bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Selesai</button>
            </form>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

        // Swiper
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,
            autoHeight: true,

            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },

            navigation: {
                prevEl: '.left-button',
                nextEl: '.right-button',
            },

            on: {
                slideChange: function () {
                    // Check if the first slide is active
                    if (this.isBeginning) {
                        $('#nav-wrapper').addClass('hidden'); // Hide the nav-wrapper
                        $('#nav-wrapper').removeClass('flex'); // Hide the nav-wrapper
                    } else {
                        $('#nav-wrapper').removeClass('hidden'); // Show the nav-wrapper if not on the first slide
                        $('#nav-wrapper').addClass('flex'); // Show the nav-wrapper if not on the first slide
                    }

                    // Check if the last slide is active
                    if (this.isEnd) {
                        $('#done-reading').removeClass('hidden'); // Unhide the submit button
                        $('.right-button').addClass('hidden'); // Hide the Next / Right button
                        $('.swiper-pagination').addClass('hidden'); // Hide the Pagination Element
                    } else {
                        $('#done-reading').addClass('hidden'); // Hide the submit button if not on the last slide
                        $('.right-button').removeClass('hidden'); // Unhide the Next / Right button
                        $('.swiper-pagination').removeClass('hidden'); // Hide the Pagination Element
                    }
                }
            }
        });

        // Jump to the next slide when the button is clicked
        $('#jump-to-next-slide-mobile, #jump-to-next-slide-desktop').on('click', function () {
            swiper.slideNext(); // Move to the next slide
        });
    </script>
@endsection