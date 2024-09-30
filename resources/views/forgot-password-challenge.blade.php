@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('img/forgot-password.webp')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-6 lg:px-8 lg:py-6 w-full lg:w-[27rem] bg-center bg-custom-dark/40 border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">
            {{-- Form Header --}}
            <h1 class="text-3xl/tight lg:text-4xl text-center text-custom-white font-encode tracking-tight font-semibold">Lupa Password</h1>
            <p class="font-normal font-league text-lg text-center text-custom-white">Jawab Pertanyaan Dibawah ini untuk mengganti password</p>
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

        $('#submitUsername').on('click', function(e) {
            e.preventDefault(); // Prevent immediate redirection

            // Get the username value
            var username = $('#username').val();

            // Build the URL with the username appended
            var url = '/forgot-password/' + encodeURIComponent(username);

            // Redirect the user to the constructed URL
            window.location.href = url;
        });
    </script>
@endsection