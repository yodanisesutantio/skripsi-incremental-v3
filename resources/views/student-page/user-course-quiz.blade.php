@extends('layouts.relative')

@section('content')
    <div class="flex flex-col w-full h-full">
        {{-- Course Theory Content --}}
        <form id="quiz-form" class="swiper w-full h-full" action="{{ url('/user-course/quiz/' . $enrollment['id'] . '/' . $meeting_number) }}" method="POST">
            @csrf
            <div class="swiper-wrapper">
                <div class="swiper-slide select-none">
                    {{-- Mobile Cover Slide --}}
                    <div class="w-full h-dvh lg:hidden bg-cover bg-center" style="background-image: url('{{ asset("img/cover/{$content['title-image-mobile']}") }}')">
                        <div class="relative flex flex-col justify-between w-full h-full bg-custom-dark/45 p-6">
                            <div class="w-full h-full flex flex-col items-center justify-center">
                                <div class="px-3 py-1 bg-custom-dark w-fit rounded-md">
                                    <p class="font-league text-lg/snug text-custom-white">Pertemuan {{ $meeting_number }}</p>
                                </div>
                                <h1 class="mt-3 font-encode font-extrabold text-center text-custom-white text-4xl/snug">Quiz : {{ $content['title'] }}</h1>
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
                                <h1 class="mt-3 font-encode font-extrabold text-center text-custom-white text-5xl/snug">Quiz : {{ $content['title'] }}</h1>

                                {{-- Start Button --}}
                                <button type="button" id="jump-to-next-slide-desktop" class="mt-8 px-12 py-3 rounded-lg lg:rounded-lg bg-custom-white hover:bg-custom-white-hover text-xl/snug text-center text-custom-dark font-semibold lg:order-2 duration-300">Mulai Quiz</button>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($content['slides'] as $index => $slide)
                    <div class="swiper-slide select-none">
                        <div class="flex flex-col justify-between lg:gap-16 w-full h-dvh p-6 lg:px-80 lg:py-11">
                            <div class="flex flex-col gap-1">
                                <p class="font-league font-normal text-base/snug lg:text-lg/snug lg:text-center text-custom-grey">Pertanyaan No. {{ $index + 1 }}</p>
                                <h3 class="font-encode font-semibold text-custom-dark text-xl/snug lg:text-3xl/snug">{{ $slide['question'] }}</h3>
                            </div>      

                            <div class="flex flex-col gap-4">
                                <p class="font-league font-normal text-base/snug lg:text-lg/snug lg:text-center text-custom-grey">Pilih Jawaban :</p>
                                @foreach ($slide['choice'] as $index => $option)
                                    <div class="p-3 lg:p-4 border border-custom-grey/50 rounded-lg answer-option" data-index="{{ $index }}" data-correct="{{ $slide['correctAnswer'] }}">
                                        <p class="font-league text-base/snug lg:text-xl/snug">{{ $option }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
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

        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,
        });

        // Handle answer option click
        $('.answer-option').on('click', function () {
            const selectedIndex = $(this).data('index');
            const correctIndex = $(this).data('correct');

            // Check if the selected answer is correct
            if (selectedIndex === correctIndex) {
                $(this).addClass('bg-custom-success/40'); // Correct answer
            } else {
                $(this).addClass('bg-custom-destructive/40'); // Incorrect answer
            }

            // Wait for 1.2 seconds before moving to the next slide or submitting the form
            setTimeout(function () {
                if (swiper.isEnd) { // Check if this is the last slide
                    $('#quiz-form').submit(); // Submit the form
                } else {
                    swiper.slideNext(); // Move to the next slide
                }
            }, 1200); // 1200 milliseconds = 1.2 seconds
        });

        // Jump to the next slide when the button is clicked
        $('#jump-to-next-slide-mobile, #jump-to-next-slide-desktop').on('click', function () {
            swiper.slideNext(); // Move to the next slide
        });
    </script>
@endsection