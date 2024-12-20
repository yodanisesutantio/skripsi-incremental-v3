@extends('layouts.relative')

@section('content')
    {{-- Mobile Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Tambah Kelas Baru</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Masukkan informasi tentang kelas kursus baru anda</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Tambah Kelas Baru</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Masukkan informasi tentang kelas kursus baru anda</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('/admin-manage-course/create') }}" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pt-5 lg:pb-0" id="create-course-form">
                @csrf
                {{-- Form Sub Headers --}}
                <div class="mb-4 lg:mt-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Thumbnail Kelas Kursus</h2>
                </div>
                {{-- Input Course_Thumbnail --}}
                <div class="flex flex-col gap-2">
                    <label for="course_thumbnail" class="cursor-pointer rounded-lg">
                        {{-- Course_Thumbnail Dropzone --}}
                        <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-60 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light border-2 border-custom-grey border-dashed overflow-hidden duration-300" id="course_thumbnail_wrapper">
                            {{-- Overlay when an uploaded image is hovered --}}
                            <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300 hidden" id="course_thumbnail_overlay"></div>
                            {{-- Upload information, file size limits, file type etc. --}}
                            <div class="flex flex-col items-center justify-center px-8 pt-5 pb-6" id="uploadInfo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#646464" d="M18 8a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path fill="#646464" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.088c0 1.909 0 3.471-.104 4.743c-.104 1.28-.317 2.347-.795 3.235c-.21.391-.47.742-.785 1.057c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.793-.793-1.203-1.78-1.42-3.006c-.215-1.203-.254-2.7-.262-4.558c-.002-.473-.002-.973-.002-1.501v-.058c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386v.844l1.001-.876a2.3 2.3 0 0 1 3.141.104l4.29 4.29a2 2 0 0 0 2.564.222l.298-.21a3 3 0 0 1 3.732.225l2.83 2.547c.286-.598.455-1.384.545-2.493c.098-1.205.099-2.707.099-4.653c0-2.378-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176" clip-rule="evenodd"/></svg>
                                <p class="mt-4 mb-2 text-sm lg:text-base text-center text-custom-grey"><span class="font-semibold">Tekan untuk memilih foto yang akan diupload</span> atau seret foto anda ke area ini</p>
                                <p class="text-sm lg:text-base text-custom-grey text-center">Format yang didukung .jpg, .png, atau .webp (MAX. 2 MB)</p>
                            </div>
                            <input id="course_thumbnail" name="course_thumbnail" type="file" class="hidden">
                        </div>
                    </label>
                    @error('course_thumbnail')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>        
        
                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Informasi Kelas Kursus</h2>
                </div>
                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Course_Name --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_name" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nama Kelas Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Input Text Column --}}
                        <input type="text" name="course_name" id="course_name" placeholder="Nama Kelas Kursus Baru" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_name') border-2 border-custom-destructive @enderror" value="{{ old('course_name') }}">
                        {{-- Error in Validation Message --}}
                        @error('course_name')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Course_Description --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_description" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Deskripsi Kelas<span class="text-custom-destructive">*</span></label>
                        {{-- Input Text Area Column --}}
                        <textarea name="course_description" id="course_description" rows="4" placeholder="Tuliskan Deskripsi Kelas Kursus" class="px-4 py-3.5 h-32 font-league font-medium text-lg/snug bg-custom-white-hover text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('course_description') border-2 border-custom-destructive @enderror">{{ old('course_description') }}</textarea>
                        {{-- Error in Validation Message --}}
                        @error('course_description')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Course_Quota --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_quota" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Kuota Kelas<span class="text-custom-destructive">*</span></label>
                        {{-- Input Number Column --}}
                        <input type="number" min="1" max="999" name="course_quota" id="course_quota" placeholder="Kuota Minimum adalah 1 Siswa" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_quota') border-2 border-custom-destructive @enderror" value="{{ old('course_quota') }}">
                        {{-- Error in Validation Message --}}
                        @error('course_quota')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Course_Length --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_length" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Jumlah Pertemuan<span class="text-custom-destructive">*</span></label>
                        {{-- Input Number Column --}}
                        <input type="number" min="1" max="20" name="course_length" id="course_length" placeholder="Total Jumlah Pertemuan" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_length') border-2 border-custom-destructive @enderror" value="{{ old('course_length') }}">
                        {{-- Error in Validation Message --}}
                        @error('course_length')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- Input Course Duration --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_duration" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Durasi Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdowns --}}
                        <select name="course_duration" id="course_duration" class="px-3 py-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_duration') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Durasi Kursus dalam satuan menit --</option>
                            <option value="45">45 Menit</option>
                            <option value="60">60 Menit</option>
                            <option value="90">90 Menit</option>
                            <option value="120">120 Menit</option>
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('course_duration')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Course_Price --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_price" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Harga Kelas<span class="text-custom-destructive">*</span></label>
                        {{-- Input Text Column, course_price is special, since we need to display the currency so it is readable. Instead of 1000000, users will see Rp. 1.000.000,- --}}
                        <input type="text" name="course_price" id="course_price" placeholder="Harga Kelas" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_price') border-2 border-custom-destructive @enderror" oninput="formatCurrency(this)">
                        {{-- Error in Validation Message --}}
                        @error('course_price')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
        
                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Kategori Kelas Kursus</h2>
                </div>
                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Car_Type --}}
                    <div class="flex flex-col gap-1">
                        <label for="car_type" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Jenis Transmisi Mobil<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdown --}}
                        <select name="car_type" id="car_type" class="px-3 py-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('car_type') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Jenis Transmisi Mobil --</option>
                            <option value="Manual">Manual</option>
                            <option value="Automatic">Matic</option>
                            <option value="Both">Manual & Matic</option>
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('car_type')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Can_Use_Own_Car --}}
                    <div class="flex flex-col gap-1">
                        <label for="can_use_own_car" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Siswa Bisa Menggunakan Mobil Sendiri?<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdown --}}
                        <select name="can_use_own_car" id="can_use_own_car" class="px-3 py-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('can_use_own_car') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Bisa Pakai Mobil Sendiri --</option>
                            <option value="0">Tidak Bisa</option>
                            <option value="1">Bisa</option>
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('can_use_own_car')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Select Instructor --}}
                <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pilih Instruktur</h2>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="instructor_ids">
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
                                <input type="checkbox" name="instructor_ids[]" value="{{ $myInstructor['id'] }}" class="hidden" id="instructor_{{ $myInstructor['id'] }}">
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
                    </label>

                    {{-- Error in Validation Message --}}
                    @error('instructor_ids')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>
        
                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/admin-manage-course') }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/admin-manage-course') }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Tambah</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#create-course-form').submit();
        });

        // Display checkmark the instructors is chosen
        const labels = document.querySelectorAll('label[data-id]');
        labels.forEach(label => {
            label.addEventListener('click', function() {
                event.preventDefault();
                const id = this.dataset.id;
                const checkbox = document.getElementById('instructor_' + id);
                const checkmark = this.querySelector('.checkmark');

                // Toggle checkbox state
                checkbox.checked = !checkbox.checked;

                // Overlay the profile picture with green checkmark
                if (checkbox.checked) {
                    checkmark.classList.remove('hidden'); // Show the checkmark
                } else {
                    checkmark.classList.add('hidden'); // Hide the checkmark
                }
            });
        });

        // IDR Pricing Format
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            if (value) {
                input.value = 'Rp. ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ",-"; // Format to "Rp. x.xxx.xxx,-"
            } else {
                input.value = ''; // Clear if no value
            }
        }

        // Preview the Uploaded Thumbnail
        $('#course_thumbnail').on('change', function(event) {
            const file = event.target.files[0]; // Read the uploaded file
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#course_thumbnail_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#course_thumbnail_overlay').removeClass('hidden'); // Uncover the overlays
                $('#course_thumbnail_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });

        const dropArea = $('#course_thumbnail_wrapper');
        // Prevent default browser behavior for drag/drop events
        dropArea.on({
            dragover: function(e) {
                e.preventDefault();
                $(this).removeClass('bg-custom-disabled-light/60'); 
                $(this).addClass('bg-custom-disabled-light'); 
            },
            dragleave: function(e) {
                e.preventDefault();
                $(this).addClass('bg-custom-disabled-light/60'); 
                $(this).removeClass('bg-custom-disabled-light'); 
            },
            drop: function(e) {
                e.preventDefault();
                $(this).addClass('bg-custom-disabled-light/60'); 
                $(this).removeClass('bg-custom-disabled-light'); 

                // Read the dropped file
                const file = e.originalEvent.dataTransfer.files[0];

                if (file) {
                    // Set the file to the hidden input
                    $('#course_thumbnail').prop('files', e.originalEvent.dataTransfer.files);
                    // Process the dropped file (e.g., display preview, upload)
                    handleDroppedFile(file);
                }
            }
        });

        // Change the states when there's an uploaded file
        function handleDroppedFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#course_thumbnail_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#course_thumbnail_overlay').removeClass('hidden');
                $('#course_thumbnail_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }

        // Error Toastr Message to popup, when they force to choose the unavailable instructors
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