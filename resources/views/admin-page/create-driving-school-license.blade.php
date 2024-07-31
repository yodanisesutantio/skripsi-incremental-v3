@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Dokumen Izin Penyelenggaraan Kursus</h1>
            <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Unggah Dokumen Izin Penyelenggaraan Kursus Anda</p>
        </div>
        {{-- Tabs --}}
        <div class="overflow-x-auto" style="scrollbar-width: none;">
            <ul class="flex flex-row gap-5 font-league text-custom-dark text-lg font-medium text-center">
                {{-- Current Licenses --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 border-b-2 font-semibold text-custom-green border-custom-green opacity-100 ml-6" id="runningLargeLicense">Izin Berlaku</button>
                </li>
                {{-- Upcoming Licenses --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="upcomingLargeLicense">Izin Baru</button>
                </li>
                {{-- Upload New --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="newLargeLicense">Unggah Baru</button>
                </li>
            </ul>
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
            {{-- Tabs --}}
            <div class="overflow-x-auto lg:pt-8 hidden lg:block" style="scrollbar-width: none;">
                <ul class="flex flex-row lg:gap-8 font-league text-custom-dark text-lg lg:text-xl font-medium text-center">
                    {{-- Current Licenses --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 border-b-2 font-semibold text-custom-green border-custom-green opacity-100 ml-6" id="runningLicense">Izin Berlaku</button>
                    </li>
                    {{-- Upcoming Licenses --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="upcomingLicense">Izin Baru</button>
                    </li>
                    {{-- Upload New --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="newLicense">Unggah Baru</button>
                    </li>
                </ul>
            </div>

            <div class="swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide overflow-y-auto pb-6 lg:pb-10">
                        {{-- Running License --}}
                        <div class="px-6 lg:pt-5">
                            {{-- Form Sub Headers --}}
                            <div class="mb-4 lg:mt-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Izin Baru</h2>
                            </div>
                            {{-- Input licensePath --}}
                            <div class="flex flex-col gap-2">
                                <label for="licensePath" class="cursor-pointer rounded-lg">
                                    <!-- Display the PDF thumbnail if it exists -->
                                    <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-[18rem] bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light overflow-hidden duration-300" id="licensePath_wrapper">
                                        <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="licensePath_overlay"></div>
                                        <div id="pdfViewer" class="w-full h-full"></div>
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
                                <input type="date" name="startLicenseDate" id="startLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->startLicenseDate }}">
                                @error('startLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
            
                            {{-- Input endDateLicense --}}
                            <div class="flex flex-col gap-1 mt-8">
                                <label for="endLicenseDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                                <input type="date" name="endLicenseDate" id="endLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->endLicenseDate }}">
                                @error('endLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide overflow-y-auto pb-6 lg:pb-10">
                        {{-- Upcoming License --}}
                        <div class="px-6 lg:pt-5">
                            {{-- Form Sub Headers --}}
                            <div class="mb-4 lg:mt-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Unggah Izin Baru</h2>
                            </div>
                            {{-- Input licensePath --}}
                            <div class="flex flex-col gap-2">
                                <label for="licensePath" class="cursor-pointer rounded-lg">
                                    <!-- Display the PDF thumbnail if it exists -->
                                    <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-[18rem] bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light overflow-hidden duration-300" id="licensePath_wrapper">
                                        <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="licensePath_overlay"></div>
                                        <div id="pdfViewer" class="w-full h-full"></div>
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
                                <input type="date" name="startLicenseDate" id="startLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->startLicenseDate }}">
                                @error('startLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
            
                            {{-- Input endDateLicense --}}
                            <div class="flex flex-col gap-1 mt-8">
                                <label for="endLicenseDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                                <input type="date" name="endLicenseDate" id="endLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->endLicenseDate }}">
                                @error('endLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide overflow-y-auto pb-6 lg:pb-10">
                        {{-- New License Form --}}
                        <form action="uploadNewLicenseForm" method="post" enctype="multipart/form-data" class="px-6 lg:pt-5">
                            {{-- Form Sub Headers --}}
                            <div class="mb-4 lg:mt-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Izin yang sedang Berlaku</h2>
                            </div>
                            {{-- Input licensePath --}}
                            <div class="flex flex-col gap-2">
                                <label for="licensePath" class="cursor-pointer rounded-lg">
                                    <!-- Display the PDF thumbnail if it exists -->
                                    <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-[18rem] bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light overflow-hidden duration-300" id="licensePath_wrapper">
                                        <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300" id="licensePath_overlay"></div>
                                        <div id="pdfViewer" class="w-full h-full"></div>
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
                                <input type="date" name="startLicenseDate" id="startLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->startLicenseDate }}">
                                @error('startLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
            
                            {{-- Input endDateLicense --}}
                            <div class="flex flex-col gap-1 mt-8">
                                <label for="endLicenseDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                                <input type="date" name="endLicenseDate" id="endLicenseDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endLicenseDate') border-2 border-custom-destructive @enderror" value="{{ $license->endLicenseDate }}">
                                @error('endLicenseDate')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white hidden" id="mobileButtonGroupWrapper">
        <a href="/admin-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            autoHeight: true,

            navigation: {
                prevEl: '',
                nextEl: '',
            },

            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex;
                    const buttons = ['#accountInfoButton', '#paymentMethodButton', '#securityButton'];
                    const largeButtons = ['#accountInfoLargeButton', '#paymentMethodLargeButton', '#securityLargeButton'];

                    // For Mobile Tabs
                    buttons.forEach((button, index) => {
                        if (index === currentIndex) {
                            $(button).addClass('border-b-2 font-semibold text-custom-green border-custom-green opacity-100');
                            $(button).removeClass('opacity-40');
                        } else {
                            $(button).removeClass('border-b-2 font-semibold text-custom-green border-custom-green opacity-100');
                            $(button).addClass('opacity-40');
                        }
                    });

                    // For Large Tabs
                    largeButtons.forEach((large, index) => {
                        if (index === currentIndex) {
                            $(large).addClass('border-b-2 font-semibold text-custom-green border-custom-green opacity-100');
                            $(large).removeClass('opacity-40');
                        } else {
                            $(large).removeClass('border-b-2 font-semibold text-custom-green border-custom-green opacity-100');
                            $(large).addClass('opacity-40');
                        }
                    });
                },
                init: function () {
                    this.update();
                }
            }
        });

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

        // Include PDF.js from CDN
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js', function() {
            // Function to render PDF
            function renderPDF(url) {
                const loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    // Fetch the first page
                    pdf.getPage(1).then(function(page) {
                        const pdfViewer = $('#pdfViewer');
                        const wrapperWidth = $('#licensePath_wrapper').width();

                        // Determine scale based on container width
                        const viewport = page.getViewport({ scale: 1 });
                        const scale = wrapperWidth / viewport.width;
                        const scaledViewport = page.getViewport({ scale: scale });

                        // Prepare canvas using PDF page dimensions
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.height = scaledViewport.height;
                        canvas.width = scaledViewport.width;

                        // Render PDF page into canvas context
                        const renderContext = {
                            canvasContext: context,
                            viewport: scaledViewport
                        };
                        const renderTask = page.render(renderContext);
                        renderTask.promise.then(function() {
                            pdfViewer.empty(); // Clear previous content
                            pdfViewer.append(canvas); // Append the canvas with the PDF page
                        });
                    });
                });
            }

            // Handle file input change
            $('#licensePath').on('change', function(event) {
                const file = event.target.files[0];
                if (file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        renderPDF({ data: new Uint8Array(e.target.result) });
                    };
                    reader.readAsArrayBuffer(file); // Read the file as an ArrayBuffer
                } else {
                    alert('Please upload a valid PDF file.');
                }
            });

            // Render existing PDF if exists
            const existingPDFUrl = "{{ asset('storage/drivingSchoolLicensePDF/' . $license->licensePath) }}";
            if (existingPDFUrl) {
                renderPDF(existingPDFUrl);
            }
        });
    </script>
@endsection