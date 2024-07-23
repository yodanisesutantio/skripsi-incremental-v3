@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-league font-semibold text-2xl lg:text-4xl">Kelas Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl">Kelola kelas anda agar lebih menarik</p>

    <a href="admin-manage-course/create"> <div class="w-fit px-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+  Tambah Kelas</div></a>

    {{-- Class List --}}
    <div class="flex flex-col gap-5 mt-8 mb-5 lg:mb-8">
        @if ($course->isEmpty())
            <p class="font-league text-center lg:text-xl my-3 lg:my-6">(Anda belum mempunyai kursus)</p>
        @else
            @foreach ($course as $myCourse)
                <div class="w-full rounded-xl overflow-hidden drop-shadow-lg">
                    @if ($myCourse['course_thumbnail'])
                        <img src="{{ asset($myCourse['course_thumbnail']) }}" alt="Course Thumbnail" class="">
                    @else
                        <img src="img/BG-Class-4.webp" alt="Default Thumbnail" class="w-full h-32 object-cover object-center">
                        <div class="flex flex-col gap-1.5 p-3 bg-custom-white-hover font-league text-custom-dark">
                            <h2 class="font-semibold text-xl/tight">{{ $myCourse['course_name'] }}</h2>
                            <p class="font-normal text-base/tight line-clamp-2">{{ $myCourse['course_description'] }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    @include('partials.footer')
@endsection