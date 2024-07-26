@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('img/BG-Login.webp')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-5 lg:px-8 lg:py-6 w-full lg:w-[27rem] h-50 bg-center bg-[#EBF0F212] border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">
            {{-- Form Header --}}
            <h1 class="text-3xl lg:text-4xl/snug text-center tracking-normal text-custom-white font-encode font-semibold">Selamat Datang!</h1>

            {{-- Forms --}}
            <form action="/login" method="post">
                @csrf
                <div class="flex flex-col mt-8 lg:my-8 gap-5 lg:gap-7">
                    {{-- Input Username --}}
                    <div class="flex flex-col gap-1">
                        <label for="username" class="font-normal font-league text-xl text-custom-white">Username<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="username" id="username" autofocus placeholder="Username" class="p-4 font-league text-lg/[0] text-custom-white bg-custom-white/20 placeholder:#FAFAFA rounded-lg @error('username') border-2 border-custom-destructive @enderror" value="{{ old('username') }}">
                        @error('username')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Input Password --}}
                    <div class="flex flex-col gap-1">
                        <label for="password" class="font-normal font-league text-xl text-custom-white">Password<span class="text-custom-destructive">*</span></label>
                        <div class="relative flex justify-end items-center">
                            <input type="password" name="password" id="password" placeholder="Password" class="relative py-4 pl-4 pr-10 w-full font-league text-lg/[0] text-custom-white bg-custom-white/20 placeholder:#FAFAFA rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                            <div class="eyeIcon absolute mr-3" onclick="showHidePass()">
                                <svg id="showPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#fefefe77" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#fefefe77" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>

                                <svg id="hidePass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#fefefe77" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex mt-7">
                    <button name="submit" type="submit" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Login</button>
                </div>

                {{-- Redirect to Register Link --}}
                <p class="mt-8 text-custom-white text-center text-lg font-league font-light lg:text-xl">Belum punya akun? <a href="/register" class="text-custom-white font-medium underline hover:no-underline">Daftar Sekarang</a></p>
            </form>
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