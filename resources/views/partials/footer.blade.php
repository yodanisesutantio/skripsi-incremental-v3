<footer>
    {{-- Footer for Mobile --}}
    <div class="flex flex-row lg:hidden justify-between mb-4 pt-2 border-t border-custom-dark/40">
        <p class="font-league font-normal text-base text-custom-grey">
            ©2024 Kemudi.
        </p>
        <p class="font-league font-normal text-base text-custom-grey">
            All rights reserved.
        </p>
    </div>

    {{-- Footer for Desktop --}}
    <div class="hidden lg:flex lg:flex-col justify-between mb-4">
        <div class="grid grid-cols-2">
            <div class="flex flex-col gap-5 pl-12 pr-28 py-10 border-y border-r border-custom-dark/40">
                {{-- Website Mark --}}
                <img src="{{ asset('img/Logo-Hitam.svg') }}" alt="Logo Kemudi" class="w-44">
                {{-- Website Description --}}
                <p class="font-league text-lg/snug text-custom-dark">Sebuah platform untuk Penyedia Jasa Kursus Mengemudi dapat menawarkan jasanya kepada masyarakat umum. Platform untuk menjembatani Instruktur, Lembaga Kursus, dan Siswa Kursus</p>
            </div>
    
            <div class="grid grid-cols-2 grid-rows-3">
                @auth
                    {{-- User Dashboard Nav Button --}}
                    @if (auth()->user()->role === 'user')
                        <a href="{{ url('/user-index') }}" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    {{-- Instructor Dashboard Nav Button --}}
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="{{ url('/instructor-index') }}" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    {{-- Admin Dashboard Nav Button --}}
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin-index') }}" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Beranda</p>
                        </a>
                    @endif
                {{-- Guest Dashboard Nav Button --}}
                @else
                    <a href="{{ url('/tamu') }}" class="flex flex-col justify-center border-t border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                        <p class="font-league font-medium text-xl w-full">Beranda</p>
                    </a>
                @endauth

                {{-- About App Footer Menu --}}
                <a href="{{ url('/about-app') }}" class="flex flex-col justify-center border-t px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Tentang Aplikasi</p>
                </a>

                {{-- Course List --}}
                @auth
                    {{-- User Course Nav Button --}}
                    @if (auth()->user()->role === 'user')
                        <a href="{{ url('/user-course-list') }}" class="flex flex-col justify-center border-t border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Kursus</p>
                        </a>
                    {{-- Instructor Course Nav Button --}}
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="{{ url('/instructor-course') }}" class="flex flex-col justify-center border-t border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Kursus</p>
                        </a>
                    {{-- Admin Course Nav Button --}}
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin-course') }}" class="flex flex-col justify-center border-t border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Kursus</p>
                        </a>
                    @endif
                {{-- Guest Course Nav Button --}}
                @else 
                    <a href="#" class="guest-profile-link flex flex-col justify-center border-t border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                        <p class="font-league font-medium text-xl w-full">Kursus</p>
                    </a>
                @endauth

                {{-- Contact Us --}}
                <a href="{{ url('/contact-us') }}" class="flex flex-col justify-center border-y px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                    <p class="font-league font-medium text-xl w-full">Hubungi Kami</p>
                </a>

                {{-- User Profile Menu --}}
                @auth
                    {{-- User Profile Nav Button --}}
                    @if (auth()->user()->role === 'user')
                        <a href="{{ url('/user-profile') }}" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    {{-- Instructor Profile Nav Button --}}
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="{{ url('/instructor-profile') }}" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    {{-- Admin Profile Nav Button --}}
                    @elseif (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin-profile') }}" class="flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                            <p class="font-league font-medium text-xl w-full">Profil</p>
                        </a>
                    @endif
                {{-- Guest Profile Nav Button --}}
                @else 
                    <a href="#" class="guest-profile-link flex flex-col justify-center border-b border-r px-6 border-custom-dark/40 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
                        <p class="font-league font-medium text-xl w-full">Profil</p>
                    </a>
                @endauth

                {{-- Logout or Login depends on the current auth --}}
                @auth
                {{-- Logout Nav Button --}}
                <div class="flex flex-col justify-center border-b border-custom-dark/40 text-custom-destructive px-6 cursor-pointer hover:bg-custom-destructive hover:text-custom-white duration-300" onclick="logoutConfirmation()">
                    <button type="submit" class="font-league font-medium text-xl w-full text-left">Log Out</button>
                    <form action="{{ url('/logout') }}" method="post" class="mb-0 hidden">
                        @csrf
                    </form>
                </div>
                @else
                {{-- Login Button for Guest --}}
                <a href="{{ url('/login') }}" class="flex flex-col justify-center border-b border-custom-dark/40 text-custom-green px-6 cursor-pointer hover:bg-custom-green hover:text-custom-white duration-300">
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

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Toastr Warning for Guest when clicked Profile Nav in either Navbar or Footer
        $(document).ready(function() {
            $('.guest-profile-link').on('click', function(e) {
                e.preventDefault();

                toastr.warning('Anda harus Login terlebih dahulu'); 

                setTimeout(function() {
                    window.location.href = '{{ url('/login') }}';
                }, 3000); // Redirect after 3 seconds
            });
        });
    </script>
</footer>