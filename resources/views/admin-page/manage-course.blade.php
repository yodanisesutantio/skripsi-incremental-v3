@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-3xl lg:text-4xl/snug mt-5 lg:mt-10">Kelas Kursus Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl mt-1">Pilih salah satu kelas untuk anda kelola!</p>

    {{-- Create New Course Button --}}
    <div class="flex">
        <a href="admin-manage-course/create"><div class="w-fit pl-3.5 pr-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+ Tambah Kelas</div></a>
    </div>

    {{-- If Admin's haven't added any Course, display this --}}
    @if ($course->isEmpty())
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai kursus)</p>
    @else
    
    {{-- Class List --}}
    <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6 mt-8 lg:mt-10 mb-7 lg:mb-14">
        {{-- Read Through the Course List --}}
        @foreach ($course as $myCourse)
        <div class="w-full rounded-xl overflow-hidden drop-shadow-lg course-container">
            {{-- If course_thumbnail exist, show this --}}
            @if ($myCourse['course_thumbnail'])
            {{-- Course Thumbnail --}}
            <div class="relative w-full h-36 bg-cover bg-center" style="background-image: url('{{ asset('storage/classOrCourse_thumbnail/' . $myCourse['course_thumbnail']) }}')">

            {{-- If course_thumbnail is not exist, show this instead --}}
            @else
            <div class="relative w-full h-36 bg-cover bg-center" style="background-image: url('{{ asset('img/BG-Class-4.webp') }}')">
            @endif                            

                {{-- Edit and Delete Button --}}
                <div class="absolute top-3 right-3 flex flex-row gap-2">
                    {{-- Edit --}}
                    <a href="{{ url('/admin-manage-course/edit/' . $myCourse->admin->username . '/' . $myCourse['course_name']) }}" class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-width="1.5" d="m14.36 4.079l.927-.927a3.932 3.932 0 0 1 5.561 5.561l-.927.927m-5.56-5.561s.115 1.97 1.853 3.707C17.952 9.524 19.92 9.64 19.92 9.64m-5.56-5.561l-8.522 8.52c-.577.578-.866.867-1.114 1.185a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.094 3.281m17.6-10.162L11.4 18.16c-.577.577-.866.866-1.184 1.114a6.554 6.554 0 0 1-1.211.749c-.364.173-.751.302-1.526.56l-3.281 1.094m0 0l-.802.268a1.06 1.06 0 0 1-1.342-1.342l.268-.802m1.876 1.876l-1.876-1.876"/></svg></a>
                    @if ($myCourse->enrollments()->count() === 0)
                        {{-- Delete --}}
                        <button class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden deleteCourseButton"  data-id="{{ $myCourse['id'] }}" data-name="{{ $myCourse['course_name'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></button>
                    @else
                        {{-- Unclickable Delete --}}
                        <div class="bg-custom-dark/60 flex-shrink-0 p-2.5 rounded-xl overflow-hidden opacity-40 cantDeleteCourseButton" data-name="{{ $myCourse['course_name'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="1.5" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></div>
                    @endif
                </div>
            </div>

            <div class="flex flex-col p-3 bg-custom-white-hover font-league text-custom-dark">
                <div class="flex flex-row justify-between">
                    {{-- Course Length --}}
                    <p class="font-medium text-base/tight text-custom-grey/80">{{ $myCourse['course_length'] }} Pertemuan</p>
                    {{-- Course Quota --}}
                    <p class="font-medium text-base/tight text-custom-grey/80"><span class="text-custom-dark font-semibold">{{ $myCourse->enrollments()->count() }}</span> / {{ $myCourse['course_quota'] }} Siswa</p>
                </div>

                {{-- Course Name --}}
                <h2 class="mt-1.5 mb-5 font-encode tracking-tight font-semibold text-xl/tight">{{ $myCourse['course_name'] }}</h2>
                <div class="flex flex-row justify-between">
                    {{-- Course Active Availability Toggle --}}
                    @if ($myCourse['course_availability'] === 1)
                        <div class="flex flex-row items-center gap-2.5">
                            <button type="button" class="relative flex items-center deactivate-course" data-id="{{ $myCourse['id'] }}">
                                <div class="flex-shrink-0 w-12 h-4 bg-custom-green rounded-full"></div>
                                <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg right-0"></div>
                            </button>
                            <p class="text-base/tight mt-1">Aktif</p>
                        </div>

                    {{-- Course Inactive Availability Toggle --}}
                    @else
                        <div class="flex flex-row items-center gap-2.5">
                            <button type="button" class="relative flex items-center activate-course" data-id="{{ $myCourse['id'] }}">
                                <div class="flex-shrink-0 w-12 h-4 bg-custom-disabled-light/50 rounded-full"></div>
                                <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg left-0"></div>
                            </button>
                            <p class="text-base/tight mt-1">Nonaktif</p>
                        </div>
                    @endif

                    {{-- Course Price --}}
                    <h3 class="font-semibold text-right text-lg/tight">Rp. {{ number_format($myCourse['course_price'], 0, ',', '.') }},-</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Delete Course Overlay --}}
    <div id="deleteCourseOverlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Delete Course Confirmation --}}
        <div id="deleteCourseDialogBox" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                {{-- Modals Header --}}
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Kelas?</h2>
                <button type="button" id="XDeleteCourseDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>

            {{-- Delete Confirmation Message --}}
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus kelas <strong id="courseNameToDelete"></strong> ?</p>
            </div>

            {{-- Action Button Groups --}}
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeDeleteCourseDialogBox" class="w-fit rounded text-left p-3 text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesDeleteCourse" class="w-fit rounded text-left p-3 bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Hapus Kelas</button>
                <form id="deleteCourseForm" method="post" class="mb-1 hidden">
                    @method('delete')
                    @csrf
                </form>
            </div>
        </div>
    </div>

    @include('partials.footer')

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Activate and Deactivate Course Button
        $(document).on('click', '.deactivate-course, .activate-course', function() {
            var button = $(this); // Which button is clicked
            var courseId = button.data('id'); // ID of the course
            var actionUrl = button.hasClass('deactivate-course') ? '/admin-deactivate-course' : '/admin-activate-course'; // if deactivate button is clicked, redirect to admin-deactivate-course route, else, redirect to admin-activate-course
            var newAvailability = button.hasClass('deactivate-course') ? 0 : 1; // Bring the new value, 1 to activate, 0 to deactivate

            // AJAX Function
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    course_id: courseId,
                    course_availability: newAvailability
                },

                // If availability change success, do this
                success: function(response) {
                    // Do this when availability change successful
                    if (response.success) {
                        // Update the active switch to deactivate switch
                        if (newAvailability === 0) {
                            button.removeClass('deactivate-course').addClass('activate-course');
                            button.find('.w-7').removeClass('right-0').addClass('left-0');
                            button.find('.w-12').removeClass('bg-custom-green').addClass('bg-custom-disabled-light/50');
                            button.next('p').text('Nonaktif');
                        } 
                        
                        // Update the deactivate switch to activate switch
                        else {
                            button.removeClass('activate-course').addClass('deactivate-course');
                            button.find('.w-7').removeClass('left-0').addClass('right-0');
                            button.find('.w-12').removeClass('bg-custom-disabled-light/50').addClass('bg-custom-green');
                            button.next('p').text('Aktif');
                        }
                    }
                    
                    // Do this when availability change failed
                    else {
                        toastr.options.timeOut = 2500;
                        toastr.options.closeButton = true;
                        toastr.options.progressBar = true;
                        toastr.error('Sistem tidak bisa melanjutkan proses. Silahkan Coba Lagi');
                    }
                },

                // When availability change error
                error: function(xhr) {
                    toastr.options.timeOut = 2500;
                    toastr.options.closeButton = true;
                    toastr.options.progressBar = true;
                    toastr.error('Sistem tidak bisa melanjutkan proses. Silahkan Coba Lagi');
                }
            });
        });

        let courseId;
        // Delete Course Function
        $('.deleteCourseButton').on('click', function() {
            courseId = $(this).data('id');
            const courseName = $(this).data('name');
            $('#deleteCourseName').text(courseName);
            $('#deleteCourseForm').attr('action', `/admin-delete-course/${courseId}`);
            $('#deleteCourseOverlay').removeClass('hidden');
            $('#deleteCourseOverlay').addClass('flex');
        });

        // Close Modals
        $('#XDeleteCourseDialogBox, #closeDeleteCourseDialogBox').on('click', function() {
            $('#deleteCourseOverlay').addClass('hidden');
            $('#deleteCourseOverlay').removeClass('flex');
        });

        // Handle the form submission
        $('#yesDeleteCourse').on('click', function (e) {
            e.preventDefault();
            $('#deleteCourseForm').submit();
        });

        // Error Toastr Message to Show When Users force to click the delete button when it cant be deleted
        $('.cantDeleteCourseButton').on('click', function() {
            const courseName = $(this).data('name');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning('Kelas ' + courseName + ' masih memiliki Siswa aktif!');
        });
    </script>
@endsection