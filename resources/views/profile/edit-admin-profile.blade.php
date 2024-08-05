@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Edit Profil</h1>
            <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Perbarui informasi akun anda</p>
        </div>
        {{-- Tabs --}}
        <div class="overflow-x-auto" style="scrollbar-width: none;">
            <ul class="flex flex-row gap-5 font-league text-custom-dark text-lg font-medium text-center">
                {{-- Account Info --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 border-b-2 font-semibold text-custom-green border-custom-green opacity-100 ml-6" id="accountInfoButton">Informasi Akun</button>
                </li>
                {{-- Payment Method --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="paymentMethodButton">Pembayaran Kursus</button>
                </li>
                {{-- Keamanan Akun --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40 mr-6" id="securityButton">Keamanan Akun</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Edit Profil</h1>
                <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Perbarui informasi akun anda</p>
            </div>
        </div>
        
        <div class="lg:col-span-2 lg:px-24">
            {{-- Tabs --}}
            <div class="overflow-x-auto lg:mx-6 lg:pt-8 lg:mb-6 hidden lg:block" style="scrollbar-width: none;">
                <ul class="flex flex-row lg:gap-8 font-league text-custom-dark text-lg lg:text-xl font-medium text-center">
                    {{-- Account Info --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 border-b-2 font-semibold text-custom-green border-custom-green opacity-100" id="accountInfoLargeButton">Informasi Akun</button>
                    </li>
                    {{-- Payment Method --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="paymentMethodLargeButton">Pembayaran Kursus</button>
                    </li>
                    {{-- Keamanan Akun --}}
                    <li class="whitespace-nowrap rounded-lg duration-300">
                        <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40" id="securityLargeButton">Keamanan Akun</button>
                    </li>
                </ul>
            </div>

            @php
                $currentSlide = 1; // Initial slide index
            @endphp

            <div class="swiper">
                <div class="swiper-wrapper">
                    {{-- Account Info Form --}}
                    <div class="swiper-slide overflow-y-auto">
                        <form action="/edit-admin-account-info" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pb-0">
                            @csrf
                            {{-- Form Sub Headers --}}
                            <div class="mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Kesediaan Lembaga Kursus</h2>
                            </div>
                            {{-- Active Checkbox --}}
                            <div class="flex flex-col gap-2">
                                {{-- Dropdown --}}
                                <label for="availability" class="text-custom-grey text-lg/tight font-league lg:text-xl">Untuk anda dapat menerima siswa pastikan anda memilih opsi "Bersedia"</label>
                                <select name="availability" id="availability" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg">
                                    <option value="1" {{ auth()->user()->availability ? 'selected' : '' }}>Bersedia</option>
                                    <option value="0" {{ !auth()->user()->availability ? 'selected' : '' }}>Tidak Bersedia</option>
                                </select>
                            </div>
                    
                            {{-- Form Sub Headers --}}
                            <div class="flex flex-col gap-1 mt-8 mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Data Lembaga Kursus</h2>
                            </div>
                            <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                                {{-- Input Profile Picture --}}
                                <div class="flex flex-col gap-2">
                                    <label for="hash_for_profile_picture" class="font-semibold font-league text-xl text-custom-grey">Gambar Profil (Optional)</label>
                                    @if (auth()->user()->hash_for_profile_picture)
                                        <label for="hash_for_profile_picture" class="relative w-fit">
                                            <div class="p-2 w-fit rounded-full bg-custom-disabled-dark/90 absolute bottom-0 right-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#F7F7F7" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
                                            </div>
                                            <div class="w-28 lg:w-32 h-28 lg:h-32 rounded-full bg-cover bg-center cursor-pointer overflow-hidden" style="background-image: url('{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}')" id="profilePicture">
                                                <div class="flex items-center justify-center w-full h-full hover:bg-custom-dark/50 duration-300">
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" name="hash_for_profile_picture" id="hash_for_profile_picture" class="font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 hidden">
                                    @else
                                        <label for="hash_for_profile_picture" class="relative w-fit">
                                            <div class="p-2 w-fit rounded-full bg-custom-disabled-dark/90 absolute bottom-0 right-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#F7F7F7" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
                                            </div>
                                            <div class="w-28 lg:w-32 h-28 lg:h-32 rounded-full bg-cover bg-center cursor-pointer overflow-hidden" style="background-image: url('{{ asset('img/blank-profile.webp') }}')" id="profilePicture">
                                                <div class="flex items-center justify-center w-full h-full hover:bg-custom-dark/50 duration-300">
                                                </div>
                                            </div>
                                        </label>
                                        <input type="file" name="hash_for_profile_picture" id="hash_for_profile_picture" class="font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 hidden">
                                    @endif
                                    @error('hash_for_profile_picture')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Full Name --}}
                                <div class="flex flex-col gap-2">
                                    <label for="fullname" class="font-semibold font-league text-xl text-custom-grey">Nama Lembaga Kursus<span class="text-custom-destructive">*</span></label>
                                    <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('fullname') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->fullname }}">
                                    @error('fullname')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Username --}}
                                <div class="flex flex-col gap-2">
                                    <label for="username" class="font-semibold font-league text-xl text-custom-grey">Username<span class="text-custom-destructive">*</span></label>
                                    <input type="text" name="username" id="username" placeholder="user_name_123" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('username') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->username }}">
                                    @error('username')
                                        @if ($message === 'The username has already been taken.')
                                            <span class="text-custom-destructive">{{ $message }}</span>    
                                        @else
                                            <span class="text-custom-destructive">{{ $message }}</span>
                                        @endif
                                    @enderror
                                </div>
                                {{-- Input Description --}}
                                <div class="flex flex-col gap-2">
                                    <label for="description" class="font-semibold font-league text-xl text-custom-grey">Deskripsi (opsional)</label>
                                    <textarea name="description" id="description" rows="5" placeholder="Buat personal anda menarik" class="px-4 py-3.5 h-36 font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('description') border-2 border-custom-destructive @enderror">{{ auth()->user()->description }}</textarea>
                                    @error('description')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Phone Number --}}
                                <div class="flex flex-col gap-2">
                                    <label for="phone_number" class="font-semibold font-league text-xl text-custom-grey">Nomor Whatsapp Aktif<span class="text-custom-destructive">*</span></label>
                                    <input type="tel" name="phone_number" id="phone_number" placeholder="081818181818" class="w-full p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('phone_number') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->phone_number }}" oninput="deleteAnyString(this)">
                                    @error('phone_number')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>

        
                    {{-- Payment Methods --}}
                    <div class="swiper-slide overflow-y-auto">
                        <form action="/edit-admin-payment-method" method="post" class="px-6 pb-24 lg:pb-0">
                            @csrf
        
                            @if ($paymentMethod && $paymentMethod->count() > 0)
                                <div id="existingPaymentMethods">
                                    @foreach ($paymentMethod as $index => $methodOfPayment)
                                        <div class="form-wrapper mb-8">
                                            {{-- Hidden Attribute --}}
                                            <input type="hidden" name="payment_methods[{{ $index }}][id]" value="{{ $methodOfPayment['id'] }}">
                                            <input type="hidden" name="payment_methods[{{ $index }}][admin_id]" value="{{ auth()->user()->id }}">
        
                                            {{-- Form Sub Headers --}}
                                            <div class="flex flex-row w-full justify-between mb-4">
                                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Bank {{ $methodOfPayment['payment_vendor'] }}</h2>
                                                @if ($paymentMethod->count() > 1)
                                                    <button type="button" class="removePaymentMethods" data-index="{{ $index }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#FD3124" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg>
                                                    </button>
                                                @endif
                                            </div>
        
                                            <div class="flex flex-col gap-5 lg:gap-7">
                                                {{-- is_active --}}
                                                <div class="flex flex-col gap-2">
                                                    {{-- Dropdown --}}
                                                    <label for="payment_methods[{{ $index }}][is_payment_active]" class="font-semibold font-league text-xl text-custom-grey">Pembayaran Aktif<span class="text-custom-destructive">*</span></label>
                                                    <select name="payment_methods[{{ $index }}][is_payment_active]" id="payment_methods[{{ $index }}][is_payment_active]" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg">
                                                        <option value="1" {{ $methodOfPayment['is_payment_active'] === 1 ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ $methodOfPayment['is_payment_active'] === 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>
        
                                                {{-- Select Bank Name --}}
                                                <div class="flex flex-col gap-2">
                                                    {{-- Dropdown --}}
                                                    <label for="payment_methods[{{ $index }}][payment_vendor]" class="font-semibold font-league text-xl text-custom-grey">Metode Pembayaran<span class="text-custom-destructive">*</span></label>
                                                    <select name="payment_methods[{{ $index }}][payment_vendor]" id="payment_methods[{{ $index }}][payment_vendor]" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg">
                                                        <option value="" disabled>-- Metode Pembayaran --</option>
                                                        <option value="BCA" {{ $methodOfPayment['payment_vendor'] === "BCA" ? 'selected' : '' }}>Bank BCA</option>
                                                        <option value="BNI" {{ $methodOfPayment['payment_vendor'] === "BNI" ? 'selected' : '' }}>Bank BNI</option>
                                                        <option value="BRI" {{ $methodOfPayment['payment_vendor'] === "BRI" ? 'selected' : '' }}>Bank BRI</option>
                                                        <option value="Mandiri" {{ $methodOfPayment['payment_vendor'] === "Mandiri" ? 'selected' : '' }}>Bank Mandiri</option>
                                                        <option value="Mega" {{ $methodOfPayment['payment_vendor'] === "Mega" ? 'selected' : '' }}>Bank Mega</option>
                                                        <option value="BTN" {{ $methodOfPayment['payment_vendor'] === "BTN" ? 'selected' : '' }}>Bank BTN</option>
                                                        <option value="Jatim" {{ $methodOfPayment['payment_vendor'] === "Jatim" ? 'selected' : '' }}>Bank Jatim</option>
                                                        <option value="BCA Syariah" {{ $methodOfPayment['payment_vendor'] === "BCA Syariah" ? 'selected' : '' }}>Bank BCA Syariah</option>
                                                        <option value="BNI Syariah" {{ $methodOfPayment['payment_vendor'] === "BNI Syariah" ? 'selected' : '' }}>Bank BNI Syariah</option>
                                                        <option value="BRI Syariah" {{ $methodOfPayment['payment_vendor'] === "BRI Syariah" ? 'selected' : '' }}>Bank BRI Syariah</option>
                                                        <option value="Jenius" {{ $methodOfPayment['payment_vendor'] === "Jenius" ? 'selected' : '' }}>Jenius</option>
                                                    </select>
                                                </div>
        
                                                {{-- Input Receiver Name --}}
                                                <div class="flex flex-col gap-2">
                                                    <label for="payment_methods[{{ $index }}][payment_receiver_name]" class="font-semibold font-league text-xl text-custom-grey">Nama Pemilik Akun Pembayaran<span class="text-custom-destructive">*</span></label>
                                                    <input type="text" name="payment_methods[{{ $index }}][payment_receiver_name]" id="payment_methods[{{ $index }}][payment_receiver_name]" placeholder="Nama Lengkap Pemilik Akun Pembayaran" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_methods.'.$index.'.payment_receiver_name') border-2 border-custom-destructive @enderror" value="{{ $methodOfPayment['payment_receiver_name'] }}">
                                                    @error('payment_methods.' . $index . '.payment_receiver_name')
                                                        <span class="text-custom-destructive">{{ $message }}</span>
                                                    @enderror
                                                </div>
        
                                                {{-- Input Payment Address --}}
                                                <div class="flex flex-col gap-2">
                                                    <label for="payment_methods[{{ $index }}][payment_address]" class="font-semibold font-league text-xl text-custom-grey">Nomor Rekening Pembayaran<span class="text-custom-destructive">*</span></label>
                                                    <input type="text" name="payment_methods[{{ $index }}][payment_address]" id="payment_methods[{{ $index }}][payment_address]" placeholder="No. Rekening" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_methods.'.$index.'.payment_address') border-2 border-custom-destructive @enderror" value="{{ $methodOfPayment['payment_address'] }}">
                                                    @error('payment_methods.' . $index . '.payment_address')
                                                        <span class="text-custom-destructive">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>        
                            @endif
                            
                            <button type="button" id="addPaymentMethods" class="px-6 py-3 w-full rounded-lg lg:rounded-lg border-2 border-custom-grey border-dashed bg-custom-disabled-light/60 hover:bg-custom-disabled-light text-center lg:text-lg text-custom-grey font-semibold lg:order-2 duration-500">+ Tambah Metode Pembayaran</button>
                        </form>
                    </div>
        
                    {{-- Security --}}
                    <div class="swiper-slide">
                        <form action="/edit-admin-password" method="post" class="px-6">
                            @csrf
                            {{-- Form Sub Headers --}}
                            <div class="mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Keamanan Akun</h2>
                            </div>
        
                            <div class="flex flex-col gap-5 lg:gap-7">
                                {{-- Input Password --}}
                                <div class="flex flex-col gap-2">
                                    <label for="password" class="font-semibold font-league text-xl text-custom-grey">Masukkan Password Baru</label>
                                    <div class="relative flex justify-end items-center">
                                        <input type="password" name="password" id="password" placeholder="Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                                        <div class="eyeIcon absolute mr-3" onclick="showHidePass()">
                                            <svg id="showPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#495D6477" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>
        
                                            <svg id="hidePass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('password')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                {{-- Confirm Password --}}
                                <div class="flex flex-col gap-2">
                                    <label for="password_confirmation" class="font-semibold font-league text-xl text-custom-grey">Ketik Ulang Password Baru`</label>
                                    <div class="relative flex justify-end items-center">
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik Ulang Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                                        <div class="eyeIcon absolute mr-3" onclick="showHideConfirmPass()">
                                            <svg id="showConfirmPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#495D6477" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>
        
                                            <svg id="hideConfirmPass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Button Groups for Desktop View --}}
            <div class="lg:flex flex-row w-full lg:mt-5 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                <a href="/admin-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                <button type="submit" id="submitEditProfileForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
                <button type="submit" id="submitEditPaymentForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
                <button type="submit" id="submitEditPasswordForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="/admin-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
        <button type="submit" id="submitEditProfileForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
        <button type="submit" id="submitEditPaymentForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
        <button type="submit" id="submitEditPasswordForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
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

        $('.submit-button').addClass('hidden');
        $('#submitEditProfileForms').removeClass('hidden');
        $('#accountInfoButton, #accountInfoLargeButton').on('click', function() {
            swiper.slideTo(0);
            $('.submit-button').addClass('hidden');
            $('#submitEditProfileForms').removeClass('hidden');
        });
        $('#paymentMethodButton, #paymentMethodLargeButton').on('click', function() {
            swiper.slideTo(1);
            $('.submit-button').addClass('hidden');
            $('#submitEditPaymentForms').removeClass('hidden');
        });
        $('#securityButton, #securityLargeButton').on('click', function() {
            swiper.slideTo(2);
            $('.submit-button').addClass('hidden');
            $('#submitEditPasswordForms').removeClass('hidden');
        });

        // Function to submit editProfile forms
        $('#submitEditProfileForms').on('click', function() {
            $('form[action="/edit-admin-account-info"]').submit();
        });

        // Function to submit editProfile forms
        $('#submitEditPaymentForms').on('click', function() {
            $('form[action="/edit-admin-payment-method"]').submit();
        });

        // Function to submit editProfile forms
        $('#submitEditPasswordForms').on('click', function() {
            $('form[action="/edit-admin-password"]').submit();
        });

        // Tel Input Script
        const phoneInputField = document.getElementById('phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        phoneInputField.addEventListener('keypress', function(event) {
            let value = input.value.replace(/\D/g, '');
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical input
            }
        });
        function deleteAnyString(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });

        // Show and Hide Password Input
        function showHidePass() {
            const $showPass = $('#showPass');
            const $hidePass = $('#hidePass');
            const $passwordInput = $('#password');

            if ($passwordInput.attr('type') === "password") {
                $showPass.css('display', 'block');
                $hidePass.css('display', 'none');
            } else {
                $showPass.css('display', 'none');
                $hidePass.css('display', 'block');
            }
            
            $passwordInput.attr('type', $passwordInput.attr('type') === "password" ? "text" : "password");
        }

        // Show and Hide Password Confirmation Input
        function showHideConfirmPass() {
            const $showConfirmPass = $('#showConfirmPass');
            const $hideConfirmPass = $('#hideConfirmPass');
            const $confirmPasswordInput = $('#password_confirmation');

            if ($confirmPasswordInput.attr('type') === "password") {
                $showConfirmPass.css('display', 'block');
                $hideConfirmPass.css('display', 'none');
            } else {
                $showConfirmPass.css('display', 'none');
                $hideConfirmPass.css('display', 'block');
            }
            
            $confirmPasswordInput.attr('type', $confirmPasswordInput.attr('type') === "password" ? "text" : "password");
        }

        // Assist the user to avoid adding space in their username
        $("#username").on("keydown input", function(event) {
            if (event.type === "keydown" && event.keyCode === 32) {
                event.preventDefault(); // Prevent space on keydown
            } else if (event.type === "input") {
                $(this).val($(this).val().replace(/\s/g, "")); // Remove spaces on input
            }
        });

        // Preview the uploaded profile picture
        $('#hash_for_profile_picture').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePicture').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                }
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });

        // Dynamic Forms
        let paymentMethodIndex = $('#existingPaymentMethods .form-wrapper').length; // Initialize with existing count
        $('#addPaymentMethods').on('click', function() {
            const $container = $('#existingPaymentMethods');
            const newMethod = `
            <div class="form-wrapper new-payment-method">
                {{-- Hidden Attribute --}}
                <input type="hidden" name="payment_methods[${paymentMethodIndex}][id]" value="">
                <input type="hidden" name="payment_methods[${paymentMethodIndex}][admin_id]" value="{{ auth()->user()->id }}">

                {{-- Form Sub Headers --}}
                <div class="flex flex-row w-full justify-between mb-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Bank Baru</h2>
                    <button type="button" class="removePaymentMethods" data-index="${paymentMethodIndex}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 24 24"><path fill="none" stroke="#FD3124" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg>
                    </button>
                </div>

                <div class="flex flex-col gap-5 lg:gap-7">
                    {{-- is_active --}}
                    <div class="flex flex-col gap-2">
                        {{-- Dropdown --}}
                        <label for="payment_methods[${paymentMethodIndex}][is_payment_active]" class="font-semibold font-league text-xl text-custom-grey">Pembayaran Aktif<span class="text-custom-destructive">*</span></label>
                        <select name="payment_methods[${paymentMethodIndex}][is_payment_active]" id="payment_methods[${paymentMethodIndex}][is_payment_active]" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- Select Bank Name --}}
                    <div class="flex flex-col gap-2">
                        {{-- Dropdown --}}
                        <label for="payment_methods[${paymentMethodIndex}][payment_vendor]" class="font-semibold font-league text-xl text-custom-grey">Metode Pembayaran<span class="text-custom-destructive">*</span></label>
                        <select name="payment_methods[${paymentMethodIndex}][payment_vendor]" id="payment_methods[${paymentMethodIndex}][payment_vendor]" class="px-3 py-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg">
                            <option value="" disabled selected>-- Metode Pembayaran --</option>
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
                    </div>

                    {{-- Input Receiver Name --}}
                    <div class="flex flex-col gap-2">
                        <label for="payment_methods[${paymentMethodIndex}][payment_receiver_name]" class="font-semibold font-league text-xl text-custom-grey">Nama Pemilik Akun Pembayaran<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="payment_methods[${paymentMethodIndex}][payment_receiver_name]" id="payment_methods[${paymentMethodIndex}][payment_receiver_name]" placeholder="Nama Lengkap Pemilik Akun Pembayaran" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_methods.'.$index.'.payment_receiver_name') border-2 border-custom-destructive @enderror" value="">
                        @error('payment_receiver_name')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Payment Address --}}
                    <div class="flex flex-col gap-2">
                        <label for="payment_methods[${paymentMethodIndex}][payment_address]" class="font-semibold font-league text-xl text-custom-grey">Nomor Rekening Pembayaran<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="payment_methods[${paymentMethodIndex}][payment_address]" id="payment_methods[${paymentMethodIndex}][payment_address]" placeholder="No. Rekening" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('payment_methods.'.$index.'.payment_address') border-2 border-custom-destructive @enderror" value="">
                        @error('payment_address')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            `;
            $container.append(newMethod);
            paymentMethodIndex++;
            swiper.update();

            // Hide the add button after adding a new payment method
            $(this).hide();
        });

        // jQuery function to remove payment methods
        $(document).on('click', '.removePaymentMethods', function() {
            const $formWrapper = $(this).closest('.form-wrapper'); // Get the form wrapper
            const paymentMethodId = $formWrapper.find('input[name*="[id]"]').val();

            // Add a hidden input to mark this payment method for deletion
            $('<input>').attr({
                type: 'hidden',
                name: 'payment_methods_to_delete[]',
                value: paymentMethodId
            }).appendTo('form');

            $formWrapper.remove(); // Remove the corresponding form-wrapper visually

            // Check the number of remaining payment methods
            const remainingMethods = $('#existingPaymentMethods .form-wrapper').length;

            // Show the add button again if no new payment method is present
            if ($('#existingPaymentMethods .new-payment-method').length === 0) {
                $('#addPaymentMethods').show(); // Show the add button if no new payment method exists
            }

            // If only one method remains, hide the remove button for that method
            if (remainingMethods <= 1) {
                $('#existingPaymentMethods .removePaymentMethods').hide(); // Hide all remove buttons if only one method remains
            } else {
                // Show the remove buttons for remaining methods
                $('#existingPaymentMethods .removePaymentMethods').show();
            }

            swiper.update(); // Update the Swiper instance
        });
    </script>
@endsection