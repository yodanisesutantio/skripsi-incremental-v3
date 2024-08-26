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

                            {{-- Input startCourseDate --}}
                            <div class="flex flex-col gap-1 mt-4">
                                <label for="startCourseDate-number-{{ $nextCourseSchedule->meeting_number }}" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih tanggal kursus<span class="text-custom-destructive">*</span></label>

                                {{-- Input Date Column --}}
                                <input type="date" name="startCourseDate-number-{{ $nextCourseSchedule->meeting_number }}" id="startCourseDate-number-{{ $nextCourseSchedule->meeting_number }}" class="px-3 py-3 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startCourseDate-number-{{ $nextCourseSchedule->meeting_number }}') border-2 border-custom-destructive @enderror">

                                {{-- Error in Validation Message --}}
                                @error('startCourseDate-number-{{ $nextCourseSchedule->meeting_number }}')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Open Hours --}}
                            <div class="flex flex-col gap-1 mt-4">
                                <label for="courseTime-number-{{ $nextCourseSchedule->meeting_number }}" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Jam Kursus<span class="text-custom-destructive">*</span></label>
                                <select name="courseTime-number-{{ $nextCourseSchedule->meeting_number }}" id="courseTime-number-{{ $nextCourseSchedule->meeting_number }}" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg">
                                    <option disabled selected>Pilih jam kursus</option>
                                    <option value="08:00">08:00 - 09:30</option>
                                    <option value="10:00">10:00 - 11:30</option>
                                    <option value="10:00">13:30 - 15:00</option>
                                    <option value="10:00">15:30 - 17:00</option>
                                </select>
                                @error('courseTime-number-{{ $nextCourseSchedule->meeting_number }}')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Select Instructor --}}
                            <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Ubah Instruktur?</h2>
                            </div>

                            <ul class="grid w-full gap-2 lg:gap-5 grid-cols-2 lg:grid-cols-3">
                                @foreach ($instructors as $myInstructor)
                                {{-- Display all available Instructors, make it clickable --}}
                                @if ($myInstructor['availability'] === 1)
                                <li class="flex flex-col justify-center items-center">
                                    <label for="instructor_{{ $myInstructor['id'] }}" class="flex flex-col items-center gap-2 p-2 w-full flex-grow cursor-pointer lg:hover:bg-custom-dark/10 rounded duration-300" data-id="{{ $myInstructor['id'] }}">
                                        <div class="profile-picture-wrapper relative">
                                            {{-- If Instructor Profile Picture Exist, show this --}}
                                            @if ($myInstructor['hash_for_profile_picture'])
                                            <img src="{{ asset('storage/profile_pictures/' . $myInstructor->hash_for_profile_picture) }}" alt="" class="w-24 h-24 rounded-full object-cover object-center" data-id="{{ $myInstructor['id'] }}">
        
                                            {{-- If Instructor Profile Picture not exist, show this instead --}}
                                            @else
                                            <img src="{{ asset('img/blank-profile.webp') }}" alt="" class="w-24 h-24 rounded-full object-cover object-center" data-id="{{ $myInstructor['id'] }}">
                                            @endif
        
                                            {{-- Checkmark to differentiate, which instructor is chosen, and which instructor is not --}}
                                            <span class="flex items-center justify-center bg-custom-green/80 checkmark hidden w-full h-full absolute top-0 left-0 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10m-5.97-3.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l2.235-2.235L14.97 8.97a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                            </span>
                                        </div>
        
                                        {{-- Instructor's Full Name --}}
                                        <h4 class="font-encode tracking-tight font-semibold text-base/tight lg:text-lg/tight text-center line-clamp-2">{{ $myInstructor['fullname'] }}</h4>
                                    </label>
                                    <input type="radio" name="instructor_id" value="{{ $myInstructor['id'] }}" class="select-instructor hidden" id="instructor_{{ $myInstructor['id'] }}" {{ $myInstructor['id'] === $enrollment->instructor_id ? 'checked' : '' }}>
                                </li>
        
                                {{-- Display All Unavailable Instructors, make it unclickable --}}
                                @else
                                <li class="flex flex-col justify-center items-center">
                                    <div class="flex flex-col items-center gap-2 p-2 w-full flex-grow opacity-30">
                                        {{-- If Instructor Profile Picture Exist, show this --}}
                                        @if ($myInstructor['hash_for_profile_picture'])
                                        <img src="{{ asset('storage/profile_pictures/' . $myInstructor->hash_for_profile_picture) }}" alt="" class="w-24 h-24 rounded-full object-cover object-center cantChooseInstructor" data-name="{{ $myInstructor['fullname'] }}">
        
                                        {{-- If Instructor Profile Picture not exist, show this instead --}}
                                        @else
                                        <img src="{{ asset('img/blank-profile.webp') }}" alt="" class="w-24 h-24 rounded-full object-cover object-center cantChooseInstructor" data-name="{{ $myInstructor['fullname'] }}">
                                        @endif
        
                                        {{-- Instructor's Full Name --}}
                                        <h4 class="font-encode tracking-tight font-semibold text-base/tight lg:text-lg/tight text-center line-clamp-2">{{ $myInstructor['fullname'] }}</h4>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                            
                            {{-- Error in Validation Message --}}
                            @error('instructor_ids')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
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

        const totalSlides = swiper.slides.length;
        if (totalSlides === 1) {
            $('.submit-button').removeClass('hidden'); // Show submit button
            $('.next-button').addClass('hidden'); // Hide next button
        }

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

        // Checkboxes and checkmarks
        const instructorRadio = document.querySelectorAll('.select-instructor');

        instructorRadio.forEach(radio => {
            // Show checkmark if radio is checked on page load
            if (radio.checked) {
                const checkmark = radio.closest('li').querySelector('.checkmark');
                checkmark.classList.remove('hidden');
            }

            // Add event listener for change event
            radio.addEventListener('change', function() {
                const checkmark = this.closest('li').querySelector('.checkmark');
                if (this.checked) {
                    checkmark.classList.remove('hidden'); // Show checkmark
                } else {
                    checkmark.classList.add('hidden'); // Hide checkmark
                }
            });
        });

        // Check the radio when the label is clicked
        const labels = document.querySelectorAll('label[data-id]');
        labels.forEach(label => {
            label.addEventListener('click', function() {
                event.preventDefault();
                const id = this.dataset.id;
                const radio = document.getElementById('instructor_' + id);
                const checkmark = this.querySelector('.checkmark');

                // Toggle radio state
                radio.checked = !radio.checked;

                // Change image to green checkmark with a timeout
                if (radio.checked) {
                    checkmark.classList.remove('hidden'); // Show the checkmark after a delay
                } else {
                    checkmark.classList.add('hidden'); // Hide the checkmark immediately
                }
            });
        });

        // Error Toastr Message to Show When Users force to click the delete button when it cant be deleted
        $('.cantChooseInstructor').on('click', function() {
            const instructorName = $(this).data('name');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning('Pastikan Sertifikat Instruktur ' + instructorName + ' sudah divalidasi!');
        });
    </script>
@endsection