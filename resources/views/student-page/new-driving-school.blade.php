@extends('layouts.relative')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-full">
        <div class="swiper w-full">
            <div class="swiper-wrapper">
                {{-- {{ dd($user->drivingSchoolLicense) }} --}}
                @if ($user->drivingSchoolLicense->isEmpty())
                    <div class="swiper-slide w-full h-full flex-shrink-0 p-6 lg:py-20 lg:px-72 pb-[6.5rem]">
                        <div class="flex flex-col justify-between">
                            {{-- Headers --}}
                            <div class="flex flex-col gap-4 lg:gap-6">
                                <h1 class="text-2xl/tight lg:text-4xl lg:text-center text-custom-dark font-encode tracking-tight font-semibold">Syarat-syarat Pendaftaran Kursus Mengemudi</h1>
                                <div class="flex flex-col gap-2">
                                    <p class="text-custom-dark lg:text-center text-lg/tight lg:text-xl/tight font-league">Anda bisa menjadi instruktur melalui Pemilik / Admin yang sudah terdaftar di KEMUDI. <span class="font-semibold underline text-custom-green"><a href="/contact-us">Bagaimana mendapat undangan mengajar?</a></span></p>
                                    <p class="text-custom-dark lg:text-center text-lg/tight lg:text-xl/tight font-league">Atau anda bisa mendaftarkan kursus milik anda di KEMUDI. Anda wajib mengunggah dokumen Izin Penyelenggaraan Pendidikan dan Pelatihan Mengemudi Kendaraan Bermotor sebagaimana yang diatur pada <span class="font-semibold">Peraturan Daerah Kota Surabaya No. 22 Tahun 2012.</span></p>
                                    <p class="text-custom-dark lg:text-center text-lg/tight lg:text-xl/tight font-league">Dokumen yang anda unggah akan kami tinjau paling lama 1 hari (24 Jam), setiap kemajuan dan masalah yang kami temui akan kami notifikasikan ke anda.</p>
                                </div>
                            </div>

                            {{-- Button Groups for Desktop View --}}
                            <div class="lg:flex flex-row w-full lg:mt-8 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                                <a href="/user-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
                                <button type="button" class="next-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Unggah Izin Kursus</button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="swiper-slide w-full h-full flex-shrink-0 p-6 lg:py-20 lg:px-72 pb-[6.5rem]">
                    {{-- Headers --}}
                    <div class="flex flex-col gap-2">
                        <h1 class="text-2xl/tight lg:text-4xl lg:text-center text-custom-dark font-encode tracking-tight font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
                        <p class="text-custom-grey lg:text-center text-lg/tight lg:text-xl/tight font-league">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
                    </div>

                    <form action="{{ url('/new-driving-school') }}" method="post" id="uploadDrivingSchoolLicense" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="flex flex-col gap-2 mt-4 lg:px-28">
                            <label for="licensePath" class="cursor-pointer rounded-lg">
                            {{-- Dropper --}}
                            @if ($user->drivingSchoolLicense->isNotEmpty())
                                <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-64 lg:h-72 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light border-dashed overflow-hidden duration-300" id="licensePath_wrapper" style="background-image: url('{{ asset('storage/licensePath/' . $user->drivingSchoolLicense->licensePath) }}')">
                                    {{-- Hidden Overlays, uncover when there's an uploaded file --}}
                                    <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="licensePath_overlay"></div>

                                    {{-- licenseStatus Indicator --}}
                                    @if ($user->drivingSchoolLicense && $user->drivingSchoolLicense->licenseStatus === 'Belum Divalidasi')
                                        {{-- License Status Overlay --}}
                                        <div class="hidden absolute top-0 left-0 flex-col justify-center items-center w-full h-full px-6 bg-custom-dark/75 hover:bg-custom-dark/40 duration-300" id="licensePath_status">
                                            {{-- Hourglass Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#F6F6F6" fill-rule="evenodd" d="M12 2C7.867 2 5.8 2 5.198 3.3a2.521 2.521 0 0 0-.13.346c-.41 1.387 1.052 2.995 3.974 6.21L11 12h2l1.958-2.143c2.922-3.216 4.383-4.824 3.974-6.21a2.507 2.507 0 0 0-.13-.348C18.2 2 16.133 2 12 2" clip-rule="evenodd"/><path fill="#F6F6F6" d="M5.198 20.7C5.8 22 7.867 22 12 22c4.133 0 6.2 0 6.802-1.3a2.51 2.51 0 0 0 .13-.346c.41-1.387-1.052-2.995-3.974-6.21L13 12h-2l-1.958 2.143c-2.922 3.216-4.383 4.824-3.974 6.21c.035.12.078.236.13.348" opacity=".5"/></svg>

                                            {{-- Text Content --}}
                                            <h3 class="mt-4 font-league font-semibold text-xl/snug lg:text-2xl/snug text-custom-white">Dokumen sedang kami tinjau</h3>
                                            <p class="font-league text-sm lg:text-base text-center text-custom-white">Jangan khawatir, kami akan memberitahukan anda jika terdapat kemajuan selambat-lambatnya selama 24 Jam</p>
                                        </div>
                                    @else
                                        
                                    @endif

                                    {{-- Upload information such as file size limit, file type, etc. --}}
                                    <div class="flex-col items-center justify-center px-8 pt-5 pb-6 hidden" id="uploadInfo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#646464" d="M18 8a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path fill="#646464" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.088c0 1.909 0 3.471-.104 4.743c-.104 1.28-.317 2.347-.795 3.235c-.21.391-.47.742-.785 1.057c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.793-.793-1.203-1.78-1.42-3.006c-.215-1.203-.254-2.7-.262-4.558c-.002-.473-.002-.973-.002-1.501v-.058c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386v.844l1.001-.876a2.3 2.3 0 0 1 3.141.104l4.29 4.29a2 2 0 0 0 2.564.222l.298-.21a3 3 0 0 1 3.732.225l2.83 2.547c.286-.598.455-1.384.545-2.493c.098-1.205.099-2.707.099-4.653c0-2.378-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176" clip-rule="evenodd"/></svg>
                                        <p class="mt-4 mb-2 text-sm lg:text-base text-center text-custom-grey"><span class="font-semibold">Tekan untuk memilih file yang akan diunggah</span> atau seret file anda ke area ini</p>
                                        <p class="text-sm lg:text-base text-custom-grey text-center">Format yang didukung .jpg, .png, atau .webp (MAX. 2 MB)</p>
                                    </div>
                                    <input id="licensePath" name="licensePath" type="file" class="hidden">
                                </div>
                            @else
                                <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-64 lg:h-72 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light border-2 border-custom-grey border-dashed overflow-hidden duration-300" id="licensePath_wrapper">
                                    {{-- Hidden Overlays, uncover when there's an uploaded file --}}
                                    <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300 hidden" id="licensePath_overlay"></div>

                                    {{-- Upload information such as file size limit, file type, etc. --}}
                                    <div class="flex flex-col items-center justify-center px-8 pt-5 pb-6" id="uploadInfo">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#646464" d="M18 8a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path fill="#646464" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.088c0 1.909 0 3.471-.104 4.743c-.104 1.28-.317 2.347-.795 3.235c-.21.391-.47.742-.785 1.057c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.793-.793-1.203-1.78-1.42-3.006c-.215-1.203-.254-2.7-.262-4.558c-.002-.473-.002-.973-.002-1.501v-.058c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386v.844l1.001-.876a2.3 2.3 0 0 1 3.141.104l4.29 4.29a2 2 0 0 0 2.564.222l.298-.21a3 3 0 0 1 3.732.225l2.83 2.547c.286-.598.455-1.384.545-2.493c.098-1.205.099-2.707.099-4.653c0-2.378-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176" clip-rule="evenodd"/></svg>
                                        <p class="mt-4 mb-2 text-sm lg:text-base text-center text-custom-grey"><span class="font-semibold">Tekan untuk memilih file yang akan diunggah</span> atau seret file anda ke area ini</p>
                                        <p class="text-sm lg:text-base text-custom-grey text-center">Format yang didukung .jpg, .png, atau .webp (MAX. 2 MB)</p>
                                    </div>
                                    <input id="licensePath" name="licensePath" type="file" class="hidden">
                                </div>
                            @endif
                            </label>
                            @error('licensePath')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input startDateLicense --}}
                        <div class="flex flex-col gap-2 mt-4 lg:px-28">
                            <label for="startLicenseDate" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Tanggal Awal Berlaku<span class="text-custom-destructive">*</span></label>
                            {{-- Input Date Column --}}
                            <input type="date" name="startLicenseDate" id="startLicenseDate" class="p-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('startLicenseDate') border-2 border-custom-destructive @enderror" value="{{ old('startLicenseDate') }}">
                            {{-- Error in Validation Message --}}
                            @error('startLicenseDate')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input endDateLicense --}}
                        <div class="flex flex-col gap-2 mt-4 lg:px-28">
                            <label for="endLicenseDate" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                            {{-- Input Date Column --}}
                            <input type="date" name="endLicenseDate" id="endLicenseDate" class="p-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('endLicenseDate') border-2 border-custom-destructive @enderror" value="{{ old('endLicenseDate') }}">
                            {{-- Error in Validation Message --}}
                            @error('endLicenseDate')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- Button Groups for Desktop View --}}
                        <div class="flex-row w-full lg:mt-5 py-4 lg:py-5 lg:px-28 items-center justify-end bg-custom-white hidden" id="sendPaymentReceiptWrapper">
                            <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Kirim Izin Kursus</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sticky Button Groups for Mobile --}}
            <div class="flex flex-col gap-3 fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden" id="mobile-button-groups">
                <button type="button" id="mobileNextButton" class="next-button w-full py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Unggah Izin Kursus</button>
                <button type="submit" id="mobileSubmitButton" class="hidden w-full py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Kirim Izin Kursus</button>
                <a href="/user-profile" class="text-custom-dark font-league font-medium px-1 pt-5 pb-4 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
            </div>
        </div>
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
                prevEl: null,
                nextEl: '.next-button',
            },

            on: {
                slideChange: function() {
                    // Toggle button visibility based on the active slide index
                    if (this.activeIndex === 0) {
                        $('#mobileNextButton').removeClass('hidden');
                    } else {
                        $('#mobileNextButton').addClass('hidden');
                    }
                }
            }
        });

        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#uploadPaymentReceipt').submit();
        });

        // Preview the Uploaded Thumbnail
        $('#licensePath').on('change', function(event) {
            const file = event.target.files[0]; // Read the uploaded files
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#licensePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#licensePath_overlay').removeClass('hidden');
                $('#licensePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo

                $('#sendPaymentReceiptWrapper').addClass('lg:flex');
                $('#mobileSubmitButton').removeClass('hidden');

                $('#licensePath_status').addClass('flex');
                $('#licensePath_status').removeClass('hidden');

                // Update Swiper to recalculate height
                swiper.update();
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });

        const dropArea = $('#licensePath_wrapper');
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

                // Read the dropped files
                const file = e.originalEvent.dataTransfer.files[0];

                if (file) {
                    // Set the file to the hidden input
                    $('#licensePath').prop('files', e.originalEvent.dataTransfer.files);
                    // Process the dropped file (e.g., display preview, upload)
                    handleDroppedFile(file);
                }
            }
        });

        // Change the states, when there's an uploaded files
        function handleDroppedFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#licensePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#licensePath_overlay').removeClass('hidden');
                $('#licensePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo

                $('#sendPaymentReceiptWrapper').addClass('lg:flex');
                $('#mobileSubmitButton').removeClass('hidden');

                $('#licensePath_status').addClass('flex');
                $('#licensePath_status').removeClass('hidden');

                // Update Swiper to recalculate height
                swiper.update();
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    </script>
@endsection