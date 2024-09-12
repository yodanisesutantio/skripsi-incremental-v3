@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('img/for-register-page.webp')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-6 lg:px-8 lg:py-6 w-full lg:w-[27rem] bg-center bg-[#231f2088] border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">
            <div class="swiper w-full px-0">
                {{-- Form Header --}}
                <h1 class="text-3xl/tight lg:text-4xl text-center text-custom-white whitespace-nowrap font-encode tracking-tight font-semibold">Halo Pengguna Baru!</h1>
                {{-- Forms --}}
                <form action="/register" method="post" class="swiper-wrapper pt-1 pb-6">
                    @csrf
                    {{-- Slide 1 : Account Info --}}
                    <div class="swiper-slide">
                        <p class="font-league font-light w-full text-center text-lg/snug lg:text-xl/snug text-custom-white">Pertama-tama perkenalkan dirimu</p>
                        
                        <div class="flex flex-col mt-5 lg:mt-6 gap-5 lg:gap-7">
                            {{-- Input Fullname --}}
                            <div class="flex flex-col gap-1">
                                <label for="fullname" class="font-normal font-league text-lg text-custom-white">Nama Lengkap<span class="text-custom-destructive">*</span></label>
                                <input type="text" name="fullname" id="fullname" autofocus placeholder="Nama Lengkap mu" class="p-4 font-league text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('fullname') border-2 border-custom-destructive @enderror">
                                @error('fullname')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Input Age --}}
                            <div class="flex flex-col gap-1">
                                <label for="age" class="font-normal font-league text-lg text-custom-white">Usia<span class="text-custom-destructive">*</span></label>
                                <input type="number" name="age" id="age" min="18" max="70" placeholder="Usia minimal 18 tahun" class="p-4 font-league text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('age') border-2 border-custom-destructive @enderror">
                                @error('age')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Input Phone Number --}}
                            <div class="flex flex-col gap-1">
                                <label for="phone_number" class="font-normal font-league text-lg text-custom-white">Nomor Whatsapp Aktif<span class="text-custom-destructive">*</span></label>
                                <input type="tel" name="phone_number" id="phone_number" placeholder="081818181818" class="w-full p-4 font-league text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('phone_number') border-2 border-custom-destructive @enderror" oninput="deleteAnyString(this)">
                                @error('phone_number')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Slide 2 : Phone Number --}}
                    <div class="swiper-slide">
                        <p class="font-league font-light w-full text-center text-lg/snug lg:text-xl/snug text-custom-white">Buat Username dan Password mu</p>

                        <div class="flex flex-col mt-5 lg:mt-6 gap-5 lg:gap-7">
                            {{-- Input Username --}}
                            <div class="flex flex-col gap-1">
                                <label for="username" class="font-normal font-league text-lg text-custom-white">Username<span class="text-custom-destructive">*</span></label>
                                <input type="text" name="username" id="username" placeholder="user_name_123" class="p-4 font-league text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('username') border-2 border-custom-destructive @enderror">
                                @error('username')
                                    @if ($message === 'The username has already been taken.')
                                        <span class="text-custom-destructive">{{ $message }}</span>    
                                    @else
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @endif
                                @enderror
                            </div>
                            {{-- Input Password --}}
                            <div class="flex flex-col gap-1">
                                <label for="password" class="font-normal font-league text-lg text-custom-white">Masukkan Password Anda</label>
                                <div class="relative flex justify-end items-center">
                                    <input type="password" name="password" id="password" placeholder="Masukkan Password" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                                    <div class="eyeIcon absolute mr-3" onclick="showHidePass()">
                                        <svg id="showPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#f6f6f677" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#f6f6f677" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>
    
                                        <svg id="hidePass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#f6f6f677" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>    
                            {{-- Confirm Password --}}
                            <div class="flex flex-col gap-1">
                                <label for="password_confirmation" class="font-normal font-league text-lg text-custom-white">Ketik Ulang Password</label>
                                <div class="relative flex justify-end items-center">
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik Ulang Password" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                                    <div class="eyeIcon absolute mr-3" onclick="showHideConfirmPass()">
                                        <svg id="showConfirmPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#f6f6f677" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#f6f6f677" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>
    
                                        <svg id="hideConfirmPass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#f6f6f677" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                                @error('password_confirmation')
                                    <span class="text-custom-destructive">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
                {{-- Submit Button --}}
                <div class="flex flex-row justify-between">
                    <button type="button" class="hidden prev-slide px-1 py-3 rounded-lg lg:rounded-lg text-center lg:text-lg text-custom-white-hover underline lg:hover:no-underline font-semibold duration-500">Kembali</button>
                    <button type="button" class="next-slide px-10 py-3 ml-auto rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold duration-500">Lanjut</button>
                    <button name="submit" type="submit" class="hidden submit-button px-10 py-3 rounded-lg lg:rounded-lg bg-custom-green lg:hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold duration-500">Daftar</button>
                </div>
            </div>
            {{-- Redirect to Register Link --}}
            <p class="mt-8 lg:mt-2 text-custom-white text-center text-lg font-league font-light lg:text-xl">Sudah punya akun? <a href="/login" class="text-custom-white font-medium underline hover:no-underline">Masuk</a></p>
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
                prevEl: '.prev-slide',
                nextEl: '.next-slide',
            },

            on: {
                slideChange: function() {
                    // Hide .prev-slide button on the first slide
                    if (this.isBeginning) {
                        $('.prev-slide').hide();
                    } else {
                        $('.prev-slide').show();
                    }

                    // Hide .next-slide button on the last slide and show .submit-button
                    if (this.isEnd) {
                        $('.next-slide').hide();
                        $('.submit-button').show();
                    } else {
                        $('.next-slide').show();
                        $('.submit-button').hide();
                    }
                },
                init: function () {
                    this.update();
                }
            }
        });

        // To Show and Hide the Password Input
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

        // Tel Input Script
        const phoneInputField = document.getElementById('phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        // Remove any non-numerical characters when pressed
        phoneInputField.addEventListener('keypress', function(event) {
            let value = input.value.replace(/\D/g, '');
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical input
            }
        });
        // Even when users tried to copy and paste a non-numerical characters, delete it immediately
        function deleteAnyString(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // To assist user so they can't press space when typing the username
        $("#username").on("keydown input", function(event) {
            if (event.type === "keydown" && event.keyCode === 32) {
                event.preventDefault();
            } else if (event.type === "input") {
                $(this).val($(this).val().replace(/\s/g, ""));
            }
        });
    </script>
@endsection