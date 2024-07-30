@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
            <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
        </div>
    </div>

    {{-- Mobile View Forms Header --}}
    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
                <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('admin-driving-school-license/' . auth()->user()->username) }}" method="post" enctype="multipart/form-data" id="uploadNewLicenseForm" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf
                {{-- Form Sub Headers --}}
                <div class="mb-4 lg:mt-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Izin Kursus Mengemudi</h2>
                </div>
                {{-- Input licensePath --}}
                <div class="flex flex-col gap-2">
                    <label for="licensePath" class="cursor-pointer rounded-lg">
                        <!-- Display the thumbnail if it exists -->
                        <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-[18rem] bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light overflow-hidden duration-300" id="licensePath_wrapper" {{-- style="background-image: url('{{ asset('storage/classOrlicensePath/' . $license['licensePath']) }}')"--}}>
                            <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="licensePath_overlay"></div>
                            <input id="licensePath" name="licensePath" type="file" class="hidden">
                        </div>
                    </label>
                    @error('licensePath')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Input endDateLicense --}}
                <div class="flex flex-col gap-1 mt-8">
                    <label for="endDateLicense" class="font-semibold font-league text-xl text-custom-grey">Tenggat Akhir Dokumen<span class="text-custom-destructive">*</span></label>
                    <input type="date" name="endDateLicense" id="endDateLicense" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endDateLicense') border-2 border-custom-destructive @enderror" {{-- value="{{ $license['endDateLicense'] }}"--}}>
                    @error('endDateLicense')
                        <span class="text-custom-destructive">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="/admin-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="/admin-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
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
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#licensePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#licensePath_overlay').removeClass('hidden');
                $('#licensePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });

        const dropArea = $('#licensePath_overlay');
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
                $('#licensePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#licensePath_overlay').removeClass('hidden');
                $('#licensePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    </script>
@endsection