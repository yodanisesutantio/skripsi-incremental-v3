@extends('layouts.relative')

@section('content')
    {{-- Mobile View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Metode Pembayaran</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Daftarkan satu Rekening Pembayaran anda. Anda dapat menambahkan lebih dari satu Rek. Pembayaran lagi nanti.</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop View Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Metode Pembayaran</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Daftarkan satu Rekening Pembayaran anda. Anda dapat menambahkan lebih dari satu Rek. Pembayaran lagi nanti.</p>
            </div>
        </div>
        
        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('/new-driving-school/payment-method') }}" method="post" class="px-6 pb-24 lg:pb-0" id="payment-method-form">
                @csrf

                <div class="form-wrapper new-payment-method">
                    {{-- Form Sub Headers --}}
                    <div class="flex flex-row w-full justify-between lg:mt-8 mb-4">
                        <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Bank Baru</h2>
                    </div>
    
                    <div class="flex flex-col gap-5 lg:gap-7">    
                        {{-- Select Bank Name --}}
                        <div class="flex flex-col gap-2">
                            {{-- Dropdown --}}
                            <label for="payment_vendor" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Metode Pembayaran<span class="text-custom-destructive">*</span></label>
                            <select name="payment_vendor" id="payment_vendor" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_vendor') border-2 border-custom-destructive @enderror">
                                <option disabled selected>-- Metode Pembayaran --</option>
                                <option value="BCA">Bank BCA</option>
                                <option value="BNI">Bank BNI</option>
                                <option value="BRI">Bank BRI</option>
                                <option value="Mandiri">Bank Mandiri</option>
                                <option value="Mega">Bank Mega</option>
                                <option value="BTN">Bank BTN</option>
                                <option value="Jatim">Bank Jatim</option>
                                <option value="BCA Syariah">Bank BCA Syariah</option>
                                <option value="BNI Syariah">Bank BNI Syariah</option>
                                <option value="BRI Syariah">Bank BRI Syariah</option>
                                <option value="Jenius">Jenius</option>
                            </select>
                            @error('payment_vendor')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- Input Receiver Name --}}
                        <div class="flex flex-col gap-2">
                            <label for="payment_receiver_name" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nama Pemilik Akun Pembayaran<span class="text-custom-destructive">*</span></label>
                            <input type="text" name="payment_receiver_name" id="payment_receiver_name" placeholder="Nama Lengkap Pemilik Akun Pembayaran" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_receiver_name') border-2 border-custom-destructive @enderror">
                            @error('payment_receiver_name')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
    
                        {{-- Input Payment Address --}}
                        <div class="flex flex-col gap-2">
                            <label for="payment_address" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nomor Rekening Pembayaran<span class="text-custom-destructive">*</span></label>
                            <input type="text" name="payment_address" id="payment_address" placeholder="No. Rekening" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_address') border-2 border-custom-destructive @enderror">
                            @error('payment_address')
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/new-driving-school/account-info') }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
                    {{-- Submit Button --}}
                    <button type="submit" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-col gap-3 fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden" id="mobile-button-groups">
        <button type="submit" id="mobileSubmitButton" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
        <a href="{{ url('/user-profile') }}" class="text-custom-dark font-league font-medium px-1 pt-5 pb-4 text-lg/none underline hover:text-custom-green-hover">Kembali</a>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#payment-method-form').submit();
        });
    </script>
@endsection