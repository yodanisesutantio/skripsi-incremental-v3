<header class="z-30 bg-custom-white sticky top-0">
    <div class="flex flex-row pt-8 pb-3 px-5 lg:px-[4.25rem] mb-4 justify-between">
        <div class="burger" onclick="openNav()">
            {{-- SVG Burger --}}
            <svg id="originalSvg" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-width="1.5" d="M20 7H4m11 5H4m5 5H4"/></svg>
            {{-- SVG Close --}}
            <svg id="newSvg" class="cursor-pointer hidden" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg>

            <div class="hidden" id="navbar">
                <div class="flex flex-col absolute w-[calc(100%-2.5rem)] lg:w-[calc(100%-8.5rem)] top-20 p-2 shadow-lg shadow-custom-grey bg-custom-white-hover border border-custom-green backdrop-blur-sm rounded-xl">
                    <ul>
                        {{-- Beranda --}}
                        @auth
                            @if (auth()->user()->role === 'user')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="user-index">Beranda</a></li>
                            @elseif (auth()->user()->role === 'instructor')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="instructor-index">Beranda</a></li>
                            @elseif (auth()->user()->role === 'admin')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="admin-index">Beranda</a></li>
                            @endif
                        @else
                            <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="tamu">Beranda</a></li>
                        @endauth

                        {{-- Kursus --}}
                        <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="course-list">Kursus</a></li>

                        {{-- Profil --}}
                        @auth
                            @if (auth()->user()->role === 'user')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="user-profile">Profil</a></li>
                            @elseif (auth()->user()->role === 'instructor')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="instructor-profile">Profil</a></li>
                            @elseif (auth()->user()->role === 'admin')
                                <li class="p-3 text-custom-green font-bold lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="admin-profile">Profil</a></li>
                            @endif
                        @else
                            
                        @endauth

                        {{-- Garis Pemisah --}}
                        <li class="p-3 text-custom-green font-bold lg:text-xl"><a href=""><hr class="border-custom-grey border-opacity-35"></a></li>

                        {{-- Logout / Login Button --}}
                        @auth
                            <li class="lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item">
                                <button type="button" class="w-full text-left p-3 text-custom-destructive font-semibold" onclick="logoutConfirmation()">Log Out</button>
                                <form action="/logout" method="post" class="mb-1 hidden">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="mb-1 p-3 lg:text-xl hover:bg-custom-dark/10 cursor-pointer nav-item"><a href="/login" class="text-custom-green font-semibold">Login</a></li>
                        @endauth
                    </ul>                    
                </div>
            </div>
        </div>
        {{-- SVG Search --}}
        <svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="1.5"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
    </div>

    {{-- Darken Overlay --}}
    <div id="confirmation-overlay" class="fixed hidden flex items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Logout Confirmation --}}
        <div id="logoutConfirm" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Konfirmasi</h2>
                <button type="button" id="XModals"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin melanjutkan proses Logout?</p>
            </div>
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeModals" class="w-fit rounded text-left p-3 text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesLogout" class="w-fit rounded text-left p-3 bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Log Out</button>
                <form action="/logout" method="post" class="mb-1 hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    const $header = $('header');
    const threshold = 30;

    $(window).on('scroll', function () {
        const scrolled = $(this).scrollTop();
        if (scrolled > threshold) {
            $header.addClass('shadow-xl');
        } else {
            $header.removeClass('shadow-xl');
        }
    });

    const $navContainer = $('#navbar');

    function openNav() {
        const $originalSvg = $('#originalSvg');
        const $newSvg = $('#newSvg');

        $originalSvg.toggle();
        $newSvg.toggle();

        $originalSvg.toggleClass('hidden');
        $newSvg.toggleClass('hidden');
        $navContainer.toggleClass('hidden');
    }

    const $navItems = $('.nav-item');

    function checkActiveRoutes() {
        const currentRoute = window.location.pathname.split('/').pop().toLowerCase();

        $navItems.each(function () {
        const $link = $(this);
        const href = $link.find('a').attr('href'); 

        $link.removeClass('text-custom-green font-bold').addClass('text-custom-dark');

        if (href && href.toLowerCase().endsWith(currentRoute)) {
            $link.addClass('text-custom-green font-bold');
        }
        });
    }
    checkActiveRoutes();

    const closePopup = $('#XModals, #closeModals');
    const confirmationOverlay = $('#confirmation-overlay');

    function logoutConfirmation() {
        confirmationOverlay.toggleClass('hidden');
        $('#yesLogout').click(function(event) {
            event.preventDefault();
            $('#yesLogout').next().submit();
        });
    }
    
    function toggleLogoutConfirmation() {
        confirmationOverlay.toggleClass('hidden');
    }
    closePopup.click(toggleLogoutConfirmation);
</script>