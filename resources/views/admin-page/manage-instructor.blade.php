@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Instruktur Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Pilih salah satu Instruktur untuk anda kelola!</p>

    <div class="flex">
        <a href="admin-manage-course/create"><div class="w-fit pl-3.5 pr-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+ Tambah Instruktur</div></a>
    </div>

    {{-- @if ($course->isEmpty()) --}}
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai instruktur)</p>
    {{-- @else --}}
    {{-- Class List --}}
    <div class="flex lg:grid flex-col lg:grid-cols-3 gap-6 mt-8 mb-7 lg:mb-14">
        
    </div>
    {{-- @endif --}}

    {{-- Delete Course Overlay --}}
    <div id="deleteCourseOverlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Delete Course Confirmation --}}
        <div id="deleteCourseDialogBox" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Kelas?</h2>
                <button type="button" id="XDeleteCourseDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus kelas <strong id="courseNameToDelete"></strong> ?</p>
            </div>
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
        $(document).on('click', '.deactivate-course, .activate-course', function() {
            var button = $(this);
            var courseId = button.data('id');
            var actionUrl = button.hasClass('deactivate-course') ? '/admin-deactivate-course' : '/admin-activate-course';
            var newAvailability = button.hasClass('deactivate-course') ? 0 : 1;

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    course_id: courseId,
                    course_availability: newAvailability
                },
                success: function(response) {
                    if (response.success) {
                        // Update the button and text dynamically
                        if (newAvailability === 0) {
                            button.removeClass('deactivate-course').addClass('activate-course');
                            button.find('.w-7').removeClass('right-0').addClass('left-0');
                            button.find('.w-12').removeClass('bg-custom-green').addClass('bg-custom-disabled-light/50');
                            button.next('p').text('Nonaktif');
                        } else {
                            button.removeClass('activate-course').addClass('deactivate-course');
                            button.find('.w-7').removeClass('left-0').addClass('right-0');
                            button.find('.w-12').removeClass('bg-custom-disabled-light/50').addClass('bg-custom-green');
                            button.next('p').text('Aktif');
                        }
                    } else {
                        alert('Failed to update course availability');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred');
                }
            });
        });

        let courseId;

        $('.deleteCourseButton').on('click', function() {
            courseId = $(this).data('id');
            const courseName = $(this).data('name');
            $('#deleteCourseName').text(courseName);
            $('#deleteCourseForm').attr('action', `/admin-delete-course/${courseId}`);
            $('#deleteCourseOverlay').removeClass('hidden');
            $('#deleteCourseOverlay').addClass('flex');
        });

        $('#XDeleteCourseDialogBox, #closeDeleteCourseDialogBox').on('click', function() {
            $('#deleteCourseOverlay').addClass('hidden');
            $('#deleteCourseOverlay').removeClass('flex');
        });

        // Handle the form submission
        $('#yesDeleteCourse').on('click', function (e) {
            e.preventDefault();
            $('#deleteCourseForm').submit();
        });
    </script>
@endsection