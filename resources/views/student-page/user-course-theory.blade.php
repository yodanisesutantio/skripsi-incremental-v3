@extends('layouts.relative')

@section('content')
    <div class="flex flex-col w-full h-full">
        {{-- Top Nav Button --}}
        <div class="flex flex-row w-full z-20 px-5 py-6 lg:pt-6 lg:pb-4 lg:px-8 items-center justify-between bg-custom-white">
            <a href="user-course-details"><svg xmlns="http://www.w3.org/2000/svg" id="close-theory-page" width="32" height="32" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></a>
            <a class="next-button"><div class="flex justify-center items-center bg-custom-disabled-light text-custom-white w-36 h-11 font-league text-lg/none font-medium rounded-md duration-300" id="mark-theory-as-done">Selesai</div></a>
        </div>

        {{-- <div class="flex flex-col gap-3 lg:gap-6 px-5 lg:px-20 pt-2 pb-5 lg:pb-2 lg:h-full" id="question-{{ $i }}">
            @if ($quizContent[$i]['questionType'] === 1)
            <h4 class="font-encode font-semibold text-2xl/snug text-custom-dark lg:text-2xl/snug lg:hidden">{{ $quizContent[$i]['questionStatement'] }}</h4>
            <div class="flex flex-col lg:flex-row items-center lg:items-center lg:justify-between gap-2 lg:gap-24 lg:w-full h-auto lg:h-full">
                <img src="img/{{ $quizContent[$i]['thumbnailSlug'] }}.jpg" alt="" class="w-full lg:w-1/2 h-52 lg:h-auto mb-3 lg:mb-0 object-cover object-center flex-shrink-0 rounded-md shadow-lg lg:order-2" style="aspect-ratio: 3/2;">
                <p class="font-league text-base/tight text-left w-full text-custom-grey lg:hidden">Pilih Jawaban :</p>
                <div class="flex flex-col gap-4 lg:justify-center w-full" style="scrollbar-width: none;">
                    <h4 class="font-encode font-semibold text-2xl/snug hidden lg:block text-custom-dark lg:text-2xl/snug">{{ $quizContent[$i]['questionStatement'] }}</h4>
                    <p class="font-league text-base/tight text-left w-full text-custom-grey hidden lg:flex">Pilih Jawaban :</p>
                    <p class="p-3 w-full rounded-lg answer-choice bg-custom-white border border-custom-grey text-lg font-league text-custom-dark duration-150 hover:cursor-pointer">{{ $quizContent[$i]['answerA'] }}</p>
                    <p class="p-3 w-full rounded-lg answer-choice bg-custom-white border border-custom-grey text-lg font-league text-custom-dark duration-150 hover:cursor-pointer">{{ $quizContent[$i]['answerB'] }}</p>
                </div>
            </div> --}}

        {{-- Course Theory Content --}}
        <div class="swiper w-full h-full">
            <div class="swiper-wrapper">
                @foreach ($theory as $displayTheory) 
                    <div class="swiper-slide select-none overflow-y-auto lg:overflow-hidden">
                        <div class="flex flex-col lg:flex-row items-center lg:items-center lg:justify-between gap-2 lg:gap-16 w-full py-2 px-5 lg:px-20 lg:py-11 h-auto lg:h-full">
                            <img src="img/{{ $displayTheory['thumbnailSlug'] }}.jpg" alt="" class="w-full lg:w-1/2 h-52 lg:h-auto mb-3 lg:mb-0 object-cover object-center flex-shrink-0 rounded-md shadow-lg lg:order-2" style="aspect-ratio: 3/2;">
                            <div class="flex flex-col gap-2 lg:gap-4 lg:justify-start w-full h-full lg:order-2 lg:overflow-y-auto">
                                <h2 class="font-encode text-3xl/snug lg:text-4xl/snug text-custom-dark font-semibold">{{ $displayTheory['headingTheory'] }}</h2>
                                <p class="font-league text-lg/snug lg:text-xl/snug text-custom-dark font-normal">{{ $displayTheory['textTheory'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Left and Right Button --}}
        <div class="flex flex-row flex-shrink-0 w-full px-3 pt-6 lg:pt-5 pb-4 items-center justify-between bg-custom-white select-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="left-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15 5l-6 7l6 7"/></svg>
            <p class="font-league font-regular text-xl/tight text-custom-dark"><span id="pageNumber">1</span></p>
            <svg xmlns="http://www.w3.org/2000/svg" class="right-button" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m9 5l6 7l-6 7"/></svg>
        </div>
    </div>
@endsection