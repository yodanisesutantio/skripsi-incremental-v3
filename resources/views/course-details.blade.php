@extends('layouts.relative')

@section('content')
    <div class="flex flex-col lg:flex-row">
        {{-- Back Button --}}
        <div class="flex absolute top-8 left-5 bg-custom-dark-low rounded-full z-20 p-2 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4m0 0l6-6m-6 6l6 6"/></svg>
        </div>

        {{-- Class Image --}}
        <img src="img/{{ $classProperties['thumbnailSlug'] }}.jpg" alt="" class="h-[360px] object-cover w-screen lg:w-1/2 lg:h-screen">
        
        {{-- Content --}}
        <div class="lg:flex lg:flex-col lg:w-1/2 lg:h-screen lg:overflow-y-auto">
            {{-- Class Main Info --}}
            <div class="flex flex-col px-5 mt-4 lg:px-8 lg:mt-8 gap-1">
                <h1 class="font-encode text-3xl lg:text-4xl font-semibold tracking-tight">{{ $classProperties['className'] }}</h1>
                <p class="text-custom-grey text-lg lg:text-xl font-league">oleh <span class="font-semibold text-custom-dark"><a href="/driving-school-profile">{{ $classProperties['drivingSchool'] }}</a></span></p>
                <p class="font-league text-custom-dark font-bold text-2xl lg:text-3xl lg:mt-2">Rp. {{ number_format($classProperties['classPrice'], 0, '', '.') }},-</p>
            </div>

            {{-- Class Features --}}
            <div class="flex flex-col px-5 mt-6 lg:px-8 lg:mt-8 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl font-semibold text-custom-dark">Fasilitas & Keuntungan</h2>
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col w-1/3 h-36 justify-between p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256"><path fill="#040B0D" d="M240 114h-12.1l-28.31-63.69A14 14 0 0 0 186.8 42H69.2a14 14 0 0 0-12.79 8.31L28.1 114H16a6 6 0 0 0 0 12h10v82a14 14 0 0 0 14 14h24a14 14 0 0 0 14-14v-18h100v18a14 14 0 0 0 14 14h24a14 14 0 0 0 14-14v-82h10a6 6 0 0 0 0-12M67.37 55.19A2 2 0 0 1 69.2 54h117.6a2 2 0 0 1 1.83 1.19L214.77 114H41.23ZM66 208a2 2 0 0 1-2 2H40a2 2 0 0 1-2-2v-18h28Zm150 2h-24a2 2 0 0 1-2-2v-18h28v18a2 2 0 0 1-2 2m2-32H38v-52h180ZM58 152a6 6 0 0 1 6-6h16a6 6 0 0 1 0 12H64a6 6 0 0 1-6-6m112 0a6 6 0 0 1 6-6h16a6 6 0 0 1 0 12h-16a6 6 0 0 1-6-6"/></svg>
                        <p class="font-league font-medium text-[16px]/snug lg:text-xl/tight">Mobil Anda Sendiri</p>
                    </div>

                    <div class="flex flex-col w-1/3 h-36 justify-between p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/></g></svg>
                        <p class="font-league font-medium text-[16px]/snug lg:text-xl/tight">5x2 Jam Pertemuan</p>
                    </div>

                    <div class="flex flex-col w-1/3 h-36 justify-between p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl flex-grow gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><g fill="none" stroke="#040B0D" stroke-width="1.5"><path stroke-linecap="round" d="M8 13h8m-8 0v5c0 1.886 0 2.828.586 3.414C9.172 22 10.114 22 12 22c1.886 0 2.828 0 3.414-.586C16 20.828 16 19.886 16 18v-5m-8 0a7.459 7.459 0 0 1-5.618-5.472L2 6m14 7c1.71 0 3.15 1.28 3.35 2.98L20 21.5"/><circle cx="12" cy="6" r="4"/></g></svg>
                        <p class="font-league font-medium text-[16px]/snug lg:text-xl/tight">Instruktur Datang Kerumah</p>
                    </div>
                </div>
            </div>

            {{-- Class Description --}}
            <div class="flex flex-col px-5 mt-6 lg:px-8 lg:mt-8 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl font-semibold text-custom-dark">Deskripsi Kelas</h2>
                <p id="content" class="font-league text-lg/snug lg:text-xl/tight line-clamp-3 text-custom-dark mb-1">{{ $classProperties['description'] }}</p>
                <button type="button" id="readMoreButton" class="text-custom-green w-fit text-lg font-bold hidden hover:underline">Baca Selengkapnya</button>
            </div>  

            {{-- Darken Overlay --}}
            <div id="modal-overlay" class="hidden fixed top-0 left-0 lg:left-1/2 w-full lg:w-1/2 h-full bg-custom-dark opacity-75"></div>

            {{-- Read More Popup --}}
            <div id="modal" class="hidden fixed bottom-0 h-4/5 py-4 z-40 bg-custom-white rounded-tl-xl rounded-tr-xl">
                <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                    <h2 class="font-league text-[27px]/[2rem] lg:text-3xl font-semibold text-custom-dark ">Deskripsi Kelas</h2>
                    <button type="button" id="closeButton" class="text-custom-green text-lg font-bold hover:underline">Tutup</button>
                </div>
                <div class="overflow-y-auto h-[32rem] px-5 pb-4">
                    <p id="contentOnModals" class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">{{ $classProperties['description'] }}</p>
                </div>
            </div>

            {{-- Instructor Section --}}
            <div class="flex flex-col mt-6 lg:px-3 lg:mt-8 gap-1">
                <h2 class="font-league text-2xl lg:text-3xl px-5 font-semibold text-custom-dark">Instruktur Kami</h2>
                
                {{-- Instructor Wrapper --}}
                <div class="relative flex items-center" id="instructorContainer">
                    {{-- Left Button --}}
                    <div class="absolute -left-2 hidden w-14 h-14 rounded-full bg-custom-white-hover items-center justify-center z-30 cursor-pointer hover:shadow-lg hover:bg-custom-white duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="26" height="26" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
                    </div>

                    {{-- Instructor Container for Mobile --}}
                    <div class="flex flex-row gap-3 px-5 lg:gap-4 overflow-x-auto lg:hidden" style="scrollbar-width: none;">
                        @foreach ($instructorArray as $instructorMobile)
                            {{-- Instructor Card --}}
                            <div class="flex flex-col w-40 max-w-72 flex-shrink-0 lg:flex-grow items-center p-3 bg-custom-white-hover border border-custom-disabled-light rounded-xl gap-3">
                                <svg width="64px" height="64px" class="mt-2 rounded-full bg-cover bg-center bg-no-repeat" style="background-image: url('img/{{ $instructorMobile['thumbnailSlug'] }}.jpg');"></svg>
                                <div class="flex flex-col w-full mb-1">
                                    <p class="font-league font-semibold text-xl/snug lg:text-2xl/snug text-center truncate">{{ $instructorMobile['instructorName'] }}</p>
                                    <i class="font-league text-custom-grey text-base/none lg:text-lg/none text-center truncate">{{ $instructorMobile['instructorAge'] }} tahun</i>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Instructor Container for Large Views --}}
                    <div class="hidden lg:grid lg:grid-flow-col gap-2 w-full mx-5 overflow-x-auto scroll-smooth" style="grid-auto-columns: calc((100% / 3) - 6px); scrollbar-width: none; scroll-snap-type: x mandatory;" id="instructor-container">
                        @foreach ($instructorArray as $instructorLarge)
                            {{-- Instructor Card --}}
                            <div class="flex flex-col gap-3 bg-custom-white-hover border border-custom-disabled-light p-4 rounded-xl items-center">
                                <svg width="64px" height="64px" class="mt-2 rounded-full bg-cover bg-center bg-no-repeat" style="background-image: url('img/{{ $instructorLarge['thumbnailSlug'] }}.jpg');"></svg>
                                <div class="flex flex-col w-full mb-1">
                                    <p class="font-league font-semibold text-xl/snug lg:text-2xl/snug text-center truncate">{{ $instructorLarge['instructorName'] }}</p>
                                    <i class="font-league text-custom-grey text-base/none lg:text-lg/none text-center truncate">{{ $instructorLarge['instructorAge'] }} tahun</i>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Right Button --}}
                    <div class="absolute -right-2 hidden w-14 h-14 rounded-full bg-custom-white-hover items-center justify-center z-30 cursor-pointer hover:shadow-lg hover:bg-custom-white duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="26" height="26" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
                    </div>
                </div>
            </div>

            {{-- Similar Class Recommendation --}}
            <div class="flex flex-row px-5 lg:px-8 justify-between items-center mb-2 mt-8">
                <h2 class="font-league text-2xl lg:text-3xl font-semibold text-custom-dark">Kelas Serupa</h2>
            </div>
            {{-- Similar Class Wrapper --}}
            <div class="relative flex items-center px-0 lg:px-3 mb-1 cursor-pointer" id="classOfferedContainer">
                {{-- Left Button --}}
                <div class="absolute left-2 hidden w-14 h-14 rounded-full bg-custom-white-hover items-center justify-center z-30 cursor-pointer hover:shadow-lg hover:bg-custom-white duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="26" height="26" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>
                </div>

                {{-- Similar Class Card Mobile Container --}}
                <div class="flex flex-row gap-3 px-5 mb-2 overflow-x-auto lg:hidden" style="scrollbar-width: none;">
                    @foreach ($offered as $offeredFlex)
                        {{-- Similar Class Card --}}
                        <div class="bg-center bg-cover rounded-xl" style="background-image: url('img/{{ $offeredFlex['thumbnailSlug'] }}.jpg');">
                            <div class="relative flex flex-col flex-shrink-0 w-48 lg:w-[22.5rem] h-60 lg:h-[14rem] justify-end gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low lg:transition-colors duration-500">
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $offeredFlex['totalMeetings'] }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $offeredFlex['className'] }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light">{{ $offeredFlex['drivingSchool'] }} · {{ $offeredFlex['drivingSchoolAddress'] }}</p>
                                </div>
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 pt-2 pb-1 lg:px-4 lg:pt-3 lg:pb-2 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">IDR {{ $offeredFlex['classPrice'] / 1000 }}K</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Similar Class Card Container for Large Views --}}
                <div class="hidden lg:grid lg:grid-flow-col gap-3 w-full lg:mx-5 overflow-x-auto scroll-smooth" style="grid-auto-columns: calc((100% / 2) - 6.5px); scrollbar-width: none; scroll-snap-type: x mandatory;" id="class-container">
                    @foreach ($offered as $offeredGrid)
                        {{-- Similar Class Card --}}
                        <div class="bg-center bg-cover rounded-xl" style="background-image: url('img/{{ $offeredGrid['thumbnailSlug'] }}.jpg');">
                            <div class="relative flex flex-col flex-shrink-0 w-full h-56 justify-end gap-3 rounded-xl lg:cursor-pointer lg:hover:bg-custom-dark-low duration-500">
                                <div class="flex flex-col px-3 py-3 rounded-xl backdrop-blur-sm bg-custom-dark-low text-custom-white font-league">
                                    <p class="text-sm/tight lg:text-lg/tight font-light lg:mb-[-2px]">{{ $offeredGrid['totalMeetings'] }} Pertemuan</p>
                                    <h3 class="text-xl/tight lg:text-2xl/tight font-semibold truncate mb-1 lg:mb-[0px]">{{ $offeredGrid['className'] }}</h3>
                                    <p class="text-sm lg:text-lg/tight font-light">{{ $offeredGrid['drivingSchool'] }} · {{ $offeredGrid['drivingSchoolAddress'] }}</p>
                                </div>
                                <div class="absolute top-0 right-0 bg-custom-destructive text-custom-white font-league px-3 pt-2 pb-1 lg:px-4 lg:pt-3 lg:pb-2 rounded-bl-xl rounded-tr-xl">
                                    <p class="text-md lg:text-xl lg:font-medium">IDR {{ $offeredGrid['classPrice'] / 1000 }}K</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Right Button --}}
                <div class="absolute right-2 hidden w-14 h-14 rounded-full bg-custom-white-hover items-center justify-center z-30 cursor-pointer hover:shadow-lg hover:bg-custom-white duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1" width="26" height="26" viewBox="0 0 23 23"><path fill="none" stroke="#151C1E" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
                </div>
            </div>

            {{-- Button for Large Screen --}}
            <div class="lg:flex sticky bottom-0 z-20 px-5 py-4 items-center bg-custom-white hidden">
                <a href="/course-register-1" class="flex justify-center items-center bg-custom-green hover:bg-custom-green-hover text-custom-white w-full h-11 font-league text-lg/none font-medium rounded-md duration-300">Daftar Kelas</a>
            </div>
        </div>
    </div>

    {{-- Button for Mobile --}}
    <div class="flex sticky bottom-0 z-20 px-5 py-4 items-center bg-custom-white lg:hidden">
        <a href="/course-register-1" class="flex justify-center items-center bg-custom-green text-custom-white w-full h-11 font-league text-lg/none font-medium rounded-md">Daftar Kelas</a>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection