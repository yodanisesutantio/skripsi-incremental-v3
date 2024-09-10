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

            @if ($enrollment->coursePayment->paymentStatus === 0)
                {{-- Open Modals to Verify --}}
                <a href="{{ url('https://wa.me/' . $enrollment->course->admin->phone_number) }}" class="px-6 w-full fixed bottom-6 lg:px-0 lg:mt-6 lg:static">
                    <button type="button" id="openVerifyModals" class="py-3 w-full rounded-lg lg:rounded-lg border border-custom-green bg-custom-white hover:bg-custom-green text-center lg:text-lg text-custom-green hover:text-custom-white font-semibold duration-500">Minta Verifikasi ke Admin</button>
                </a>
            @endif
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
    </script>
@endsection