@extends('layouts.relative')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-full">
        <div class="swiper">
            <div class="swiper-wrapper">
                @if ($enrollment->coursePayment)
                    <div class="swiper-slide p-6">
                        {{-- Headers --}}
                        <div class="flex flex-col gap-2">
                            <h1 class="text-2xl/tight lg:text-4xl text-center text-custom-dark font-encode tracking-tight font-semibold">Pembayaran Kursus</h1>
                            <p class="text-custom-grey text-center text-lg/tight lg:text-xl/tight font-league">Pembayaran kursus dapat dilakukan ditempat atau transfer melalui vendor-vendor berikut ini:</p>
                        </div>

                        {{-- Payment Vendor Dropdowns --}}
                        <div class="flex flex-col gap-5 mt-6">
                            @foreach ($paymentMethod as $payment)
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
                                <div id="collapseOne" class="bg-custom-green-hover rounded-b-lg relative z-0 -mt-1.5 text-base/tight lg:text-lg/tight pt-6 pb-5 px-4 hidden">
                                    <div class="flex flex-col gap-4 lg:gap-6">
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
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