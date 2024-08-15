@extends('layouts.relative')

@section('content')
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Formulir Pendaftaran Kursus</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Diisi pada {{ $enrollment->created_at->translatedFormat('d F Y') }}, Pukul {{ $enrollment->created_at->translatedFormat('H : i') }}</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl/tight text-custom-dark font-encode tracking-tight font-semibold">Formulir Pendaftaran Kursus</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Diisi pada {{ $enrollment->created_at->translatedFormat('d F Y') }}, Pukul {{ $enrollment->created_at->translatedFormat('H : i') }}</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:mt-7 lg:px-24">
            <div class="flex flex-col gap-5 lg:gap-8 my-3 mx-6 lg:mx-0 p-6 bg-custom-white-hover rounded-lg lg:rounded-xl">
                {{-- Personal Information Data --}}
                <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">A. Informasi Pribadi Siswa</h2>
        
                {{-- Student Real Name --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Nama Lengkap Siswa</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_real_name }}</h3>
                </div>
        
                {{-- Student Gender --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Jenis Kelamin</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_gender }}</h3>
                </div>
        
                {{-- Student Phone Number --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Nomor Telepon</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_phone_number }}</h3>
                </div>
        
                {{-- Student Birth of Place and Date --}}
                <div class="flex flex-row gap-10">
                    {{-- Student Birth of Place --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Tempat Lahir</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_birth_of_place }}</h3>
                    </div>
                    {{-- Student Birth of Date --}}
                    <div class="flex flex-col gap-1">
                        <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Tanggal Lahir</p>
                        <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ \Carbon\Carbon::parse($enrollment->student_birth_of_date)->translatedFormat('d F Y') }}</h3>
                    </div>
                </div>
                
                {{-- Student Education Level --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Pendidikan Terakhir</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_education_level }}</h3>
                </div>
                
                {{-- Student Occupation --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Pekerjaan</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_occupation }}</h3>
                </div>
                
                {{-- Student Address --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Alamat</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->student_address }}</h3>
                </div>
            </div>

            <div class="flex flex-col gap-5 lg:gap-8 mt-8 lg:mt-12 mb-5 mx-6 lg:mx-0 p-6 bg-custom-white-hover rounded-lg lg:rounded-xl">
                {{-- Instructor Data --}}
                <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">B. Instruktur Pengajar</h2>
        
                {{-- Instructor Name --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Nama Instruktur</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->instructor->fullname }}</h3>
                </div>

                {{-- Student Phone Number --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Nomor Telepon</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->instructor->phone_number }}</h3>
                </div>
            </div>

            <div class="flex flex-col gap-5 lg:gap-8 mt-8 lg:mt-12 mb-5 lg:mb-10 mx-6 lg:mx-0 p-6 bg-custom-white-hover rounded-lg lg:rounded-xl">
                {{-- Course Data --}}
                <h2 class="font-encode font-semibold text-xl/tight lg:text-[26px]/tight text-custom-dark">C. Kelas Kursus yang dipilih</h2>
        
                {{-- Course Name --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Nama Kelas Kursus</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->course->course_name }}</h3>
                </div>

                {{-- Course Duration --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Durasi Kursus</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->course->course_duration }} Menit</h3>
                </div>

                {{-- Course Length --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Jumlah Pertemuan</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">{{ $enrollment->course->course_length }} Pertemuan</h3>
                </div>

                {{-- Course Car_Type --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Jenis Transmisi Mobil</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">
                    @if ( $enrollment->course->car_type === "Manual" )
                        Manual
                    @elseif( $enrollment->course->car_type === "Automatic" )
                        Matic
                    @elseif( $enrollment->course->car_type === "Both" )
                        Manual / Matic
                    @endif
                    </h3>
                </div>

                {{-- Course Can_use_own_car --}}
                <div class="flex flex-col gap-1">
                    <p class="font-league font-medium text-base/tight lg:text-xl/tight text-custom-grey">Bisa pakai mobil sendiri?</p>
                    <h3 class="font-encode font-semibold text-lg/tight lg:text-[22px]/tight text-custom-dark">
                    @if ( $enrollment->course->can_use_own_car === 1 )
                        Bisa
                    @elseif( $enrollment->course->can_use_own_car === 0 )
                        Tidak Bisa
                    @endif
                    </h3>
                </div>
            </div>

        </div>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });
    </script>
@endsection