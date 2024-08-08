@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Izin Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Berikut Daftar Izin Kursus Anda!</p>

    <div class="flex">
        <a href="admin-driving-school-license/create"><div class="w-fit px-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">Unggah Izin Baru</div></a>
    </div>

    <h2 class="text-xl lg:text-2xl/snug mt-6 mb-3 lg:mt-6 lg:mb-3 text-custom-dark font-encode tracking-tight font-semibold">Izin Aktif</h2>
    @if ($activeLicense)
        <a href="{{ asset('storage/drivingSchoolLicense/' . $activeLicense->licensePath) }}" class="flex flex-col w-full lg:w-fit rounded-xl mb-6 drop-shadow-lg overflow-hidden" target="_blank">
            <img src="{{ asset('storage/drivingSchoolLicense/' . $activeLicense->licensePath) }}" alt="" class="w-full h-40 lg:h-60 object-cover object-top">
            <div class="flex flex-row p-3 lg:p-5 bg-custom-white-hover w-full lg:w-[30rem] font-league text-custom-dark">
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-base lg:text-lg mt-1">Tanggal Awal Berlaku :</p>
                    <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-lg lg:text-xl">{{ $activeLicense->formattedStartDate }}</h3>
                </div>
                <div class="flex flex-col w-1/2">
                    <p class="text-custom-grey font-league font-medium text-right text-base lg:text-lg mt-1">Tanggal Akhir Berlaku :</p>
                    <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-right text-lg lg:text-xl">{{ $activeLicense->formattedEndDate }}</h3>
                </div>
            </div>
        </a>
    @else
        <p class="font-league text-center px-5 lg:text-xl my-20 lg:my-14">(Anda tidak mempunyai Izin Aktif, <a href="admin-driving-school-license/create" class="font-semibold text-custom-green underline">Unggah Izin Baru Sekarang</a>)</p>
    @endif

    <h2 class="text-xl lg:text-2xl/snug mt-10 mb-3 lg:mt-10 lg:mb-3 text-custom-dark font-encode tracking-tight font-semibold">Daftar Izin Kursus Anda</h2>
    @if ($licenses)
        <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6 mb-7 lg:mb-14">
            @foreach ($licenses as $listOfLicense)
                <a href="{{ asset('storage/drivingSchoolLicense/' . $listOfLicense['licensePath']) }}" class="flex flex-col w-full rounded-xl drop-shadow-lg overflow-hidden" target="_blank">
                    <img src="{{ asset('storage/drivingSchoolLicense/' . $listOfLicense['licensePath']) }}" alt="Dokumen Izin Kursus" class="w-full h-40 lg:h-44 object-cover object-top">
                    <div class="flex flex-row flex-grow p-3 lg:p-5 bg-custom-white-hover w-full font-league text-custom-dark">
                        <div class="grid grid-cols-3 w-full">
                            <div class="flex flex-col">
                                <p class="text-custom-grey font-league font-medium text-base lg:text-lg mt-1">Status :</p>
                                <h3 class="text-custom-dark font-encode tracking-tight font-semibold text-lg lg:text-xl">{{ $listOfLicense['licenseStatus'] }}</h3>
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <p class="text-custom-grey font-league text-right font-medium text-base lg:text-lg mt-1">Tanggal Akhir Berlaku :</p>
                                <h3 class="text-custom-dark font-encode tracking-tight text-right font-semibold text-lg lg:text-xl">{{ $listOfLicense['formattedEndDate'] }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach        
        </div>
    @else
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Daftar Izin Kursus kosong)</p>        
    @endif

    @include('partials.footer')

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection