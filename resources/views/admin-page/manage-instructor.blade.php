@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode font-semibold text-3xl lg:text-4xl mt-5 lg:mt-10">Instruktur Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg lg:text-2xl mt-1">Pilih salah satu Instruktur untuk anda kelola!</p>

    <div class="flex">
        <a href="admin-manage-course/create"><div class="w-fit pl-3.5 pr-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+ Tambah Instruktur</div></a>
    </div>

    @if ($instructors->isEmpty())
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai instruktur)</p>
    @else
        {{-- Instructors List --}}
        <div class="w-full flex lg:grid flex-col lg:grid-cols-3 gap-4 lg:gap-6 mt-4 lg:mt-10 mb-7 lg:mb-14">
            @foreach ($instructors as $myInstructor)
            <div class="flex flex-row gap-3 w-full rounded-xl bg-custom-white-hover drop-shadow-lg overflow-hidden">
                @if ($myInstructor['hash_for_profile_picture'])
                    <img src="{{ asset('storage/profile_pictures/' . $myInstructor['hash_for_for_profile_picture']) }}" alt="" class="object-cover object-center rounded-lg w-20 lg:w-24 flex-grow">
                @else
                    <img src="img/blank-profile.webp" alt="" class="object-cover object-center rounded-lg w-20 lg:w-24 flex-grow">
                @endif

                <div class="flex flex-row justify-between w-full gap-2">
                    <div class="flex flex-col gap-7 pt-2 pb-3">
                        <div class="flex flex-col gap-1">
                            <h2 class="font-encode font-semibold text-xl lg:text-2xl">{{ $myInstructor['fullname'] }}</h2>
                            <i class="font-league font-medium text-base/tight lg:text-lg text-custom-grey">Sedang mengajar {{ $myInstructor->enrollments->count() }} Siswa</i>
                        </div>

                        {{-- Instructor Availability Toggle --}}
                        @if ($myInstructor['availability'] === 1)
                            <div class="flex flex-row gap-2.5 mb-1">
                                <button type="button" class="relative flex items-center deactivate-instructor" data-id="{{ $myInstructor['id'] }}">
                                    <div class="flex-shrink-0 w-12 h-4 bg-custom-green rounded-full"></div>
                                    <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg right-0"></div>
                                </button>
                                <p class="text-sm/snug lg:text-base/tight">Aktif</p>
                            </div>
                        @else
                            <div class="flex flex-row gap-2.5 mb-1">
                                <button type="button" class="relative flex items-center activate-instructor" data-id="{{ $myInstructor['id'] }}">
                                    <div class="flex-shrink-0 w-12 h-4 bg-custom-disabled-light/50 rounded-full"></div>
                                    <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg left-0"></div>
                                </button>
                                <p class="text-sm/snug lg:text-base/tight">Nonaktif</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-rows-2 rounded-lg">
                        {{-- Edit --}}
                        <a href="{{ url('/admin-manage-instructor/edit/' . $myInstructor['fullname']) }}" class="bg-custom-green flex flex-col justify-center p-3 overflow-hidden"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-width="2" d="m14.36 4.079l.927-.927a3.932 3.932 0 0 1 5.561 5.561l-.927.927m-5.56-5.561s.115 1.97 1.853 3.707C17.952 9.524 19.92 9.64 19.92 9.64m-5.56-5.561l-8.522 8.52c-.577.578-.866.867-1.114 1.185a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.094 3.281m17.6-10.162L11.4 18.16c-.577.577-.866.866-1.184 1.114a6.554 6.554 0 0 1-1.211.749c-.364.173-.751.302-1.526.56l-3.281 1.094m0 0l-.802.268a1.06 1.06 0 0 1-1.342-1.342l.268-.802m1.876 1.876l-1.876-1.876"/></svg></a>
                        @if ($myInstructor->enrollments()->count() === 0)
                            {{-- Delete --}}
                            <button class="bg-custom-destructive flex flex-col justify-center p-3 overflow-hidden deleteInstructorButton"  data-id="{{ $myInstructor['id'] }}" data-name="{{ $myInstructor['fullname'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></button>
                        @else
                            {{-- Unclickable Delete --}}
                            <div class="bg-custom-destructive flex flex-col justify-center p-3 overflow-hidden opacity-40"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#EBF0F2" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- Delete Instructor Overlay --}}
    <div id="deleteInstructorOverlay" class="fixed hidden z-40 items-center justify-center top-0 left-0 w-full h-full bg-custom-dark/70">
        {{-- Delete Instructor Confirmation --}}
        <div id="deleteInstructorDialogBox" class="relative w-80 lg:w-[28rem] bottom-0 py-4 z-40 bg-custom-white rounded-xl">
            <div class="flex flex-row sticky px-5 bg-custom-white justify-between items-center pt-1 pb-4">
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Kelas?</h2>
                <button type="button" id="XDeleteInstructorDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus kelas <strong id="instructorNameToDelete"></strong> ?</p>
            </div>
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeDeleteInstructorDialogBox" class="w-fit rounded text-left p-3 text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesDeleteInstructor" class="w-fit rounded text-left p-3 bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Hapus Kelas</button>
                <form id="deleteInstructorForm" method="post" class="mb-1 hidden">
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
        $(document).on('click', '.deactivate-instructor, .activate-instructor', function() {
            var button = $(this);
            var instructorId = button.data('id');
            var actionUrl = button.hasClass('deactivate-instructor') ? '/admin-deactivate-instructor' : '/admin-activate-instructor';
            var newAvailability = button.hasClass('deactivate-instructor') ? 0 : 1;

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: instructorId,
                    availability: newAvailability
                },
                success: function(response) {
                    if (response.success) {
                        // Update the button and text dynamically
                        if (newAvailability === 0) {
                            button.removeClass('deactivate-instructor').addClass('activate-instructor');
                            button.find('.w-7').removeClass('right-0').addClass('left-0');
                            button.find('.w-12').removeClass('bg-custom-green').addClass('bg-custom-disabled-light/50');
                            button.next('p').text('Nonaktif');
                        } else {
                            button.removeClass('activate-instructor').addClass('deactivate-instructor');
                            button.find('.w-7').removeClass('left-0').addClass('right-0');
                            button.find('.w-12').removeClass('bg-custom-disabled-light/50').addClass('bg-custom-green');
                            button.next('p').text('Aktif');
                        }
                    } else {
                        alert('Failed to update instructor availability');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred');
                }
            });
        });

        let instructorId;

        $('.deleteInstructorButton').on('click', function() {
            instructorId = $(this).data('id');
            const instructorName = $(this).data('name');
            $('#deleteInstructorName').text(instructorName);
            $('#deleteInstructorForm').attr('action', `/admin-delete-instructor/${instructorId}`);
            $('#deleteInstructorOverlay').removeClass('hidden');
            $('#deleteInstructorOverlay').addClass('flex');
        });

        $('#XDeleteInstructorDialogBox, #closeDeleteInstructorDialogBox').on('click', function() {
            $('#deleteInstructorOverlay').addClass('hidden');
            $('#deleteInstructorOverlay').removeClass('flex');
        });

        // Handle the form submission
        $('#yesDeleteInstructor').on('click', function (e) {
            e.preventDefault();
            $('#deleteInstructorForm').submit();
        });
    </script>
@endsection