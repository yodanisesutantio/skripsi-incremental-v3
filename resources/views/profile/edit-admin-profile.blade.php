@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 px-6 lg:px-[27rem] bg-custom-white flex flex-col gap-1" id="form-header">
        <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Ubah Data Profil</h1>
        <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Perbarui informasi personal anda</p>
    </div>

    <div class="swiper">
        <div class="swiper-container">
            <div class="swiper-slide"></div>
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

            navigation: {
                prevEl: '',
                nextEl: '',
            },

            on: {
                slideChange: function() {
                    const currentSlide = swiper.activeIndex + 1;
                    const isLastSlide = currentSlide === swiper.slides.length; 

                    document.getElementById('continue').style.display = isLastSlide ? 'none' : 'block';
                    document.getElementById('sendDocument').style.display = isLastSlide ? 'block' : 'none';
                }
            }
        })

        // Tel Input Script
        const phoneInputField = document.getElementById('phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        phoneInputField.addEventListener('keypress', function(event) {
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical input
            }
        });

        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 30) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });
    </script>
@endsection