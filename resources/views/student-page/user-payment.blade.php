@extends('layouts.relative')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-svh lg:h-lvh">
        <div class="swiper">
            <div class="swiper-wrapper">
                @if ($enrollment->coursePayment)
                    <div class="swiper-slide p-6">
                        {{-- Headers --}}
                        <div class="flex flex-col gap-2">
                            <h1 class="text-2xl/tight lg:text-4xl text-center text-custom-dark font-encode tracking-tight font-semibold">Pembayaran Kursus</h1>
                            <p class="text-custom-grey text-center text-lg/tight lg:text-xl/tight font-league">Pembayaran kursus dapat dilakukan ditempat atau transfer menggunakan aplikasi m-Banking melalui vendor-vendor berikut ini:</p>
                        </div>

                        {{-- Payment Vendor Dropdowns --}}
                        <div class="flex flex-col gap-4 mt-6">
                            @foreach ($paymentMethod as $payment)
                                <div class="text-custom-dark relative">
                                    {{-- Accordion Button --}}
                                    <h2 class="font-medium text-lg/tight lg:text-2xl/tight relative z-10 p-4 bg-custom-white-hover drop-shadow rounded-lg">
                                        <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                                            <div class="flex flex-row items-center gap-3">
                                                {{-- Payment Vendor Icon --}}
                                                <img src="{{ asset('img/payment-vendor-icon/Bank-' . $payment->payment_vendor . '.webp') }}" alt="Bank : {{ $payment->payment_vendor }}" class="w-8 h-8 object-contain">

                                                <p class="font-league">Bank {{ $payment->payment_vendor }}</p>
                                            </div>

                                            {{-- Arrow Down --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-down flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#231F20" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 6l-7-6"/></svg>

                                            {{-- Arrow Up --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden arrow-up flex-shrink-0" width="28" height="28" viewBox="0 0 24 24"><path fill="none" stroke="#231F20" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 15l-7-6l-7 6"/></svg>
                                        </button>
                                    </h2>

                                    {{-- Accordion Content --}}
                                    <div id="collapseOne" class="bg-custom-white-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 drop-shadow shadow-inner hidden">
                                        <div class="flex flex-col gap-4 lg:gap-6">
                                            @switch($payment->payment_vendor)
                                                @case('BCA')
                                                    {{-- 1st Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">1.</p>
                                                        <p class="">Login ke aplikasi <span class="font-semibold">"BCA Mobile"</span></p>
                                                    </div>
                                                    {{-- 2nd Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">2.</p>
                                                        <p class="">Pilih <span class="font-semibold">"m-Transfer"</span></p>
                                                    </div>
                                                    {{-- 3rd Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">3.</p>
                                                        <p class="">Pilih <span class="font-semibold">"Transfer Antar Rekening"</span></p>
                                                    </div>
                                                    {{-- 4th Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">4.</p>
                                                        <p class="">Isi tujuan rekening menjadi <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                    </div>
                                                    {{-- 5th Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">5.</p>
                                                        <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                    </div>
                                                    {{-- 6th Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">6.</p>
                                                        <p class="">Masukkan pin m-BCA untuk mengkonfirmasi transaksi</p>
                                                    </div>
                                                    {{-- 7th Step --}}
                                                    <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                        <p class="w-6 text-center">7.</p>
                                                        <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                    </div>
                                                @break
                                                
                                                @case('BNI')
                                                    
                                                @break

                                                @case('BRI')
                                                    
                                                @break

                                                @case('Mandiri')
                                                    
                                                @break

                                                @case('Mega')
                                                    
                                                @break

                                                @case('BTN')
                                                    
                                                @break

                                                @case('Jatim')
                                                    
                                                @break

                                                @case('Syariah Indonesia (BSI)')
                                                    
                                                @break

                                                @case('BCA Syariah')
                                                    
                                                @break

                                                @case('BNI Syariah')
                                                    
                                                @break

                                                @case('BRI Syariah')
                                                    
                                                @break

                                                @case('Jenius')
                                                    
                                                @break

                                                @default
                                                    <!-- Default case for unrecognized vendors -->
                                                    <p class="">Vendor tidak dikenali.</p>
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="px-6 w-full fixed bottom-6 lg:px-0 lg:mt-6 lg:static">
                <button type="button" id="openVerifyModals" class="py-3 w-full rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">Unggah Bukti Pembayaran</button>
            </div>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Function to open Accordion
        $('.accordion-button').click(function() {
            const content = $(this).closest('h2').next('div');
            const arrowDown = $(this).find('.arrow-down');
            const arrowUp = $(this).find('.arrow-up');

            content.toggleClass('hidden');
            arrowDown.toggleClass('hidden');
            arrowUp.toggleClass('hidden'); 

            $(this).attr('aria-expanded', content.is(':visible')); 
        });
    </script>
@endsection