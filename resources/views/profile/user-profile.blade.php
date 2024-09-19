@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="flex flex-col items-center w-full">
        {{-- Profile Information --}}
        <div class="profile-header flex flex-col lg:flex-row gap-3 lg:gap-10 w-full items-center lg:justify-center">
            @if (auth()->user()->hash_for_profile_picture)
                <img src="{{ asset('storage/profile_pictures/' . auth()->user()->hash_for_profile_picture) }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 object-cover rounded-full">
            @else
                <img src="{{ asset('img/blank-profile.webp') }}" alt="profile-picture" class="w-20 lg:w-32 h-20 lg:h-32 rounded-full">
            @endif
            <div class="text-content text-center lg:text-left flex flex-col gap-1 lg:gap-2 w-full lg:w-[24rem] px-12 lg:px-0">
                @if (auth()->user()->age === NULL && auth()->user()->description === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}</h1>
                    <i class="font-league text-custom-grey/40 text-lg/tight lg:text-2xl/tight">Belum ada deskripsi</i>
                @elseif (auth()->user()->age === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}</h1>
                    <p class="font-league text-custom-grey text-lg/tight lg:text-2xl/tight">{{ auth()->user()->description }}</p>
                @elseif (auth()->user()->description === NULL)
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}, {{ auth()->user()->age }}</h1>
                    <i class="font-league text-custom-grey/40 text-lg/tight lg:text-2xl/tight">Belum ada deskripsi</i>
                @else
                    <h1 class="font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl/tight">{{ auth()->user()->fullname }}, {{ auth()->user()->age }}</h1>
                    <p class="font-league text-custom-grey text-lg/tight lg:text-2xl/tight">{{ auth()->user()->description }}</p>
                @endif
            </div>
        </div>

        {{-- Menu --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 grid-rows-4 lg:grid-rows-2 w-full mt-6 lg:mt-14 mb-3 lg:mb-8 text-custom-white gap-3">
            {{-- Edit Profile --}}
            <a href="/user-profile/edit" class="lg:row-span-2 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/edit-profile.webp') }}')">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Ubah Profil</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Perbarui informasi personal anda</p>
                </div>
            </a>
            {{-- My Course Detail Page --}}
            <a href="#" class="lg:col-span-2 w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/course-progress.webp') }}')">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Kursus Anda</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Lacak riwayat progress kursus anda!</p>
                </div>
            </a>
            {{-- About App --}}
            <a href="/about-app" class="w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/about-app.webp') }}');">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Tentang Aplikasi</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Informasi tentang kami</p>
                </div>
            </a>
            {{-- Register as Driving School --}}
            <a href="#" class="row-span-2 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/add-driving-school.webp') }}')">
                <div class="flex flex-col gap-1 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Penyedia Kursus Mengemudi?</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Jadi bagian dari KEMUDI</p>
                </div>
            </a>
            {{-- Contact Us --}}
            <a href="/contact-us" class="w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/contact-us.webp') }}');">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Hubungi Kami</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Laporkan masalah</p>
                </div>
            </a>
            {{-- Delete Account --}}
            <div class="col-span-2 w-full h-32 lg:h-40 bg-cover bg-center rounded-xl lg:cursor-pointer" style="background-image: url('{{ asset('img/delete-account.webp') }}')" onclick="deleteAccountConfirmation()">
                <div class="flex flex-col gap-0.5 justify-end p-[10px] bg-gradient-to-t from-custom-dark/80 from-15% to-custom-dark/30 to-70% font-league w-full h-full rounded-xl lg:hover:bg-custom-dark-low lg:hover:transition-colors lg:duration-500">
                    <h2 class="text-lg/tight lg:text-2xl/[1.7rem] font-semibold">Hapus Akun KEMUDI</h2>
                    <p class="text-sm/none lg:text-base/[1.35rem] text-custom-white font-light">Hapus akun KEMUDI dan semua data terkait</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Overlay --}}
    <div id="delete-overlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Delete Confirmation --}}
        <div id="deleteConfirm" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                <h2 class="font-encode text-xl/tight pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Akun?</h2>
                <button type="button" id="XDelete"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus akun KEMUDI anda beserta data-data terkait?</p>
            </div>
            <div class="flex flex-row justify-end gap-2 lg:gap-4 px-5 mt-4">                
                <button type="button" id="closeDelete" class="w-fit rounded text-left p-3 text-sm/tight lg:text-base/tight text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesDelete" class="w-fit rounded text-left p-3 text-sm/tight lg:text-base/tight whitespace-nowrap bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Hapus Akun</button>
                <form action="/delete-account-KEMUDI" method="post" class="mb-1 hidden">
                    @method('delete')
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="mt-4">
        @include('partials.footer')
    </div>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Open Delete Confirmation Modals
        function deleteAccountConfirmation() {
            $('#delete-overlay').removeClass('hidden');
            $('#delete-overlay').addClass('flex');

            // Confirm Delete Function
            $('#yesDelete').click(function(event) {
                event.preventDefault();
                $('#yesDelete').next().submit();
            });
        }

        // Confirm Deactivate Function
        $('#closeDelete, #XDelete').click(function(event) {
            $('#delete-overlay').removeClass('flex');
            $('#delete-overlay').addClass('hidden');
        });
    </script>
@endsection