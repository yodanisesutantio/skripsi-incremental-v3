@extends('layouts.relative')

@section('content')
    <div class="flex flex-col w-full h-full">
        <style>
            .swiper-pagination-bullet-active {
                background: #24596A;
            }
        </style>
        
        {{-- Mobile Forms Header --}}
        <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden drop-shadow">
            <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="flex flex-row items-center gap-5 px-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#040B0D" fill-rule="evenodd" d="M10.53 5.47a.75.75 0 0 1 0 1.06l-4.72 4.72H20a.75.75 0 0 1 0 1.5H5.81l4.72 4.72a.75.75 0 1 1-1.06 1.06l-6-6a.75.75 0 0 1 0-1.06l6-6a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                <p class="text-custom-dark text-lg lg:text-2xl font-encode font-semibold mb-0.5">Panduan Kursus</p>
            </a>
        </div>

        {{-- Course Theory Content --}}
        <div class="swiper w-full h-full mt-3">
            <div class="swiper-wrapper">
                @foreach ($content['slides'] as $slide)
                    <div class="swiper-slide select-none overflow-y-auto lg:overflow-hidden">
                        <div class="flex flex-col lg:flex-row items-center lg:items-center lg:justify-between gap-2 lg:gap-16 w-full py-2 px-5 lg:px-20 lg:py-11 h-auto lg:h-full">
                            <img src="{{ asset("img/theory-image/{$slide['image']}") }}" alt="Theory Image" class="w-full lg:w-1/2 h-52 lg:h-auto mb-3 lg:mb-0 object-cover object-center flex-shrink-0 rounded-md shadow-lg lg:order-2">
                            <div class="flex flex-col gap-2 lg:gap-4 lg:justify-start w-full h-full lg:order-2 lg:overflow-y-auto">
                                <p class="font-league text-lg/snug lg:text-xl/snug text-custom-dark font-normal">{{ $slide['content'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Left and Right Button --}}
        <div class="fixed bottom-0 flex flex-row flex-shrink-0 w-full px-3 pt-6 lg:pt-5 pb-4 items-center justify-between bg-custom-white select-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="left-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 5l-6 7l6 7"/></svg>
            <div class="swiper-pagination h-8"></div>
            <svg xmlns="http://www.w3.org/2000/svg" class="right-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5l6 7l-6 7"/></svg>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
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
        });
    </script>
@endsection