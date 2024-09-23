@extends('layouts.relative')

@section('content')
    <div class="flex flex-col justify-center items-center w-full h-full">
        <div class="swiper w-full">
            <div class="swiper-wrapper">
                <div class="swiper-slide w-full h-full flex-shrink-0 p-6 lg:py-20 lg:px-72 pb-[6.5rem]">
                    {{-- Headers --}}
                    <div class="flex flex-col gap-2">
                        <h1 class="text-2xl/tight lg:text-4xl lg:text-center text-custom-dark font-encode tracking-tight font-semibold">Pembayaran Kursus</h1>
                        <p class="text-custom-grey lg:text-center text-lg/tight lg:text-xl/tight font-league">Pembayaran kursus dapat dilakukan ditempat atau transfer menggunakan aplikasi m-Banking melalui vendor-vendor berikut ini:</p>
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
                                            {{-- Step by Step Transaction with BCA --}}
                                            @case('BCA')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BCA Mobile"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih <span class="font-semibold">"m-Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih <span class="font-semibold">"Transfer Antar Rekening"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Isi tujuan rekening menjadi <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Masukkan pin m-BCA untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>
                                            @break
                                            
                                            {{-- Step by Step Transaction with BNI --}}
                                            @case('BNI')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BNI Mobile Banking"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Kemudian pilih <span class="font-semibold">"Antar Rekening BNI"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Selanjutnya pilih <span class="font-semibold">"Input Rekening Baru"</span></p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isi tujuan rekening sebagai <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer. Kemudian klik "YA"</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Masukkan password untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 8th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">8.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>
                                            @break

                                            {{-- Step by Step Transaction with BRI --}}
                                            @case('BRI')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BRImo"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Klik <span class="font-semibold">"Tambah Penerima"</span>. Kemudian, pilih <span class="font-semibold">"Bank BRI"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Lanjut"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Masukkan pin BRImo untuk menyelesaikan transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with Mandiri --}}
                                            @case('Mandiri')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"Livin' by Mandiri"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih <span class="font-semibold">"Transfer ke Tujuan Baru"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih Bank Tujuan <span class="font-semibold">"Bank Mandiri"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Lanjut"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer. Dan klik "Lanjut"</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Masukkan pin Livin' by Mandiri anda untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with Mega --}}
                                            @case('Mega')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"M-Smile"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih <span class="font-semibold">"Transfer ke Bank Lain"</span>. Kemudian, pilih <span class="font-semibold">"BI-Fast"</span> sebagai metode Transfer</p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Lanjut"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Ikuti langkah selanjutnya untuk menyelesaikan transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with BTN --}}
                                            @case('BTN')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BTN Mobile"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih <span class="font-semibold">"Transfer BTN"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Lanjut"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Klik tombol "Kirim" kemudian Masukkan pin BTN Mobile untuk menyelesaikan transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with Jatim --}}
                                            @case('Jatim')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke internet banking Bank Jatim</p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Manajemen Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih <span class="font-semibold">"Rek. Bank Jatim"</span>. Kemudian, klik tombol <span class="font-semibold">"Tambah"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nama alias <span class="font-semibold">{{ $payment->payment_receiver_name }}</span> dan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Konfirmasi" dan "Kirim"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Kembali ke menu <span class="font-semibold">"Manajemen Transfer"</span> dan pilih sub menu <span class="font-semibold">Transfer Antar Rekening Bank</span></p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Pilih Rekening Asal Anda, kemudian isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Pilih Rekening Tujuan yang baru saja didaftarkan sebelumnya</p>
                                                </div>
                                                {{-- 8th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">8.</p>
                                                    <p class="">Pilih Mode Instruksi <span class="font-semibold">"Langsung"</span> kemudian Konfirmasi transaksi</p>
                                                </div>
                                                {{-- 9th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">9.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with BSI --}}
                                            @case('Syariah Indonesia (BSI)')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BSI Mobile"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"BI Fast"</span> dan pilih menu <span class="font-semibold">"Transfer BI Fast"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Lanjut"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isikan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Ikuti arahan selanjutnya untuk menyelesaikan transaksi</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with BCA Syariah --}}
                                            @case('BCA Syariah')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BCA Syariah Mobile"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer ke BCA Syariah" kemudian klik tombol <span class="font-semibold">"+ Tambah"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan nama alias <span class="font-semibold">{{ $payment->payment_receiver_name }}</span> dan nomor rekening <span class="font-semibold">"{{ $payment->payment_address }}"</span>. Kemudian tekan "Konfirmasi" dan "Kirim"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Jika berhasil, pilih nomor rekening yang baru saja ditambahkan</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Isi nominal transaksi sebagai <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span></p>
                                                </div>
                                                {{-- 8th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">8.</p>
                                                    <p class="">Masukkan pin transaksi anda untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 9th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">9.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>    
                                            @break

                                            {{-- Step by Step Transaction with BNI Syariah --}}
                                            @case('BNI Syariah')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BNI Mobile Banking"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Kemudian pilih <span class="font-semibold">"Antar Rekening BNI"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Selanjutnya pilih <span class="font-semibold">"Input Rekening Baru"</span></p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Isi tujuan rekening sebagai <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer. Kemudian klik "YA"</p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Masukkan password untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 8th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">8.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>
                                            @break

                                            {{-- Step by Step Transaction with BRI Syariah --}}
                                            @case('BRI Syariah')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"BRIS"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer ke sesama BRIS"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Isi tujuan rekening sebagai <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer. Kemudian klik "YA"</p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Masukkan pin untuk mengkonfirmasi transaksi</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">8.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>
                                            @break

                                            {{-- Step by Step Transaction with Jenius --}}
                                            @case('Jenius')
                                                {{-- 1st Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">1.</p>
                                                    <p class="">Login ke aplikasi <span class="font-semibold">"Jenius"</span></p>
                                                </div>
                                                {{-- 2nd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">2.</p>
                                                    <p class="">Pilih menu <span class="font-semibold">"Transfer & Bayar"</span> lalu pilih <span class="font-semibold">"Kirim Uang"</span></p>
                                                </div>
                                                {{-- 3rd Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">3.</p>
                                                    <p class="">Pilih <span class="font-semibold">"+ Tambah Penerima"</span></p>
                                                </div>
                                                {{-- 4th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">4.</p>
                                                    <p class="">Pilih Bank Jenius kemudian isi tujuan rekening sebagai <span class="font-semibold">"{{ $payment->payment_address }}"</span></p>
                                                </div>
                                                {{-- 5th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">5.</p>
                                                    <p class="">Masukkan <span class="font-semibold">"Rp. {{ number_format($enrollment->course->course_price, 0, ',', '.') }},-"</span> sebagai nominal transfer. Kemudian klik "Lanjut"</p>
                                                </div>
                                                {{-- 6th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">6.</p>
                                                    <p class="">Tekan tombol <span class="font-semibold">"Kirim Uang"</span></p>
                                                </div>
                                                {{-- 7th Step --}}
                                                <div class="flex flex-row gap-2 items-start font-league font-normal text-custom-dark text-base/tight lg:text-lg/tight">
                                                    <p class="w-6 text-center flex-shrink-0">7.</p>
                                                    <p class="">Screenshot Bukti Pembayaran dan Unggah ke Aplikasi KEMUDI</p>
                                                </div>
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

                    {{-- Button Groups for Desktop View --}}
                    <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-end bg-custom-white hidden">
                        <button type="button" class="next-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Unggah Bukti Pembayaran</button>
                    </div>
                </div>

                {{-- Upload Course Payment Receipt Form --}}
                <div class="swiper-slide w-full flex-shrink-0 p-6 lg:py-20 lg:px-72 pb-[6.5rem]">
                    {{-- Headers --}}
                    <div class="flex flex-col gap-2">
                        <h1 class="text-2xl/tight lg:text-4xl text-center text-custom-dark font-encode tracking-tight font-semibold">Pembayaran Kursus</h1>
                        <p class="text-custom-grey text-center text-lg/tight lg:text-xl/tight font-league">Pembayaran kursus dapat dilakukan ditempat atau transfer menggunakan aplikasi m-Banking melalui vendor-vendor berikut ini:</p>
                    </div>

                    {{-- Button Groups for Desktop View --}}
                    <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-end bg-custom-white hidden">
                        <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Unggah Bukti Pembayaran</button>
                    </div>
                </div>
            </div>

            {{-- Sticky Button Groups for Mobile --}}
            <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden" id="mobile-button-groups">
                <button type="button" class="next-button w-full px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Unggah Bukti Pembayaran</button>
                <button type="submit" id="mobileSubmitButton" class="hidden w-full px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Kirim Bukti Pembayaran</button>
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
        });

        // Function to open Accordion
        $('.accordion-button').click(function() {
            const content = $(this).closest('h2').next('div');
            const arrowDown = $(this).find('.arrow-down');
            const arrowUp = $(this).find('.arrow-up');

            content.toggleClass('hidden');
            arrowDown.toggleClass('hidden');
            arrowUp.toggleClass('hidden'); 

            $(this).attr('aria-expanded', content.is(':visible')); 

            // Update Swiper to recalculate height
            swiper.update();
        });
    </script>
@endsection