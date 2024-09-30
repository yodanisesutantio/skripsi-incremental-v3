@extends('layouts.relative')

@section('content')
    {{-- Body Background Image --}}
    <div class="flex flex-col justify-center items-center bg-cover bg-center h-screen w-screen p-4" style="background-image: url('{{ asset('img/forgot-password.webp') }}')">
        {{-- Glass Effect --}}
        <div class="flex flex-col p-6 lg:px-8 lg:py-6 w-full lg:w-[27rem] bg-center bg-custom-dark/40 border border-t-custom-white/25 border-b-custom-disabled-dark/20 border-r-custom-disabled-dark/20 border-l-custom-white/25 lg:gap-4 rounded-lg lg:rounded-2xl backdrop-blur-md">
            {{-- Form Header --}}
            <h1 class="text-3xl/tight lg:text-4xl text-center text-custom-white font-encode tracking-tight font-semibold">Lupa Password</h1>
            <p class="font-normal font-league text-lg/tight mt-2 text-center text-custom-white">Jawab Pertanyaan Dibawah ini untuk mengganti password</p>

            {{-- Forms --}}
            <form id="passwordChallenge" method="POST" action="{{ url('/password-challenge/' . $user->username) }}">
                @csrf
                <div class="flex flex-col mt-8 lg:mt-6 gap-5 lg:gap-7">
                    {{-- Input FP_Answer --}}
                    <div class="flex flex-col gap-1">
                        <label for="fp_answer" class="font-medium font-league text-lg text-custom-white">"{{ $user->fp_question }}?"<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="fp_answer" id="fp_answer" autofocus placeholder="Jawaban Anda" class="p-4 font-league text-lg/[0] text-custom-white bg-custom-dark/40 placeholder:#FAFAFA rounded-lg @error('fp_answer') border-2 border-custom-destructive @enderror">
                        @error('fp_answer')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex mt-0">
                        <button type="submit" class="w-full py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Lanjut</button>
                    </div>
                </div>
            </form>

            {{-- Redirect to Login Link --}}
            <p class="mt-5 lg:mt-3 text-custom-white text-center text-lg font-league font-light lg:text-xl">Kembali ke halaman <a href="/login" class="text-custom-white font-medium underline hover:no-underline">Login</a></p>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        
    </script>
@endsection