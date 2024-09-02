@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Ubah Jadwal</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ajukan perubahan jadwal untuk <strong class="font-semibold">Pertemuan {{ $schedule->meeting_number }}</strong></p>
        </div>
    </div>

    {{-- Mobile View Forms Header --}}
    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Ubah Jadwal</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ajukan perubahan jadwal untuk <strong class="font-semibold">Pertemuan {{ $schedule->meeting_number }}</strong></p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('/admin-course/new-schedule/' . $schedule->id) }}" method="post" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                <div class="flex flex-col mt-0 lg:mt-4 gap-5 lg:gap-7">
                    {{-- Form Sub Headers --}}
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Jadwal Kursus</h2>

                    {{-- Select Date --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_date" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Tanggal Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Input Number Column --}}
                        <input type="date" name="course_date" id="course_date" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_date') border-2 border-custom-destructive @enderror" value="{{ \Carbon\Carbon::parse($schedule['start_time'])->format('Y-m-d') }}">
                        {{-- Error in Validation Message --}}
                        @error('course_date')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Select Time --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_time" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Jam Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdown --}}
                        <select name="course_time" id="course_time" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_time') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Pilih Jam Kursus --</option>
                            @foreach ($availableSlots as $slot)
                                <option value="{{ $slot['start'] }} - {{ $slot['end'] }}">{{ $slot['start'] }} - {{ $slot['end'] }}</option>
                            @endforeach
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('course_time')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Form Sub Header --}}
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pilih Instruktur</h2>

                    <div class="flex flex-col gap-1">
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
                                <input type="radio" name="instructor_ids[]" value="{{ $myInstructor['id'] }}" class="instructor-radio hidden" id="instructor_{{ $myInstructor['id'] }}" {{ $schedule['instructor_id'] === $myInstructor['id'] ? 'checked' : '' }}>
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
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/admin-course-progress/' . $schedule->enrollment->student_real_name . '/' . $schedule->enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/admin-course-progress/' . $schedule->enrollment->student_real_name . '/' . $schedule->enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Checkboxes and checkmarks
        const radios = document.querySelectorAll('.instructor-radio');

        radios.forEach(radio => {
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
            label.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.dataset.id;
                const radio = document.getElementById('instructor_' + id);
                const checkmark = this.querySelector('.checkmark');

                // Hide checkmarks for all instructors
                radios.forEach(r => {
                    const otherCheckmark = r.closest('li').querySelector('.checkmark');
                    otherCheckmark.classList.add('hidden'); // Hide all checkmarks
                });

                // Toggle radio state
                radio.checked = true; // Set the clicked radio to checked

                // Show the checkmark for the newly selected instructor
                checkmark.classList.remove('hidden'); // Show the checkmark
            });
        });

        // Error Toastr Message to Show When Users force to click the delete button when it cant be deleted
        $('.cantChooseInstructor').on('click', function() {
            const instructorName = $(this).data('name');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning(instructorName + ' tidak bisa dipilih. Pastikan Instruktur sudah aktif!');
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