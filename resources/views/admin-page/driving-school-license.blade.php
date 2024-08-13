@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl mt-5 lg:mt-10">Izin Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Berikut Daftar Izin Kursus Anda!</p>

    {{-- Add New License Buttons --}}
    <div class="flex">
        <a href="admin-driving-school-license/create"><div class="w-fit px-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">Unggah Izin Baru</div></a>
    </div>

    {{-- Active License Section --}}
    <h2 class="text-xl lg:text-2xl/snug mt-6 mb-3 lg:mt-6 lg:mb-3 text-custom-dark font-encode tracking-tight font-semibold">Izin Aktif</h2>
    {{-- If there's license that has "Aktif" licenseStatus, show it --}}
    @if ($activeLicense)
        <div class="flex flex-col w-full lg:w-fit rounded-xl mb-6 overflow-hidden drop-shadow-lg">
            {{-- Active Licenses Thumbnail --}}
            <img src="{{ asset('storage/drivingSchoolLicense/' . $activeLicense->licensePath) }}" alt="" class="w-full h-40 lg:h-60 object-cover object-top">
            <div class="flex flex-row p-3 lg:p-5 bg-custom-white-hover w-full lg:w-[30rem] font-league text-custom-dark">
                {{-- Start Active License Date --}}
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-base lg:text-lg mt-1">Tanggal Awal Berlaku :</p>
                    <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-lg lg:text-xl">{{ $activeLicense->formattedStartDate }}</h3>
                </div>
                {{-- End Active License Date --}}
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-right text-base lg:text-lg mt-1">Tanggal Akhir Berlaku :</p>
                    <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-right text-lg lg:text-xl">{{ $activeLicense->formattedEndDate }}</h3>
                </div>
            </div>
        </div>
    {{-- Show this if there's no license that has "Aktif" licenseStatus --}}
    @else
        <p class="font-league text-center px-5 lg:text-xl my-20 lg:my-14">(Anda tidak mempunyai Izin Aktif, <a href="admin-driving-school-license/create" class="font-semibold text-custom-green underline">Unggah Izin Baru Sekarang</a>)</p>
    @endif

    <h2 class="text-xl lg:text-2xl/snug mt-10 mb-3 lg:mt-10 lg:mb-3 text-custom-dark font-encode tracking-tight font-semibold">Daftar Izin Kursus Anda</h2>
    {{-- Show every saved license that this user has --}}
    @if ($licenses)
        <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6 mb-7 lg:mb-14">
            @foreach ($licenses as $listOfLicense)
                <div class="relative flex flex-col w-full rounded-xl overflow-hidden drop-shadow-lg">
                    {{-- Edit and Delete Button --}}
                    <div class="absolute top-3 right-3 flex flex-row gap-2">
                        {{-- View Document --}}
                        <a href="{{ asset('storage/drivingSchoolLicense/' . $listOfLicense['licensePath']) }}" class="bg-custom-dark/50 lg:hover:bg-custom-dark/80 flex-shrink-0 p-2.5 rounded-xl overflow-hidden duration-300" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><g fill="none" stroke="#F7F7F7" stroke-width="2"><path d="M3.275 15.296C2.425 14.192 2 13.639 2 12c0-1.64.425-2.191 1.275-3.296C4.972 6.5 7.818 4 12 4c4.182 0 7.028 2.5 8.725 4.704C21.575 9.81 22 10.361 22 12c0 1.64-.425 2.191-1.275 3.296C19.028 17.5 16.182 20 12 20c-4.182 0-7.028-2.5-8.725-4.704Z"/><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0Z"/></g></svg></a>
                        {{-- Delete Document --}}
                        @if ($listOfLicense['licenseStatus'] === "Aktif")
                            {{-- Unclickable Delete --}}
                            <div class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden opacity-25 cantDeleteLicenseButton""><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></div>
                        @else
                            {{-- Delete --}}
                            <button class="bg-custom-dark/50 lg:hover:bg-custom-dark/80 flex-shrink-0 p-2.5 rounded-xl overflow-hidden duration-300 deleteLicenseButton" data-id="{{ $listOfLicense['id'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></button>                            
                        @endif
                    </div>

                    {{-- Driving School License Document or should I say image --}}
                    <img src="{{ asset('storage/drivingSchoolLicense/' . $listOfLicense['licensePath']) }}" alt="Dokumen Izin Kursus" class="w-full h-40 lg:h-44 object-cover object-top">
                    
                    {{-- Driving School License Information --}}
                    <div class="flex flex-row flex-grow p-3 lg:p-5 bg-custom-white-hover w-full font-league text-custom-dark">
                        <div class="grid grid-cols-3 w-full">
                            {{-- License Status : "Belum Divalidasi", "Sudah Divalidasi", "Aktif", "Tidak Berlaku" --}}
                            <div class="flex flex-col">
                                <p class="text-custom-grey font-league font-medium text-base lg:text-lg mt-1">Status :</p>
                                <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-lg lg:text-xl">{{ $listOfLicense['licenseStatus'] }}</h3>
                            </div>
                            {{-- End Date of the licenses --}}
                            <div class="col-span-2 flex flex-col">
                                <p class="text-custom-grey font-league text-right font-medium text-base lg:text-lg mt-1">Tanggal Akhir Berlaku :</p>
                                <h3 class="text-custom-dark font-encode tracking-tight text-right font-semibold text-lg lg:text-xl">{{ $listOfLicense['formattedEndDate'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach        
        </div>
    @else
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Daftar Izin Kursus kosong)</p>        
    @endif

    @include('partials.footer')

    {{-- Delete License Overlay --}}
    <div id="deleteLicenseOverlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Delete License Confirmation --}}
        <div id="deleteLicenseDialogBox" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                {{-- Modals Header --}}
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Izin Kursus?</h2>
                <button type="button" id="XDeleteLicenseDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>

            {{-- Delete Confirmation Message --}}
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus izin kursus ini? Penghapusan bersifat permanen, pastikan anda sudah memiliki salinan dokumen terlebih dahulu.</p>
            </div>

            {{-- Action Groups --}}
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeDeleteLicenseDialogBox" class="w-fit rounded text-left p-3 text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesDeleteLicense" class="w-fit rounded text-left p-3 bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Hapus Izin Kursus</button>
                <form id="deleteLicenseForm" method="post" class="mb-1 hidden">
                    @method('delete')
                    @csrf
                </form>
            </div>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Delete License Handler
        let licenseId;

        // Get which license is user choose to delete
        $('.deleteLicenseButton').on('click', function() {
            licenseId = $(this).data('id');
            $('#deleteLicenseForm').attr('action', `/admin-delete-driving-school-license/${licenseId}`); // Setup the form links
            $('#deleteLicenseOverlay').removeClass('hidden');
            $('#deleteLicenseOverlay').addClass('flex');
        });

        // Close the Modals
        $('#XDeleteLicenseDialogBox, #closeDeleteLicenseDialogBox').on('click', function() {
            $('#deleteLicenseOverlay').addClass('hidden');
            $('#deleteLicenseOverlay').removeClass('flex');
        });

        // Handle the form submission, if users clicked yes, then the license will be deleted
        $('#yesDeleteLicense').on('click', function (e) {
            e.preventDefault();
            $('#deleteLicenseForm').submit();
        });

        // Error Toastr Message to Show When Users force to click the delete button when it cant be deleted
        $('.cantDeleteLicenseButton').on('click', function() {
            toastr.options.timeOut = 8000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.info('Anda dapat menghubungi admin KEMUDI untuk tindakan lebih lanjut');
            toastr.warning('Anda tidak bisa menghapus izin yang sedang aktif!');
        });
    </script>
@endsection