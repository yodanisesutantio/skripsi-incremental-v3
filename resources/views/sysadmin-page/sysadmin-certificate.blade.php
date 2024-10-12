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
                            <a href="{{ asset('storage/instructor_certificate/' . $certificates['certificatePath']) }}" class="w-2/3 h-full bg-cover bg-center" style="background-image: url('{{ asset('storage/instructor_certificate/' . $certificates['certificatePath']) }}')" target="_blank"></a>
                        </div>

                        {{-- Start Date --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ \Carbon\Carbon::parse($certificates->startCertificateDate)->translatedFormat('d F Y') }}</p>
                        </div>

                        {{-- End Date --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ \Carbon\Carbon::parse($certificates->endCertificateDate)->translatedFormat('d F Y') }}</p>
                        </div>

                        {{-- Owner --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal italic text-base/snug text-custom-white">{{ $certificates->instructor->username }}</p>
                        </div>

                        {{-- Status --}}
                        <div class="h-12 flex items-center">
                            <p class="font-league font-normal text-base/snug text-custom-white">{{ $certificates->certificateStatus }}</p>
                        </div>

                        {{-- Action --}}
                        <div class="h-12 flex flex-row gap-8 items-center justify-center">
                            @if ($certificates->certificateStatus !== 'Aktif' && $certificates->certificateStatus !== 'Tidak Berlaku')
                                {{-- Validate Certificate --}}
                                <form action="{{ url('/sysAdmin-certificate/status/' . $certificates->id) }}" method="POST" class="w-fit" onsubmit="return confirm('Are you sure you want to validate this Instructor Certificate?');">
                                    @csrf

                                    <input type="hidden" name="certificateStatus" value="Sudah Divalidasi">
                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" width="26" height="26" viewBox="0 0 256 256"><path fill="#3AB500" d="m229.66 77.66l-128 128a8 8 0 0 1-11.32 0l-56-56a8 8 0 0 1 11.32-11.32L96 188.69L218.34 66.34a8 8 0 0 1 11.32 11.32"/></svg></button>
                                </form>

                                {{-- Invalidate Certificate --}}
                                <form action="{{ url('/sysAdmin-certificate/status/' . $certificates->id) }}" method="POST" class="w-fit" onsubmit="return confirm('Are you sure you want to invalidate this Instructor Certificate?');">
                                    @csrf

                                    <input type="hidden" name="certificateStatus" value="Validasi Gagal">
                                    <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" width="26" height="26" viewBox="0 0 256 256"><path fill="#FD3124" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
                                </form>
                            @else
                                {{-- Inactive Validate Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="opacity-40" width="26" height="26" viewBox="0 0 256 256"><path fill="#3AB500" d="m229.66 77.66l-128 128a8 8 0 0 1-11.32 0l-56-56a8 8 0 0 1 11.32-11.32L96 188.69L218.34 66.34a8 8 0 0 1 11.32 11.32"/></svg>

                                {{-- Inactive Invalidate Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="opacity-40" width="26" height="26" viewBox="0 0 256 256"><path fill="#FD3124" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg>
                            @endif

                            <form action="{{ url('/sysAdmin-certificate/delete/' . $certificates->id) }}" method="POST" class="w-fit" onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                                @method('delete')
                                @csrf

                                <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" width="26" height="26" viewBox="0 0 256 256"><path fill="#F6F6F6" d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0m48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0"/></svg></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Navs --}}
        <div class="fixed bottom-5 left-1/2 bg-custom-dark transform -translate-x-1/2 flex flex-row gap-2 p-2 rounded-full">
            {{-- Account --}}
            <a href="{{ url('/sysAdmin-index') }}" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug hover:bg-custom-green/10 rounded-full cursor-pointer duration-300">Pengguna</a>
            {{-- Certificate --}}
            <a href="{{ url('/sysAdmin-certificate') }}" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug bg-custom-green/25 rounded-full cursor-pointer duration-300">Sertifikat</a>
            {{-- Licenses --}}
            <a href="{{ url('/sysAdmin-license') }}" class="px-5 py-2.5 font-league font-normal text-custom-white text-lg/snug hover:bg-custom-green/10 rounded-full cursor-pointer duration-300">Izin Kursus</a>
            {{-- Log Out --}}
            <form action="{{ url('/logout') }}" method="post">
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