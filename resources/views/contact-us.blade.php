@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-center text-3xl lg:text-4xl my-5 lg:mt-10 lg:mb-8">Hubungi Kami</h1>
    <div class="grid grid-rows-3 lg:grid-cols-3 lg:grid-rows-1 gap-3">
        {{-- Email Contact --}}
        <a href="#" class="w-full border bg-custom-white-hover border-custom-disabled-dark/40 rounded-lg shadow-md">
            {{-- Wrapper --}}
            <div class="p-3 flex flex-col">
                {{-- Icons --}}
                <div class="p-1.5 w-fit border border-custom-disabled-dark/40 rounded-lg mb-5"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#646464" fill-rule="evenodd" d="M9.944 3.25h4.112c1.838 0 3.294 0 4.433.153c1.172.158 2.121.49 2.87 1.238c.748.749 1.08 1.698 1.238 2.87c.153 1.14.153 2.595.153 4.433v.112c0 1.838 0 3.294-.153 4.433c-.158 1.172-.49 2.121-1.238 2.87c-.749.748-1.698 1.08-2.87 1.238c-1.14.153-2.595.153-4.433.153H9.944c-1.838 0-3.294 0-4.433-.153c-1.172-.158-2.121-.49-2.87-1.238c-.748-.749-1.08-1.698-1.238-2.87c-.153-1.14-.153-2.595-.153-4.433v-.112c0-1.838 0-3.294.153-4.433c.158-1.172.49-2.121 1.238-2.87c.749-.748 1.698-1.08 2.87-1.238c1.14-.153 2.595-.153 4.433-.153M5.71 4.89c-1.006.135-1.586.389-2.01.812c-.422.423-.676 1.003-.811 2.009c-.138 1.028-.14 2.382-.14 4.289c0 1.907.002 3.262.14 4.29c.135 1.005.389 1.585.812 2.008c.423.423 1.003.677 2.009.812c1.028.138 2.382.14 4.289.14h4c1.907 0 3.262-.002 4.29-.14c1.005-.135 1.585-.389 2.008-.812c.423-.423.677-1.003.812-2.009c.138-1.028.14-2.382.14-4.289c0-1.907-.002-3.261-.14-4.29c-.135-1.005-.389-1.585-.812-2.008c-.423-.423-1.003-.677-2.009-.812c-1.027-.138-2.382-.14-4.289-.14h-4c-1.907 0-3.261.002-4.29.14m-.287 2.63a.75.75 0 0 1 1.056-.096L8.64 9.223c.933.777 1.58 1.315 2.128 1.667c.529.34.888.455 1.233.455c.345 0 .704-.114 1.233-.455c.547-.352 1.195-.89 2.128-1.667l2.159-1.8a.75.75 0 1 1 .96 1.153l-2.196 1.83c-.887.74-1.605 1.338-2.24 1.746c-.66.425-1.303.693-2.044.693c-.741 0-1.384-.269-2.045-.693c-.634-.408-1.352-1.007-2.239-1.745L5.52 8.577a.75.75 0 0 1-.096-1.057" clip-rule="evenodd"/></svg></div>
                <h2 class="font-league font-semibold text-custom-dark text-2xl">Email</h2>
                <p class="font-league font-medium text-custom-grey text-base lg:text-lg">Mulai percakapan via Email</p>
            </div>
            <p class="px-3 py-2.5 border-t border-custom-disabled-dark font-league font-semibold text-lg text-custom-dark underline">email@kemudi.com</p>
        </a>
        {{-- Call Contact --}}
        <a href="#" class="w-full border bg-custom-white-hover border-custom-disabled-dark/40 rounded-lg shadow-md">
            {{-- Wrapper --}}
            <div class="p-3 flex flex-col">
                {{-- Icons --}}
                <div class="p-1.5 w-fit border border-custom-disabled-dark/40 rounded-lg mb-5"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#646464" d="m16.1 13.359l-.528-.532zm.456-.453l.529.532zm2.417-.317l-.358.66zm1.91 1.039l-.358.659zm.539 3.255l.529.532zm-1.42 1.412l-.53-.531zm-1.326.67l.07.747zm-9.86-4.238l.528-.532zM4.002 5.746l-.749.042zm6.474 1.451l.53.532zm.157-2.654l.6-.449zM9.374 2.86l-.601.45zM6.26 2.575l.53.532zm-1.57 1.56l-.528-.531zm7.372 7.362l.529-.532zm4.567 2.394l.455-.453l-1.058-1.064l-.455.453zm1.985-.643l1.91 1.039l.716-1.318l-1.91-1.038zm2.278 3.103l-1.42 1.413l1.057 1.063l1.42-1.412zm-2.286 1.867c-1.45.136-5.201.015-9.263-4.023l-1.057 1.063c4.432 4.407 8.65 4.623 10.459 4.454zm-9.263-4.023c-3.871-3.85-4.512-7.087-4.592-8.492l-1.498.085c.1 1.768.895 5.356 5.033 9.47zm1.376-6.18l.286-.286L9.95 6.666l-.287.285zm.515-3.921L9.974 2.41l-1.201.899l1.26 1.684zM5.733 2.043l-1.57 1.56l1.058 1.064l1.57-1.56zm4.458 5.44c-.53-.532-.53-.532-.53-.53h-.002l-.003.004a1.064 1.064 0 0 0-.127.157c-.054.08-.113.185-.163.318a2.099 2.099 0 0 0-.088 1.071c.134.865.73 2.008 2.256 3.526l1.058-1.064c-1.429-1.42-1.769-2.284-1.832-2.692c-.03-.194.001-.29.01-.312c.005-.014.007-.015 0-.006a.276.276 0 0 1-.03.039l-.01.01a.203.203 0 0 1-.01.009zm1.343 4.546c1.527 1.518 2.676 2.11 3.542 2.242c.443.068.8.014 1.071-.087a1.536 1.536 0 0 0 .42-.236a.923.923 0 0 0 .05-.045l.007-.006l.003-.003l.001-.002s.002-.001-.527-.533c-.53-.532-.528-.533-.528-.533l.002-.002l.002-.002l.006-.005l.01-.01a.383.383 0 0 1 .038-.03c.01-.007.007-.004-.007.002c-.025.009-.123.04-.32.01c-.414-.064-1.284-.404-2.712-1.824zm-1.56-9.62C8.954 1.049 6.95.834 5.733 2.044L6.79 3.107c.532-.529 1.476-.475 1.983.202zM4.752 5.704c-.02-.346.139-.708.469-1.036L4.163 3.604c-.537.534-.96 1.29-.909 2.184zm14.72 12.06c-.274.274-.57.428-.865.455l.139 1.494c.735-.069 1.336-.44 1.784-.885zM11.006 7.73c.985-.979 1.058-2.527.229-3.635l-1.201.899c.403.539.343 1.246-.085 1.673zm9.52 6.558c.817.444.944 1.49.367 2.064l1.058 1.064c1.34-1.333.927-3.557-.71-4.446zm-3.441-.849c.384-.382 1.002-.476 1.53-.19l.716-1.317c-1.084-.59-2.428-.427-3.304.443z"/></svg></div>
                <h2 class="font-league font-semibold text-custom-dark text-2xl">Telepon</h2>
                <p class="font-league font-medium text-custom-grey text-base lg:text-lg">Komunikasi via Telepon</p>
            </div>
            <p class="px-3 py-2.5 border-t border-custom-disabled-dark font-league font-semibold text-lg text-custom-dark underline">(+62) 801 7231 12310</p>
        </a>
        {{-- Whatsapp Contact --}}
        <a href="#" class="w-full border bg-custom-white-hover border-custom-disabled-dark/40 rounded-lg shadow-md">
            {{-- Wrapper --}}
            <div class="p-3 flex flex-col">
                {{-- Icons --}}
                <div class="p-1.5 w-fit border border-custom-disabled-dark/40 rounded-lg mb-5"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#646464" d="m187.58 144.84l-32-16a8 8 0 0 0-8 .5l-14.69 9.8a40.55 40.55 0 0 1-16-16l9.8-14.69a8 8 0 0 0 .5-8l-16-32A8 8 0 0 0 104 64a40 40 0 0 0-40 40a88.1 88.1 0 0 0 88 88a40 40 0 0 0 40-40a8 8 0 0 0-4.42-7.16M152 176a72.08 72.08 0 0 1-72-72a24 24 0 0 1 19.29-23.54l11.48 23L101 118a8 8 0 0 0-.73 7.51a56.47 56.47 0 0 0 30.15 30.15A8 8 0 0 0 138 155l14.61-9.74l23 11.48A24 24 0 0 1 152 176M128 24a104 104 0 0 0-91.82 152.88l-11.35 34.05a16 16 0 0 0 20.24 20.24l34.05-11.35A104 104 0 1 0 128 24m0 192a87.87 87.87 0 0 1-44.06-11.81a8 8 0 0 0-6.54-.67L40 216l12.47-37.4a8 8 0 0 0-.66-6.54A88 88 0 1 1 128 216"/></svg></div>
                <h2 class="font-league font-semibold text-custom-dark text-2xl">Whatsapp</h2>
                <p class="font-league font-medium text-custom-grey text-base lg:text-lg">Mulai percakapan dengan Whatsapp</p>
            </div>
            <p class="px-3 py-2.5 border-t border-custom-disabled-dark font-league font-semibold text-lg text-custom-dark underline">wa.me/+621831631239</p>
        </a>
    </div>

    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-center text-2xl lg:text-4xl mt-10 lg:mt-16">Pertanyaan Umum</h1>
    {{-- Accordion --}}
    <div class="mt-3 mb-6 lg:mt-6 lg:mb-16 lg:px-32 flex flex-col gap-1 lg:gap-4">
        {{-- Reset Password --}}
        <div class="px-3 border-b border-custom-grey rounded-lg">
            <h2 class="font-league font-medium text-lg/snug lg:text-2xl/snug py-2.5 lg:py-4">
                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                    <p class="mt-1.5">Cara mengatur ulang Password</p>
                    {{-- Plus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="plus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M17 15V8h-2v7H8v2h7v7h2v-7h7v-2z"/></svg>
                    {{-- Minus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden minus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M8 15h16v2H8z"/></svg>
                </button>
            </h2>
            <div id="collapseOne" class="font-league text-base lg:text-lg py-1.5 lg:py-3 text-custom-dark/80 hidden">
                Anda dapat mengatur ulang password dengan memilih menu "Ubah Profil", yang ada di halaman Profil anda, tentunya, anda harus melewati proses Login terlebih dahulu, anda tidak bisa melakukan proses ini apabila anda masuk sebagai tamu.
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="px-3 border-b border-custom-grey rounded-lg">
            <h2 class="font-league font-medium text-lg/snug lg:text-2xl/snug py-2.5 lg:py-4">
                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                    <p class="mt-1.5">Bagaimana cara saya membayar kursus?</p>
                    {{-- Plus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="plus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M17 15V8h-2v7H8v2h7v7h2v-7h7v-2z"/></svg>
                    {{-- Minus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden minus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M8 15h16v2H8z"/></svg>
                </button>
            </h2>
            <div id="collapseOne" class="font-league text-base lg:text-lg py-1.5 lg:py-3 text-custom-dark/80 hidden">
                Setiap penyedia kursus menerima metode pembayaran yang berbeda-beda, ketika anda selesai mengisi formulir pendaftaran kursus dan memilih jadwal untuk setiap pertemuan, anda akan diarahkan ke halaman detail progress kursus dimana anda dapat memilih menu "Pembayaran" untuk mengetahui metode pembayaran yang didukung oleh penyedia kursus yang anda ikuti, selanjutnya anda harus mengunggah bukti pembayaran kursus maksimal 24 jam sebelum pertemuan pertama.
            </div>
        </div>

        {{-- Driving School Verification Process --}}
        <div class="px-3 border-b border-custom-grey rounded-lg">
            <h2 class="font-league font-medium text-lg/snug lg:text-2xl/snug py-2.5 lg:py-4">
                <button class="accordion-button flex flex-row justify-between items-center w-full text-left" type="button" aria-expanded="false" aria-controls="collapseOne">
                    <p class="mt-1.5">Berapa lama verifikasi izin penyelenggaraan kursus?</p>
                    {{-- Plus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="plus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M17 15V8h-2v7H8v2h7v7h2v-7h7v-2z"/></svg>
                    {{-- Minus Sign --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden minus-sign flex-shrink-0" width="28" height="28" viewBox="0 0 32 32"><path fill="#040B0D" d="M8 15h16v2H8z"/></svg>
                </button>
            </h2>
            <div id="collapseOne" class="font-league text-base lg:text-lg py-1.5 lg:py-3 text-custom-dark/80 hidden">
                Kami memverifikasi dokumen yang anda unggah secara manual, dan proses ini normalnya membutuhkan waktu selama-lamanya 24 jam. Jangan khawatir, kami akan mengirimkan anda notifikasi apabila kami menemui kemajuan atau menghadapi kendala.
            </div>
        </div>
    </div>

    @include('partials.footer')  

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.accordion-button').click(function() {
                const content = $(this).closest('h2').next('div');
                const plusIcon = $(this).find('.plus-sign');
                const minusIcon = $(this).find('.minus-sign');

                content.toggleClass('hidden');
                plusIcon.toggleClass('hidden');
                minusIcon.toggleClass('hidden'); 

                $(this).attr('aria-expanded', content.is(':visible')); 
            });
        });
    </script>
@endsection