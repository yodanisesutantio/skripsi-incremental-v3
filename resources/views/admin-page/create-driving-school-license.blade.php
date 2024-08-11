@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug text-custom-dark font-encode tracking-tight font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
            <p class="text-custom-grey text-lg/tight font-league mt-2 lg:text-xl">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
        </div>
    </div>

    {{-- Mobile View Forms Header --}}
    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col px-6">
                <h1 class="text-3xl lg:text-4xl/snug text-custom-dark font-encode tracking-tight font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
                <p class="text-custom-grey text-lg/tight font-league mt-2 lg:text-xl">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="/admin-driving-school-license/create" method="POST" class="px-6 pb-24 lg:pb-0 lg:pt-5" id="uploadNewLicenseForm" enctype="multipart/form-data">
                @csrf
                {{-- Form Sub Headers --}}
                <div class="mb-4 lg:mt-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Unggah Izin Baru</h2>
                </div>

                {{-- Input licensePath --}}
                <div class="flex flex-col gap-2">
                    <label for="licensePath" class="cursor-pointer rounded-lg">
                        {{-- Dropper --}}
                        <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-60 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light border-2 border-custom-grey border-dashed overflow-hidden duration-300" id="licensePath_wrapper">
                            {{-- Hidden Overlays, uncover when there's an uploaded file --}}
                            <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300 hidden" id="licensePath_overlay"></div>
                            {{-- Upload information such as file size limit, file type, etc. --}}
                            <div class="flex flex-col items-center justify-center px-8 pt-5 pb-6" id="uploadInfo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#646464" d="M18 8a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path fill="#646464" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.088c0 1.909 0 3.471-.104 4.743c-.104 1.28-.317 2.347-.795 3.235c-.21.391-.47.742-.785 1.057c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.793-.793-1.203-1.78-1.42-3.006c-.215-1.203-.254-2.7-.262-4.558c-.002-.473-.002-.973-.002-1.501v-.058c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386v.844l1.001-.876a2.3 2.3 0 0 1 3.141.104l4.29 4.29a2 2 0 0 0 2.564.222l.298-.21a3 3 0 0 1 3.732.225l2.83 2.547c.286-.598.455-1.384.545-2.493c.098-1.205.099-2.707.099-4.653c0-2.378-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176" clip-rule="evenodd"/></svg>
                                <p class="mt-4 mb-2 text-base text-center text-custom-grey"><span class="font-semibold">Tekan untuk memilih foto yang akan diupload</span> atau seret foto anda ke area ini</p>
                                <p class="text-sm text-custom-grey text-center">Format yang didukung .jpg, .png, atau .webp (MAX. 2 MB)</p>
                            </div>
                            <input id="licensePath" name="licensePath" type="file" class="hidden">
                        </div>
                    </label>
                    @error('licensePath')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input startDateLicense --}}
                <div class="flex flex-col gap-1 mt-8">
                    <label for="startLicenseDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Awal Berlaku<span class="text-custom-destructive">*</span></label>
                    {{-- Input Date Column --}}
                    <input type="date" name="startLicenseDate" id="startLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startLicenseDate') border-2 border-custom-destructive @enderror">
                    {{-- Error in Validation Message --}}
                    @error('startLicenseDate')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input endDateLicense --}}
                <div class="flex flex-col gap-1 mt-8">
                    <label for="endLicenseDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                    {{-- Input Date Column --}}
                    <input type="date" name="endLicenseDate" id="endLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endLicenseDate') border-2 border-custom-destructive @enderror">
                    {{-- Error in Validation Message --}}
                    @error('endLicenseDate')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="/admin-driving-school-license" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
                    <button type="submit" class="px-8 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan Izin Baru</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden" id="mobileButtonGroupWrapper">
        <a href="/admin-driving-school-license" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-8 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan Izin Baru</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#uploadNewLicenseForm').submit();
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
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    </script>
@endsection