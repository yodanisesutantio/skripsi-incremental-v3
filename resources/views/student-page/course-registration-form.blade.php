@extends('layouts.relative')

@section('content')
    {{-- Mobile Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Daftar Kelas {{ $course->course_name }}</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">oleh {{ $course->admin->fullname }}</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Daftar Kelas {{ $course->course_name }}</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">oleh {{ $course->admin->fullname }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('/course/registration-form/' . $course->course_name . '/' . $course->id) }}" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-2 lg:mt-4 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Informasi Pribadi Siswa</h2>
                </div>
                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Student Real Name --}}
                    <div class="flex flex-col gap-1">
                        <label for="student_real_name" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nama Lengkap Siswa<span class="text-custom-destructive">*</span></label>
                        {{-- Input Text Column --}}
                        <input type="text" name="student_real_name" id="student_real_name" placeholder="Nama Lengkap Siswa" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_real_name') border-2 border-custom-destructive @enderror" value="{{ old('student_real_name') }}">
                        {{-- Error in Validation Message --}}
                        @error('student_real_name')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- Input Student Gender --}}
                    <div class="flex flex-col gap-1">
                        <label for="student_gender" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Jenis Kelamin Siswa<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdowns --}}
                        <select name="student_gender" id="student_gender" class="px-3 py-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_gender') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('student_gender')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        {{-- Input Student Birth of Place --}}
                        <div class="flex flex-col gap-1">
                            <label for="student_birth_of_place" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Tempat Lahir<span class="text-custom-destructive">*</span></label>
                            {{-- Input Text Column --}}
                            <input type="text" name="student_birth_of_place" id="student_birth_of_place" placeholder="Tempat Lahir" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_birth_of_place') border-2 border-custom-destructive @enderror" value="{{ old('student_birth_of_place') }}">
                            {{-- Error in Validation Message --}}
                            @error('student_birth_of_place')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        {{-- Input Student Birth of Date --}}
                        <div class="flex flex-col gap-1">
                            <label for="student_birth_of_date" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Tanggal Lahir<span class="text-custom-destructive">*</span></label>
                            {{-- Input Text Column --}}
                            <input type="date" name="student_birth_of_date" id="student_birth_of_date" placeholder="Tempat Lahir" class="px-4 py-3 font-league font-medium text-lg/tight bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_birth_of_date') border-2 border-custom-destructive @enderror" value="{{ old('student_birth_of_date') }}">
                            {{-- Error in Validation Message --}}
                            @error('student_birth_of_date')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Input Student Occupation --}}
                    <div class="flex flex-col gap-1">
                        <label for="student_occupation" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pekerjaan Siswa<span class="text-custom-destructive">*</span></label>
                        {{-- Input Text Column --}}
                        <input type="text" name="student_occupation" id="student_occupation" placeholder="Pekerjaan saat ini" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_occupation') border-2 border-custom-destructive @enderror" value="{{ old('student_occupation') }}">
                        {{-- Error in Validation Message --}}
                        @error('student_occupation')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Student Phone Number --}}
                    <div class="flex flex-col gap-2">
                        <label for="student_phone_number" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nomor Whatsapp Aktif<span class="text-custom-destructive">*</span></label>
                        <input type="tel" name="student_phone_number" id="student_phone_number" placeholder="081818181818" class="w-full p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_phone_number') border-2 border-custom-destructive @enderror" value="{{ old('student_phone_number') }}" oninput="deleteAnyString(this)">
                        @error('student_phone_number')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Student Address --}}
                    <div class="flex flex-col gap-2">
                        <label for="student_address" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Alamat Siswa<span class="text-custom-destructive">*</span></label>
                        <textarea name="student_address" id="student_address" rows="5" placeholder="Masukkan Alamat Tempat Tinggal" class="px-4 py-3.5 h-36 font-league font-medium text-lg/snug bg-custom-white-hover text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('student_address') border-2 border-custom-destructive @enderror">{{ old('student_address') }}</textarea>
                        @error('student_address')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Student Education Level --}}
                    <div class="flex flex-col gap-1">
                        <label for="student_education_level" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pendidikan Terakhir Siswa<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdowns --}}
                        <select name="student_education_level" id="student_education_level" class="px-3 py-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('student_education_level') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Pilih Pendidikan --</option>
                            <option value="SD Sederajat">SD Sederajat</option>
                            <option value="SMP Sederajat">SMP Sederajat</option>
                            <option value="SMA Sederajat">SMA Sederajat</option>
                            <option value="D1/D2/D3">D1/D2/D3</option>
                            <option value="S1/D4">S1/D4</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                            <option value="Tidak Bersekolah">Tidak Bersekolah</option>
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('student_education_level')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Profile Picture --}}
                    <div class="flex flex-col gap-1">
                        <label for="student_profile_picture" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Foto Siswa (Optional)</label>
                        <label for="student_profile_picture" class="relative w-fit">
                            <div class="p-2 w-fit rounded-full bg-custom-disabled-dark/90 absolute bottom-0 right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#F6F6F6" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
                            </div>
                            <div class="w-28 lg:w-32 h-28 lg:h-32 rounded-full bg-cover bg-center cursor-pointer overflow-hidden" style="background-image: url('{{ asset('img/blank-profile.webp') }}')" id="profilePicture">
                                <div class="flex items-center justify-center w-full h-full hover:bg-custom-dark/50 duration-300">
                                </div>
                            </div>
                        </label>
                        <input type="file" name="student_profile_picture" id="student_profile_picture" class="font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 hidden">
                        @error('student_profile_picture')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-6 lg:mt-12 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pilih Instruktur</h2>
                </div>

                <div class="flex flex-col gap-1">
                    <ul class="grid w-full gap-2 lg:gap-5 grid-cols-2 lg:grid-cols-3">
                        @foreach ($course->courseInstructors as $myInstructor)
                        {{-- Display all available Instructors, make it clickable --}}
                        @if ($myInstructor->instructor['availability'] === 1)
                        <li class="flex flex-col justify-center items-center">
                            <label for="instructor_{{ $myInstructor->instructor['id'] }}" class="flex flex-col items-center gap-2 p-2 w-full flex-grow cursor-pointer lg:hover:bg-custom-dark/10 rounded duration-300" data-id="{{ $myInstructor->instructor['id'] }}">
                                <div class="profile-picture-wrapper relative">
                                    {{-- If Instructor Profile Picture Exist, show this --}}
                                    @if ($myInstructor->instructor['hash_for_profile_picture'])
                                    <img src="{{ asset('storage/profile_pictures/' . $myInstructor->instructor->hash_for_profile_picture) }}" alt="" class="w-24 h-24 rounded-full object-cover object-center" data-id="{{ $myInstructor->instructor['id'] }}">

                                    {{-- If Instructor Profile Picture not exist, show this instead --}}
                                    @else
                                    <img src="{{ asset('img/blank-profile.webp') }}" alt="" class="w-24 h-24 rounded-full object-cover object-center" data-id="{{ $myInstructor->instructor['id'] }}">
                                    @endif

                                    {{-- Checkmark to differentiate, which instructor is chosen, and which instructor is not --}}
                                    <span class="flex items-center justify-center bg-custom-green/80 checkmark hidden w-full h-full absolute top-0 left-0 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10m-5.97-3.03a.75.75 0 0 1 0 1.06l-5 5a.75.75 0 0 1-1.06 0l-2-2a.75.75 0 1 1 1.06-1.06l1.47 1.47l2.235-2.235L14.97 8.97a.75.75 0 0 1 1.06 0" clip-rule="evenodd"/></svg>
                                    </span>
                                </div>

                                {{-- Instructor's Full Name --}}
                                <h4 class="font-encode tracking-tight font-semibold text-base/tight lg:text-lg/tight text-center line-clamp-2">{{ $myInstructor->instructor['fullname'] }}</h4>
                            </label>
                            <input type="radio" name="instructor_ids[]" value="{{ $myInstructor->instructor['id'] }}" class="instructor-radio hidden" id="instructor_{{ $myInstructor->instructor['id'] }}">
                        </li>
                        @endif
                    @endforeach
                    </ul>
                    
                    {{-- Error in Validation Message --}}
                    @error('instructor_ids')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/course/' . $course->course_name . '/' . $course->id) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Daftar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/course/' . $course->course_name . '/' . $course->id) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Daftar</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        // Checkboxes and checkmarks
        const radios = document.querySelectorAll('.instructor-radio');

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

        // Tel Input Script
        const phoneInputField = document.getElementById('student_phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        // Remove any non-numerical characters when pressed
        phoneInputField.addEventListener('keypress', function(event) {
            let value = input.value.replace(/\D/g, '');
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical input
            }
        });
        // Even when users tried to copy and paste a non-numerical characters, delete it immediately
        function deleteAnyString(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // Preview the uploaded profile picture
        $('#student_profile_picture').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePicture').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                }
                reader.readAsDataURL(file); // Read the file as a data URL
            }
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