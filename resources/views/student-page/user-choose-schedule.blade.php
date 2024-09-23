@extends('layouts.relative')

@section('content')
    {{-- Mobile View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Pilih Jadwal</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Tentukan jadwal kursus mu</p>
        </div>

        {{-- Tabs --}}
        <div class="overflow-x-auto px-6" style="scrollbar-width: none;">
            <ul class="flex flex-row gap-5 font-league text-custom-dark text-lg font-medium text-center">
                @for ($i = 0; $i < $enrollment->course->course_length; $i++)
                    {{-- Meeting Number Tabs --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="py-1 {{ $i === 0 ? 'border-b-2 font-semibold text-custom-green border-custom-green opacity-100' : 'opacity-40' }} {{ $i === $enrollment->course->course_length - 1 ? 'mr-6' : '' }}" id="mobile_tabs_{{ $i + 1 }}" data-index="{{ $i }}">Pertemuan {{ $i + 1 }}</button>
                    </li>
                @endfor
            </ul>
        </div>
    </div>


    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop View Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Pilih Jadwal</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Tentukan jadwal kursus mu</p>
            </div>

           {{-- Tabs --}}
            <ul class="flex flex-row flex-wrap gap-5 px-6 font-league text-custom-dark text-lg font-medium">
                @for ($i = 0; $i < $enrollment->course->course_length; $i++)
                    {{-- Meeting Number Tabs --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="py-2 px-4 rounded-xl lg:hover:bg-custom-disabled-dark/30 {{ $i === 0 ? 'font-semibold bg-custom-white-hover text-custom-green opacity-100' : 'opacity-40' }}" id="desktop_tabs_{{ $i + 1 }}" data-index="{{ $i }}">Pertemuan {{ $i + 1 }}</button>
                    </li>
                @endfor
            </ul>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            {{-- Update Schedule Form --}}
            <form action="{{ url('/user-course/schedule/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" method="post" id="proposeScheduleForm" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                <div class="swiper">
                    <div class="swiper-wrapper">
                        @for ($i = 0; $i < $enrollment->course->course_length; $i++)
                            <div class="swiper-slide">
                                <div class="flex flex-col mt-0 lg:mt-4 gap-5 lg:gap-7">
                                    {{-- Form Sub Headers --}}
                                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Jadwal Kursus untuk Pertemuan {{ $i + 1 }}</h2>
                
                                    {{-- Select Date --}}
                                    <div class="flex flex-col gap-1">
                                        <label for="course_date_{{ $i }}" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Tanggal Kursus<span class="text-custom-destructive">*</span></label>
                                        {{-- Input Number Column --}}
                                        <input type="date" name="course_date[]" id="course_date_{{ $i }}" class="p-3 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_date.' . $i) border-2 border-custom-destructive @enderror" value="{{ old('course_date.' . $i) }}">
                                        {{-- Error in Validation Message --}}
                                        @error('course_date.' . $i)
                                            <span class="text-custom-destructive">{{ $message }}</span>
                                        @enderror
                                    </div>
                
                                    {{-- Select Time --}}
                                    <div class="flex flex-col gap-1">
                                        <label for="course_time_{{ $i }}" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Jam Kursus<span class="text-custom-destructive">*</span></label>
                                        {{-- Dropdown --}}
                                        <select name="course_time[]" id="course_time_{{ $i }}" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_time.' . $i) border-2 border-custom-destructive @enderror">
                                            <option disabled selected>-- Pilih Jam Kursus --</option>
                                            @foreach ($availableSlots as $slot)
                                                <option value="{{ $slot['start'] }} - {{ $slot['end'] }}">{{ $slot['start'] }} - {{ $slot['end'] }}</option>
                                            @endforeach
                                        </select>
                                        {{-- Error in Validation Message --}}
                                        @error('course_time.' . $i)
                                            <span class="text-custom-destructive">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Batal</a>
                    <button type="button" class="hidden text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover prev-button">Kembali</a>
                    <button type="button" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 next-button">Lanjut</button>
                    <button type="submit" class="hidden px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/admin-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Batal</a>
        <button type="button" class="hidden text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover prev-button">Kembali</a>
        <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 next-button">Lanjut</button>
        <button type="submit" id="mobileSubmitButton" class="hidden px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Ajukan</button>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,
            autoHeight: true,
            navigation: {
                prevEl: '.prev-button',
                nextEl: '.next-button',
            },

            on: {
                slideChange: function() {
                    // Update button states on slide change for both mobile and desktop
                    const activeIndex = this.activeIndex;

                    // Update desktop buttons
                    document.querySelectorAll('button[id^="desktop_tabs_"]').forEach((button, index) => {
                        if (index === activeIndex) {
                            button.classList.add('font-semibold', 'bg-custom-white-hover', 'text-custom-green', 'opacity-100');
                            button.classList.remove('opacity-40');
                        } else {
                            button.classList.remove('font-semibold', 'bg-custom-white-hover', 'text-custom-green', 'opacity-100');
                            button.classList.add('opacity-40');
                        }
                    });

                    // Update mobile buttons
                    document.querySelectorAll('button[id^="mobile_tabs_"]').forEach((button, index) => {
                        if (index === activeIndex) {
                            button.classList.add('border-b-2', 'font-semibold',  'text-custom-green', 'border-custom-green', 'opacity-100');
                            button.classList.remove('opacity-40');
                        } else {
                            button.classList.remove('border-b-2', 'font-semibold',  'text-custom-green', 'border-custom-green', 'opacity-100');
                            button.classList.add('opacity-40');
                        }
                    });

                    // Toggle hidden class based on activeIndex
                    document.querySelectorAll('.back-button').forEach(button => {
                        button.classList.toggle('hidden', activeIndex !== 0);
                    });
                    document.querySelectorAll('.prev-button').forEach(button => {
                        button.classList.toggle('hidden', activeIndex === 0);
                    });
                    document.querySelectorAll('.next-button').forEach(button => {
                        button.classList.toggle('hidden', activeIndex === this.slides.length - 1);
                    });
                    document.querySelectorAll('.submit-button').forEach(button => {
                        button.classList.toggle('hidden', activeIndex !== this.slides.length - 1);
                    });
                }
            }
        });

        // Set initial button state for both mobile and desktop
        document.querySelectorAll('button[id^="desktop_tabs_"]').forEach((button, index) => {
            if (index === 0) {
                button.classList.add('font-semibold', 'bg-custom-white-hover', 'text-custom-green','opacity-100');
            } else {
                button.classList.add('opacity-40');
            }
        });

        document.querySelectorAll('button[id^="mobile_tabs_"]').forEach((button, index) => {
            if (index === 0) {
                button.classList.add('border-b-2', 'font-semibold',  'text-custom-green', 'border-custom-green', 'opacity-100');
            } else {
                button.classList.add('opacity-40');
            }
        });

        // Add click event listener to each tab button for both mobile and desktop
        document.querySelectorAll('button[id^="desktop_tabs_"], button[id^="mobile_tabs_"]').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                swiper.slideTo(index); // Jump to the corresponding slide
            });
        });

        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#proposeScheduleForm').submit();
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