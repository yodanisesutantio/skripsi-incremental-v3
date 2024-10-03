@extends('layouts.dark-main')

@section('content')
    {{-- Grid Wrapper --}}
    <div class="relative flex flex-col w-full h-dvh">
        <div class="my-8">
            <h2 class="font-semibold font-encode text-4xl/tight text-center text-custom-white mb-2">Sertifikat Instruktur</h2>
            <p class="font-light font-league text-lg/tight text-center text-custom-white">Berikut adalah daftar Sertifikat Instruktur yang berhasil diunggah di aplikasi KEMUDI</p>
        </div>

        <div class="px-20 flex flex-col w-full h-full mt-8">
            {{-- Certificate Tables --}}
            <div class="flex flex-col pb-28">
                <div class="grid grid-cols-6 gap-6 px-4 pb-2 border-b border-custom-white/25">
                    {{-- Certificate Thumbnail --}}
                    <div class="flex flex-col justify-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">Certificate</h2>
                    </div>

                    {{-- Start Date --}}
                    <div class="flex flex-col justify-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">Start Date</h2>
                    </div>

                    {{-- End Date --}}
                    <div class="flex flex-col justify-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">End Date</h2>
                    </div>

                    {{-- Owner --}}
                    <div class="flex flex-col justify-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">Instructor</h2>
                    </div>

                    {{-- Status --}}
                    <div class="flex flex-col justify-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">Status</h2>
                    </div>

                    {{-- Action --}}
                    <div class="flex flex-col justify-center items-center">
                        <h2 class="font-encode font-semibold text-2xl/snug text-custom-white">Actions</h2>
                    </div>
                </div>

                @foreach ($certificate as $index => $certificates)
                    <div class="grid grid-cols-6 gap-6 px-4 py-6 border-b border-custom-white/20 {{ $index % 2 == 0 ? 'bg-custom-dark/20' : '' }}">
                        {{-- Certificate Thumbnail --}}
                        <div class="h-12 flex items-center">
                            <a href="{{ asset('storage/instructor_certificate/' . $certificates['certificatePath']) }}" class="w-2/3 h-full bg-cover bg-center" style="background-image: url('{{ asset('storage/instructor_certificate/' . $certificates['certificatePath']) }}')"></a>
                        </div>

                        {{-- Start Date --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal italic text-base/snug text-custom-white">{{ \Carbon\Carbon::parse($certificates->startCertificateDate)->translatedFormat('d F Y') }}</p>
                        </div>

                        {{-- End Date --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ \Carbon\Carbon::parse($certificates->endCertificateDate)->translatedFormat('d F Y') }}</p>
                        </div>

                        {{-- Owner --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ $certificates->instructor->username }}</p>
                        </div>

                        {{-- Status --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ $certificates->certificateStatus }}</p>
                        </div>

                        {{-- Action --}}
                        <div class="h-12 flex flex-row gap-2 items-center">
                            {{-- Update Status --}}
                            <form action="{{ url('') }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to reset the password to 12345678?');">
                                @csrf

                                <input type="hidden" name="password" value="12345678">
                                <button type="submit" class="w-full py-3 font-encode font-semibold text-custom-destructive bg-[#FEE2E2] rounded-lg hover:bg-custom-white-hover duration-300">Validate</button>
                            </form>

                            {{-- Delete Certificate --}}
                            <form action="{{ url('') }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to reset the password to 12345678?');">
                                @csrf

                                <input type="hidden" name="password" value="12345678">
                                <button type="submit" class="w-full py-3 font-encode font-semibold text-custom-destructive bg-[#FEE2E2] rounded-lg hover:bg-custom-white-hover duration-300">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navs --}}
        <div class="fixed bottom-5 left-1/2 bg-custom-dark transform -translate-x-1/2 flex flex-row gap-2 p-2 rounded-full">
            {{-- Account --}}
            <a href="/sysAdmin-index" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug hover:bg-custom-green/10 rounded-full cursor-pointer duration-300">Pengguna</a>
            {{-- Certificate --}}
            <a href="/sysAdmin-certificate" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug bg-custom-green/25 rounded-full cursor-pointer duration-300">Sertifikat</a>
            {{-- Licenses --}}
            <a href="#" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug hover:bg-custom-green/10 rounded-full cursor-pointer duration-300">Izin Kursus</a>
            {{-- Log Out --}}
            <form action="/logout" method="post">
                @csrf
                
                <button type="submit" class="px-5 py-2.5 font-league font-normal text-custom-destructive text-lg/snug hover:bg-custom-destructive/10 rounded-full cursor-pointer duration-300">Log Out</button>
            </form>
        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        
    </script>
@endsection