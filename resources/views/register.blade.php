@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('img/BG-Login.webp')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-5 lg:px-8 lg:py-6 w-full lg:w-[27rem] h-50 bg-center bg-[#F6F6F612] border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">

        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
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