<footer>
    {{-- Footer for Mobile --}}
    <div class="flex flex-row lg:hidden justify-between mx-5 mb-2 pt-2 border-t border-custom-dark/40">
        <p class="font-league font-normal text-base text-custom-grey">
            ©2024 Kemudi.
        </p>
        <p class="font-league font-normal text-base text-custom-grey">
            All rights reserved.
        </p>
    </div>

    {{-- Footer for Desktop --}}
    <div class="hidden lg:flex lg:flex-col justify-between mx-[2rem] mb-4">
        <div class="grid grid-cols-2">
            <div class="flex flex-col gap-5 pl-12 pr-28 py-10 border-y border-r border-custom-dark/40">
                <img src="img/Logo-Hitam.svg" alt="" class="w-44">
                <p class="font-league text-lg/snug text-custom-dark">Sebuah platform untuk Penyedia Jasa Kursus Mengemudi dapat menawarkan jasanya kepada masyarakat umum. Platform untuk menjembatani Instruktur, Lembaga Kursus, dan Siswa Kursus</p>
            </div>
    
            <div class="grid grid-cols-2 grid-rows-3">
                @auth
                    {{-- User Dashboard Nav Button --}}
                    @if (auth()->user()->role === 'user')
                        <a href="user-index" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    {{-- Instructor Dashboard Nav Button --}}
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="instructor-index" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    {{-- Admin Dashboard Nav Button --}}
                    @elseif (auth()->user()->role === 'admin')
                        <a href="admin-index" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    @endif
                {{-- Guest Dashboard Nav Button --}}
                @else
                    <a href="tamu" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                        <p class="font-league font-medium text-xl w-full">Beranda</p>
                    </a>
                @endauth

                {{-- About App Footer Menu --}}
                <a href="about-app" class="flex flex-col justify-center border-t px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Tentang Aplikasi</p>
                </a>

                {{-- Course List --}}
                <a href="course-list" class="flex flex-col justify-center border-y border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Kursus</p>
                </a>

                {{-- Contact Us --}}
                <a href="contact-us" class="flex flex-col justify-center border-y px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Hubungi Kami</p>
                </a>

                {{-- User Profile Menu --}}
                @auth
                    {{-- User Profile Nav Button --}}
                    @if (auth()->user()->role === 'user')
                        <a href="user-profile" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    {{-- Instructor Profile Nav Button --}}
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="instructor-profile" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    {{-- Admin Profile Nav Button --}}
                    @elseif (auth()->user()->role === 'admin')
                        <a href="admin-profile" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    @endif
                {{-- Guest Profile Nav Button --}}
                @else 
                    <a href="/login" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                        <p class="font-league font-medium text-xl w-full">Profil</p>
                    </a>
                @endauth

                {{-- Logout or Login depends on the current auth --}}
                @auth
                {{-- Logout Nav Button --}}
                <div class="flex flex-col justify-center border-b border-custom-dark/40 text-custom-destructive px-6 cursor-pointer hover:bg-custom-destructive hover:text-custom-white duration-300" onclick="logoutConfirmation()">
                    <button type="submit" class="font-league font-medium text-xl w-full text-left">Log Out</button>
                    <form action="/logout" method="post" class="mb-0 hidden">
                        @csrf
                    </form>
                </div>
                @else
                {{-- Login Button for Guest --}}
                <a href="/login" class="flex flex-col justify-center border-b border-custom-dark/40 text-custom-green px-6 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Login</p>
                </a>
                @endauth
            </div>
        </div>

        <div class="flex flex-row justify-between pt-2">
            <p class="font-league font-normal text-base text-custom-grey">
                ©2024 Kemudi.
            </p>
            <p class="font-league font-normal text-base text-custom-grey">
                All rights reserved.
            </p>
        </div>
    </div>
</footer>