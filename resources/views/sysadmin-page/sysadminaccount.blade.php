@extends('layouts.dark-main')

@section('content')
    {{-- Grid Wrapper --}}
    <div class="grid grid-cols-5 h-dvh">
        <div class="w-full border-r border-custom-white p-8 rounded-tr-lg rounded-br-lg">
            <div class="flex flex-col justify-between h-full">
                <div class="flex flex-col gap-4">
                    {{-- Home Navs --}}
                    <a href="#" class="flex flex-row items-center gap-5 p-4 w-full cursor-pointer hover:bg-custom-green/10 rounded-lg duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="2"><path d="M2.364 12.958c-.38-2.637-.57-3.956-.029-5.083c.54-1.127 1.691-1.813 3.992-3.183l1.385-.825C9.8 2.622 10.846 2 12 2c1.154 0 2.199.622 4.288 1.867l1.385.825c2.3 1.37 3.451 2.056 3.992 3.183c.54 1.127.35 2.446-.03 5.083l-.278 1.937c-.487 3.388-.731 5.081-1.906 6.093C18.276 22 16.553 22 13.106 22h-2.212c-3.447 0-5.17 0-6.345-1.012c-1.175-1.012-1.419-2.705-1.906-6.093z"/><path stroke-linecap="round" d="M12 15v3"/></g></svg>
    
                        <p class="font-league font-normal text-lg/tight text-custom-white mt-1">Beranda</p>
                    </a>
                    
                    {{-- Account Navs --}}
                    <a href="#" class="flex flex-row items-center gap-5 p-4 w-full cursor-pointer bg-custom-green/25 rounded-lg duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="2"><circle cx="12" cy="6" r="4"/><path d="M20 17.5c0 2.485 0 4.5-8 4.5s-8-2.015-8-4.5S7.582 13 12 13s8 2.015 8 4.5Z"/></g></svg>
    
                        <p class="font-league font-normal text-lg/tight text-custom-white mt-1">Pengguna</p>
                    </a>
    
                    {{-- Instructor Navs --}}
                    <a href="#" class="flex flex-row items-center gap-5 p-4 w-full cursor-pointer hover:bg-custom-green/10 rounded-lg duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="2"><path d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12Z"/><path stroke-linecap="round" d="M10 16H6m8 0h-1.5M2 10h20"/></g></svg>
    
                        <p class="font-league font-normal text-lg/tight text-custom-white mt-1">Sertifikat</p>
                    </a>
    
                    {{-- Licenses Navs --}}
                    <a href="#" class="flex flex-row items-center gap-5 p-4 w-full cursor-pointer hover:bg-custom-green/10 rounded-lg duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#F6F6F6" stroke-width="2"><path d="M3 10c0-3.771 0-5.657 1.172-6.828C5.343 2 7.229 2 11 2h2c3.771 0 5.657 0 6.828 1.172C21 4.343 21 6.229 21 10v4c0 3.771 0 5.657-1.172 6.828C18.657 22 16.771 22 13 22h-2c-3.771 0-5.657 0-6.828-1.172C3 19.657 3 17.771 3 14z"/><path stroke-linecap="round" d="M8 12h8M8 8h8m-8 8h5"/></g></svg>
    
                        <p class="font-league font-normal text-lg/tight text-custom-white mt-1">Izin Kursus</p>
                    </a>
                </div>

                {{-- Log Out Navs --}}
                <form action="/logout" method="POST">
                    @csrf
                    
                    <button type="submit" name="submit" class="flex flex-row items-center gap-5 p-4 w-full cursor-pointer hover:bg-custom-destructive/10 rounded-lg duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="#FD3124" stroke-width="2"><path d="M9 4.5H8c-2.357 0-3.536 0-4.268.732C3 5.964 3 7.143 3 9.5v5c0 2.357 0 3.535.732 4.268c.732.732 1.911.732 4.268.732h1M9 6.476c0-2.293 0-3.44.707-4.067c.707-.627 1.788-.439 3.95-.062l2.33.407c2.394.417 3.591.626 4.302 1.504c.711.879.711 2.149.711 4.69v6.105c0 2.54 0 3.81-.71 4.689c-.712.878-1.91 1.087-4.304 1.505l-2.328.406c-2.162.377-3.243.565-3.95-.062C9 20.964 9 19.817 9 17.524z"/><path stroke-linecap="round" d="M12 11v2"/></g></svg>
    
                        <p class="font-league font-normal text-lg/tight text-custom-destructive mt-1">Log Out</p>
                    </a>
                </form>
            </div>
        </div>

        <div class="w-full col-span-4 px-16 py-8">
            <h2 class="font-semibold font-encode text-4xl/tight text-custom-white mb-2">Daftar Pengguna</h2>
            <p class="font-light font-league text-lg/tight text-custom-white">Berikut adalah daftar pengguna KEMUDI</p>

            {{-- Account Tables --}}
            <div class="grid grid-cols-5 gap-3">
                {{-- Account Profile Picture --}}
                <div class="w-1/2 h-12 flex items-center justify-center">
                    <img src="" alt="" class="w-6 h-6 rounded-full">
                </div>
            </div>
        </div>
    </div>
@endsection