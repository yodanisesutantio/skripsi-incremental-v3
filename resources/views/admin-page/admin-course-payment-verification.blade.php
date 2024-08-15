@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Bukti Pembayaran Kursus</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Diunggah pada {{ $enrollment->coursePayment->created_at->translatedFormat('d F Y') }}, Pukul {{ $enrollment->coursePayment->created_at->translatedFormat('H : i') }} WIB</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Bukti Pembayaran Kursus</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Diunggah pada {{ $enrollment->coursePayment->created_at->translatedFormat('d F Y') }}, Pukul {{ $enrollment->coursePayment->created_at->translatedFormat('H : i') }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:mt-7 lg:px-24">
            <div class="flex flex-col gap-4 lg:gap-6 my-3 mx-6 lg:mx-0 p-6 bg-custom-white-hover rounded-lg lg:rounded-xl">
                <div class="flex flex-col gap-1">
                    <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">Bukti Pembayaran</h2>
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Tekan Gambar untuk melihat lebih detail</p>
                </div>

                {{-- Payment File Data --}}
                <a href="{{ asset('storage/paymentFile/' . $enrollment->coursePayment->paymentFile) }}" target="_blank" class="drop-shadow lg:hover:drop-shadow-lg duration-300">
                    <img src="{{ asset('storage/paymentFile/' . $enrollment->coursePayment->paymentFile) }}" alt="Bukti Pembayaran" class="w-full aspect-auto object-cover">
                </a>
            </div>

            {{-- Open Modals to Verify --}}
            @if ($enrollment->coursePayment->paymentStatus === 1)
                <div class="px-6 w-full fixed bottom-6 lg:px-0 lg:mt-6 lg:static">
                    <div id="alreadyVerified" class="select-none opacity-40 py-3 w-full rounded-lg lg:rounded-lg bg-custom-success hover:bg-custom-success/85 text-center lg:text-lg text-custom-white font-semibold duration-500">Verifikasi Pembayaran</div>
                </div>
            @else
                <div class="px-6 w-full fixed bottom-6 lg:px-0 lg:mt-6 lg:static">
                    <button type="button" id="openVerifyModals" class="py-3 w-full rounded-lg lg:rounded-lg bg-custom-success hover:bg-custom-success/85 text-center lg:text-lg text-custom-white font-semibold duration-500">Verifikasi Pembayaran</button>
                </div>
            @endif
        </div>
    </div>

    {{-- Verify Confirmation Overlay --}}
    <div id="verifyPaymentOverlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Verify Confirmation --}}
        <div id="verifyPaymentDialogBox" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                {{-- Modals Header --}}
                <h2 class="font-encode text-xl/tight pt-1 lg:text-3xl font-semibold text-custom-dark ">Verifikasi Pembayaran?</h2>
                <button type="button" id="XVerifyPaymentDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>

            {{-- Verify Confirmation Message --}}
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Peringatan: Konfirmasi pembayaran ini bersifat final dan tidak dapat dibatalkan. Periksa kembali data pembayaran sebelum melanjutkan.</p>
            </div>

            {{-- Action Groups --}}
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeVerifyPaymentDialogBox" class="w-fit rounded text-left p-3 text-sm/tight lg:text-base/tight text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesVerifyPayment" class="w-fit rounded text-left px-5 py-3 text-sm/tight lg:text-base/tight whitespace-nowrap bg-custom-success hover:bg-custom-success/85 text-custom-white font-semibold duration-300">Ya, Verifikasi</button>
                <form action="{{ url('/verify-payment/' . $enrollment->coursePayment->id) }}" id="verifyPaymentForm" method="post" class="mb-1 hidden">
                    @csrf
                    <input type="hidden" name="paymentStatus" value="1">
                </form>
            </div>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });

        // Open Confirmation Dialog Box
        $('#openVerifyModals').click(function(event) {
            $('#verifyPaymentOverlay').removeClass('hidden');
            $('#verifyPaymentOverlay').addClass('flex');
        });

        // Confirm Verify Payment
        $('#yesVerifyPayment').click(function(event) {
            event.preventDefault();
            $('#yesVerifyPayment').next().submit();
        });

        // Close Dialog Box
        $('#XVerifyPaymentDialogBox, #closeVerifyPaymentDialogBox').click(function(event) {
            $('#verifyPaymentOverlay').addClass('hidden');
            $('#verifyPaymentOverlay').removeClass('flex');
        });

        // Error Toastr Message to Show When Users force to click the verify button when it is already verified
        $('#alreadyVerified').on('click', function() {
            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.info('Anda Sudah Memverifikasi Pembayaran!');
        });
    </script>
@endsection