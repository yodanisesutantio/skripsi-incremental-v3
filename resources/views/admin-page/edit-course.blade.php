@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Edit Informasi Kelas</h1>
            <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Edit informasi tentang kelas <strong class="font-semibold text-custom-dark">{{ $course['course_name'] }}</strong></p>
        </div>
    </div>

    {{-- Mobile View Forms Header --}}
    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Edit Informasi Kelas</h1>
                <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Edit informasi tentang kelas <strong class="font-semibold text-custom-dark">{{ $course['course_name'] }}</strong></p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="/admin-manage-course/create" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf
                {{-- Form Sub Headers --}}
                <div class="mb-4 lg:mt-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Thumbnail Kelas Kursus</h2>
                </div>
                {{-- Input Course_Thumbnail --}}
                <div class="flex flex-col gap-2">
                    <label for="course_thumbnail" class="cursor-pointer rounded-lg">
                        <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-60 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light overflow-hidden duration-300" id="course_thumbnail_wrapper" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $course['course_thumbnail']) }}')">
                            <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="course_thumbnail_overlay"></div>
                            <input id="course_thumbnail" name="course_thumbnail" type="file" class="hidden">
                        </div>
                    </label>
                    @error('course_thumbnail')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>        
        
                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Informasi Kelas Kursus</h2>
                </div>
                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Course_Name --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_name" class="font-semibold font-league text-xl text-custom-grey">Nama Kelas Kursus<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="course_name" id="course_name" placeholder="Nama Kelas Kursus Baru" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('course_name') border-2 border-custom-destructive @enderror" value="{{ $course['course_name'] }}">
                        @error('course_name')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Course_Description --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_description" class="font-semibold font-league text-xl text-custom-grey">Deskripsi Kelas<span class="text-custom-destructive">*</span></label>
                        <textarea name="course_description" id="course_description" rows="4" placeholder="Tuliskan Deskripsi Kelas Kursus" class="px-4 py-3.5 h-32 font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('course_description') border-2 border-custom-destructive @enderror">{{ $course['course_description'] }}</textarea>
                        @error('course_description')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Course_Quota --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_quota" class="font-semibold font-league text-xl text-custom-grey">Kuota Kelas<span class="text-custom-destructive">*</span></label>
                        <input type="number" min="1" max="999" name="course_quota" id="course_quota" placeholder="Kuota Minimum adalah 1 Siswa" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('course_quota') border-2 border-custom-destructive @enderror" value="{{ $course['course_quota'] }}">
                        @error('course_quota')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Course_Length --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_length" class="font-semibold font-league text-xl text-custom-grey">Jumlah Pertemuan<span class="text-custom-destructive">*</span></label>
                        <input type="number" min="1" max="20" name="course_length" id="course_length" placeholder="Total Jumlah Pertemuan" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('course_length') border-2 border-custom-destructive @enderror" value="{{ $course['course_length'] }}">
                        @error('course_length')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Change Price Format to Readable Rupiahs --}}
                    <?php
                        function formatRupiah($number) {
                            return 'Rp. ' . number_format($number, 0, ',', '.') . ',-';
                        }
                    ?>

                    {{-- Input Course_Price --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_price" class="font-semibold font-league text-xl text-custom-grey">Harga Kelas<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="course_price" id="course_price" placeholder="Harga Kelas" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('course_price') border-2 border-custom-destructive @enderror" value="{{ formatRupiah($course['course_price']) }}" oninput="formatCurrency(this)">
                        @error('course_price')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
        
                {{-- Form Sub Headers --}}
                <div class="flex flex-col gap-1 mt-8 lg:mt-10 mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Kategori Kelas Kursus</h2>
                </div>
                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Car_Type --}}
                    <div class="flex flex-col gap-1">
                        {{-- Dropdown --}}
                        <label for="car_type" class="font-semibold font-league text-xl text-custom-grey">Jenis Transmisi Mobil<span class="text-custom-destructive">*</span></label>
                        <select name="car_type" id="car_type" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('car_type') border-2 border-custom-destructive @enderror">
                            <option disabled>-- Jenis Transmisi Mobil --</option>
                            <option value="Manual" {{ $course['car_type'] === "Manual" ? 'selected' : '' }}>Manual</option>
                            <option value="Automatic" {{ $course['car_type'] === "Automatic" ? 'selected' : '' }}>Matic</option>
                            <option value="Both" {{ $course['car_type'] === "Both" ? 'selected' : '' }}>Manual & Matic</option>
                        </select>
                        @error('car_type')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Can_Use_Own_Car --}}
                    <div class="flex flex-col gap-1">
                        {{-- Dropdown --}}
                        <label for="can_use_own_car" class="font-semibold font-league text-xl text-custom-grey">Siswa Bisa Menggunakan Mobil Sendiri?<span class="text-custom-destructive">*</span></label>
                        <select name="can_use_own_car" id="can_use_own_car" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('can_use_own_car') border-2 border-custom-destructive @enderror">
                            <option disabled>-- Bisa Pakai Mobil Sendiri --</option>
                            <option value="0" {{ $course['can_use_own_car'] === "0" ? 'selected' : '' }}>Tidak Bisa</option>
                            <option value="1" {{ $course['can_use_own_car'] === "1" ? 'selected' : '' }}>Bisa</option>
                        </select>
                        @error('can_use_own_car')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
        
                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="/admin-manage-course" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Tambah</button>
                </div>
            </form>
        </div>
    </div>

        {{-- Sticky Button Groups for Mobile --}}
        <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
            <a href="/admin-manage-course" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
            <button type="submit" class="submitAllForms px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
        </div>
    </form>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // IDR Pricing Format
        function formatCurrency(input) {
            // Remove all non-numeric characters
            let value = $(input).val().replace(/\D/g, '');
            
            // Format the number with dots as thousand separators
            if (value) {
                $(input).val('Rp. ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".") + ',-');
            } else {
                $(input).val(''); // Clear if no value
            }
        }

        // Attach the formatCurrency function to the input event
        $('#course_price').on('input', function() {
            formatCurrency(this);
        });

        // Reformat the value on page load in case of form errors
        $('#course_price').each(function() {
            formatCurrency(this);
        });

        // Preview the Uploaded Thumbnail
        $('#course_thumbnail').on('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#course_thumbnail_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#course_thumbnail_overlay').removeClass('hidden');
                $('#course_thumbnail_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });

        const dropArea = $('#course_thumbnail_overlay');
        // Prevent default browser behavior for drag/drop events
        dropArea.on({
            dragover: function(e) {
                e.preventDefault();
                $(this).addClass('bg-custom-dark/50'); // Optional: Add hover styling
            },
            dragleave: function(e) {
                e.preventDefault();
                $(this).removeClass('bg-custom-dark/50'); // Optional: Add hover styling
            },
            drop: function(e) {
                e.preventDefault();
                $(this).removeClass('bg-custom-dark/50'); // Optional: Add hover styling

                const file = e.originalEvent.dataTransfer.files[0];

                if (file) {
                    // Process the dropped file (e.g., display preview, upload)
                    handleDroppedFile(file);
                }
            }
        });

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
    </script>
@endsection