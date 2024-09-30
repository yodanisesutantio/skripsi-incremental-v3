@extends('layouts.relative')

@section('content')
    {{-- Mobile View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Edit Profil</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Perbarui informasi akun anda</p>
        </div>
        {{-- Tabs --}}
        <div class="overflow-x-auto" style="scrollbar-width: none;">
            <ul class="flex flex-row gap-5 font-league text-custom-dark text-lg font-medium text-center">
                {{-- Account Info --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 border-b-2 font-semibold text-custom-green border-custom-green opacity-100 ml-6" id="accountInfoButton">Informasi Akun</button>
                </li>
                {{-- Keamanan Akun --}}
                <li class="whitespace-nowrap rounded-lg duration-300">
                    <button class="lg:hover:bg-custom-grey/25 py-1 opacity-40 mr-6" id="securityButton">Keamanan Akun</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop View Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Edit Profil</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Perbarui informasi akun anda</p>
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
                        <form action="/edit-instructor-account-info" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pb-0">
                            @csrf                    
                            {{-- Form Sub Headers --}}
                            <div class="flex flex-col gap-1 mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Data Instruktur Kursus</h2>
                            </div>
                            <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                                {{-- Input Profile Picture --}}
                                <div class="flex flex-col gap-2">
                                    <label for="hash_for_profile_picture" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Gambar Profil (Optional)</label>
                                    @if (auth()->user()->hash_for_profile_picture)
                                        <label for="hash_for_profile_picture" class="relative w-fit">
                                            <div class="p-2 w-fit rounded-full bg-custom-disabled-dark/90 absolute bottom-0 right-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#F6F6F6" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#F6F6F6" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
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
                                    <label for="fullname" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nama Instruktur Kursus<span class="text-custom-destructive">*</span></label>
                                    <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('fullname') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->fullname }}">
                                    @error('fullname')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Username --}}
                                <div class="flex flex-col gap-2">
                                    <label for="username" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Username<span class="text-custom-destructive">*</span></label>
                                    <input type="text" name="username" id="username" placeholder="user_name_123" class="p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('username') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->username }}">
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
                                    <label for="description" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Deskripsi (opsional)</label>
                                    <textarea name="description" id="description" rows="5" placeholder="Deskripsikan diri anda" class="px-4 py-3.5 h-36 font-league font-medium text-lg/snug bg-custom-white-hover text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('description') border-2 border-custom-destructive @enderror">{{ auth()->user()->description }}</textarea>
                                    @error('description')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Age --}}
                                <div class="flex flex-col gap-2">
                                    <label for="age" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Usia Instruktur</label>
                                    <input type="number" name="age" id="age" min="18" max="70" placeholder="Usia minimal 18 tahun dan maksimal 70 tahun" class="w-full p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('age') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->age }}">
                                    @error('age')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input Phone Number --}}
                                <div class="flex flex-col gap-2">
                                    <label for="phone_number" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Nomor Whatsapp Aktif<span class="text-custom-destructive">*</span></label>
                                    <input type="tel" name="phone_number" id="phone_number" placeholder="081818181818" class="w-full p-4 font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('phone_number') border-2 border-custom-destructive @enderror" value="{{ auth()->user()->phone_number }}" oninput="deleteAnyString(this)">
                                    @error('phone_number')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Form Sub Headers --}}
                                <div class="flex flex-col gap-1 mt-8">
                                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pertanyaan Lupa Password</h2>
                                </div>
                                {{-- Input Password Challenge Question --}}
                                <div class="flex flex-col gap-2">
                                    <label for="fp_question" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pertanyaan Tantangan<span class="text-custom-destructive">*</span></label>
                                    <textarea name="fp_question" id="fp_question" rows="5" placeholder="Masukkan Pertanyaan Tantangan" class="px-4 py-3.5 h-36 font-league font-medium text-lg/snug bg-custom-white-hover text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('fp_question') border-2 border-custom-destructive @enderror">{{ auth()->user()->fp_question }}</textarea>
                                    @error('fp_question')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{-- Input FP Answer --}}
                                <div class="flex flex-col gap-2">
                                    <label for="fp_answer" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Jawaban<span class="text-custom-destructive">*</span></label>
                                    <div class="relative flex justify-end items-center">
                                        <input type="password" name="fp_answer" id="fp_answer" placeholder="Masukkan Jawaban dari Pertanyaan diatas" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror" value="{{ $decryptedFpAnswer }}">
                                        <div class="eyeIcon absolute mr-3" onclick="showHideFpAnswer()">
                                            <svg id="showFpAnswer" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#495D6477" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>
        
                                            <svg id="hideFpAnswer" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    @error('fp_answer')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Security --}}
                    <div class="swiper-slide">
                        <form action="/edit-instructor-password" method="post" class="px-6">
                            @csrf
                            {{-- Form Sub Headers --}}
                            <div class="mb-4">
                                <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Keamanan Akun</h2>
                            </div>
        
                            <div class="flex flex-col gap-5 lg:gap-7">
                                {{-- Input Password --}}
                                <div class="flex flex-col gap-2">
                                    <label for="password" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Masukkan Password Baru</label>
                                    <div class="relative flex justify-end items-center">
                                        <input type="password" name="password" id="password" placeholder="Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
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
                                    <label for="password_confirmation" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Ketik Ulang Password Baru</label>
                                    <div class="relative flex justify-end items-center">
                                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik Ulang Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
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
                <a href="/instructor-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>

                {{-- Submit Edit Profile Button --}}
                <button type="submit" id="submitEditProfileForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>

                {{-- Submit Edit Password Button --}}
                <button type="submit" id="submitEditPasswordForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
            </div>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="/instructor-profile" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>

        {{-- Submit Edit Profile Button --}}
        <button type="submit" id="mobileEditProfileForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>

        {{-- Submit Edit Password Button --}}
        <button type="submit" id="mobileEditPasswordForms" class="submit-button px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Simpan</button>
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
                prevEl: '',
                nextEl: '',
            },

            on: {
                slideChange: function() {
                    const currentIndex = swiper.activeIndex;
                    const buttons = ['#accountInfoButton','#securityButton'];
                    const largeButtons = ['#accountInfoLargeButton', '#securityLargeButton'];

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

        // Initially, hide every submit-button
        $('.submit-button').addClass('hidden');

        // Then, show the Edit Profile Button
        $('#submitEditProfileForms').removeClass('hidden');
        $('#mobileEditProfileForms').removeClass('hidden');

        // When we are in the first slide, show the Edit Profile Button, and hide other submit button
        $('#accountInfoButton, #accountInfoLargeButton').on('click', function() {
            swiper.slideTo(0);
            $('.submit-button').addClass('hidden');
            $('#submitEditProfileForms').removeClass('hidden');
            $('#mobileEditProfileForms').removeClass('hidden');
        });

        // When we are in the second slide, show the Edit Password Button, and hide other submit button
        $('#securityButton, #securityLargeButton').on('click', function() {
            swiper.slideTo(1);
            $('.submit-button').addClass('hidden');
            $('#submitEditPasswordForms').removeClass('hidden');
            $('#mobileEditPasswordForms').removeClass('hidden');
        });

        // Function to submit editProfile forms
        $('#submitEditProfileForms, #mobileEditProfileForms').on('click', function() {
            $('form[action="/edit-instructor-account-info"]').submit();
        });

        // Function to submit editPassword forms
        $('#submitEditPasswordForms, #mobileEditPasswordForms').on('click', function() {
            $('form[action="/edit-instructor-password"]').submit();
        });

        // Tel Input Script
        const phoneInputField = document.getElementById('phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        // Remove any non-numerical characters when pressed
        phoneInputField.addEventListener('keypress', function(event) {
            let value = phoneInputField.value.replace(/\D/g, '');
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical phoneInputField
            }
        });
        // Even when users tried to copy and paste a non-numerical characters, delete it immediately
        function deleteAnyString(phoneInputField) {
            let value = phoneInputField.value.replace(/\D/g, '');
            phoneInputField.value = value;
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

        // Show and Hide FP Answer Input
        function showHideFpAnswer() {
            const $showFpAnswer = $('#showFpAnswer');
            const $hideFpAnswer = $('#hideFpAnswer');
            const $fpAnswerInput = $('#fp_answer');

            if ($fpAnswerInput.attr('type') === "password") {
                $showFpAnswer.css('display', 'block');
                $hideFpAnswer.css('display', 'none');
            } else {
                $showFpAnswer.css('display', 'none');
                $hideFpAnswer.css('display', 'block');
            }
            
            $fpAnswerInput.attr('type', $fpAnswerInput.attr('type') === "password" ? "text" : "password");
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
    </script>
@endsection