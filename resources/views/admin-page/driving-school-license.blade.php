@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Izin Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Berikut Daftar Izin Kursus Anda!</p>

    <div class="flex">
        <a href="admin-driving-school-license/create"><div class="w-fit px-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">Unggah Izin Baru</div></a>
    </div>

    <h2 class="text-xl lg:text-2xl/snug mt-6 mb-3 lg:mt-6 lg:mb-3 text-custom-dark font-encode font-semibold">Izin Aktif</h2>
    @if ($activeLicense)
        <a href="{{ asset('storage/drivingSchoolLicensePDF/' . $activeLicense->licensePath) }}" class="w-full lg:w-[30rem] rounded-xl mb-6 drop-shadow-lg" target="_blank">
            <!-- Display the PDF thumbnail if it exists -->
            <div class="flex flex-col items-center justify-center w-full lg:w-[30rem] h-[12rem] lg:h-[18rem] bg-cover bg-center hover:bg-custom-dark/40 overflow-hidden duration-300" id="licensePath_wrapper">
                <div id="pdfViewer" class="w-full h-full"></div>
            </div>

            <div class="flex flex-row p-3 bg-custom-white-hover w-full lg:w-[30rem] font-league text-custom-dark">
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-base lg:text-lg mt-1">Tanggal Awal Berlaku :</p>
                    <h3 class="text-custom-dark font-encode font-semibold text-lg lg:text-xl">{{ $activeLicense->formattedStartDate }}</h3>
                </div>
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-right text-base lg:text-lg mt-1">Tanggal Akhir Berlaku :</p>
                    <h3 class="text-custom-dark font-encode font-semibold text-right text-lg lg:text-xl">{{ $activeLicense->formattedEndDate }}</h3>
                </div>
            </div>
        </a>
    @else
        <p class="font-league text-center px-5 lg:text-xl my-20 lg:my-14">(Anda tidak mempunyai Izin Aktif, <a href="admin-driving-school-license/create" class="font-semibold text-custom-green underline">Unggah Izin Baru Sekarang</a>)</p>
    @endif

    <h2 class="text-xl lg:text-2xl/snug mt-10 mb-3 lg:mt-10 lg:mb-3 text-custom-dark font-encode font-semibold">Daftar Izin Kursus Lampau</h2>
    <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Daftar Izin Kursus kosong)</p>

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
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
            const existingPDFUrl = "{{ asset('storage/drivingSchoolLicensePDF/' . $activeLicense->licensePath) }}";
            if (existingPDFUrl) {
                renderPDF(existingPDFUrl);
            }
        });
    </script>
@endsection