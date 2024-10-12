@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('{{ asset('img/forgot-password.webp') }}')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-6 lg:px-8 lg:py-6 w-full lg:w-[27rem] bg-center bg-custom-dark/40 border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">
            {{-- Form Header --}}
            <h1 class="text-3xl/tight lg:text-4xl text-center text-custom-white font-encode tracking-tight font-semibold">Lupa Password</h1>
            <p class="font-normal font-league mt-2 text-lg text-center text-custom-white">Isi salah satu data dibawah ini</p>

            {{-- Tabs --}}
            <div class="flex flex-row justify-center gap-5 mt-2">
                {{-- Username --}}
                <div id="toUsername" class="cursor-pointer select-none flex flex-row justify-center items-center py-1.5 gap-2 px-3 font-league border-b-2 border-custom-white">
                    <p class="font-medium text-lg lg:text-xl text-custom-white">Username</p>
                </div>
                {{-- Phone Number --}}
                <div id="toPhoneNumber" class="cursor-pointer select-none flex flex-row justify-center items-center py-1.5 gap-2 px-3 font-league opacity-40">
                    <p class="font-medium text-lg lg:text-xl text-custom-white">No. Whatsapp</p>
                </div>
            </div>

            {{-- Forms --}}
            <div class="flex flex-col mt-8 lg:mt-6 gap-5 lg:gap-7">
                <div class="swiper w-full">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <form id="forgotPasswordUsername" method="GET">
                                {{-- Input Username --}}
                                <div class="flex flex-col gap-1">
                                    <input type="text" name="username" id="username" placeholder="Username" class="p-4 font-league text-lg/none text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('username') border-2 border-custom-destructive @enderror" value="{{ old('username') }}">
                                    @error('username')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                    <span id="usernameError" class="text-custom-destructive"></span>
                                </div>
                            
                                {{-- Submit Button --}}
                                <div class="flex mt-7">
                                    <button type="submit" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500" data-type="username">Lanjut</button>
                                </div>
                            </form>
                        </div>

                        <div class="swiper-slide">
                            <form id="forgotPasswordPhoneNumber" method="GET">
                                {{-- Input Phone Number --}}
                                <div class="flex flex-col gap-1">
                                    <input type="tel" name="phone_number" id="phone_number" placeholder="081818181818" class="w-full p-4 font-league text-lg/none bg-custom-dark/40 text-custom-white placeholder:#FAFAFA rounded-lg @error('phone_number') border-2 border-custom-destructive @enderror" value="{{ old('phone_number') }}" oninput="deleteAnyString(this)">
                                    @error('phone_number')
                                        <span class="text-custom-destructive">{{ $message }}</span>
                                    @enderror
                                    <span id="phoneNumberError" class="text-custom-destructive"></span>
                                </div>

                                {{-- Submit Button --}}
                                <div class="flex mt-7">
                                    <button type="submit" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500" data-type="phone">Lanjut</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Redirect to Login Link --}}
            <p class="mt-5 lg:mt-3 text-custom-white text-center text-lg font-league font-light lg:text-xl">Kembali ke halaman <a href="{{ url('/login') }}" class="text-custom-white font-medium underline hover:no-underline">Login</a></p>
        </div>        
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: false,
            spaceBetween: 40,

            on: {
                slideChange: function() {
                    // Check the current active slide index
                    if (swiper.activeIndex === 0) {
                        // If the first slide (index 0), make the "Username" tab active
                        $('#toUsername').addClass('border-b-2 border-custom-white').removeClass('opacity-40');
                        $('#toPhoneNumber').removeClass('border-b-2 border-custom-white').addClass('opacity-40');
                    } else if (swiper.activeIndex === 1) {
                        // If the second slide (index 1), make the "Phone Number" tab active
                        $('#toPhoneNumber').addClass('border-b-2 border-custom-white').removeClass('opacity-40');
                        $('#toUsername').removeClass('border-b-2 border-custom-white').addClass('opacity-40');
                    }
                }
            }
        });

        // when Username Tabs is clicked jump to first slide
        $('#toUsername').on('click', function() {
            swiper.slideTo(0);
        });
        // when Phone Number Tabs is clicked jump to second slide
        $('#toPhoneNumber').on('click', function() {
            swiper.slideTo(1);
        });

        // To assist user so they can't press space when typing the username
        $("#username").on("keydown input", function(event) {
            if (event.type === "keydown" && event.keyCode === 32) {
                event.preventDefault();
            } else if (event.type === "input") {
                $(this).val($(this).val().replace(/\s/g, ""));
            }
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

        $('button[type="submit"]').on('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting immediately

            var type = $(this).data('type'); // Get the type of form            
            var actionUrl;
            var errorMessage = '';

            if (type === 'username') {
                var username = $('#username').val();
                $('#usernameError').text(''); // Clear any previous error message

                // Frontend validation: Check if the input is empty
                if (username.trim() === '') {
                    $('#usernameError').text('Kolom ini harus diisi');
                    return; // Stop the form from being submitted
                }

                // Update the form action URL dynamically
                actionUrl = "{{ url('/forgot-password/username') }}" + "/" + encodeURIComponent(username);
                $('#forgotPasswordUsername').attr('action', actionUrl);
                $('#forgotPasswordUsername').submit(); // Submit the form
            } 
            
            else if (type === 'phone') {
                var phoneNumber = $('#phone_number').val();
                $('#phoneNumberError').text(''); // Clear any previous error message

                // Frontend validation: Check if the input is empty
                if (phoneNumber.trim() === '') {
                    $('#phoneNumberError').text('Kolom ini harus diisi');
                    return; // Stop the form from being submitted
                }

                // Convert the phone number to start with +62
                if (phoneNumber.startsWith('0')) {
                    phoneNumber = phoneNumber.replace(/^0/, '+62');
                } else if (phoneNumber.startsWith('62')) {
                    phoneNumber = phoneNumber.replace(/^62/, '+62');
                } else if (!phoneNumber.startsWith('+62')) {
                    phoneNumber = '+62' + phoneNumber; // Add +62 prefix if it doesn't already have it
                }

                // Update the form action URL dynamically
                actionUrl = "{{ url('/forgot-password/phone') }}" + "/" + encodeURIComponent(phoneNumber);
                $('#forgotPasswordPhoneNumber').attr('action', actionUrl);
                $('#forgotPasswordPhoneNumber').submit(); // Submit the form
            }
        });
    </script>
@endsection