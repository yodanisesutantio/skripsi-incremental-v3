@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-xl/tight lg:text-4xl mt-5 lg:mt-10">Instruktur Anda</h1>
    <p class="text-custom-grey font-league font-medium text-lg/tight lg:text-2xl/tight mt-1">Pilih salah satu Instruktur untuk anda kelola!</p>

    {{-- Add New Instructor Button --}}
    <div class="flex">
        <a href="admin-manage-instructor/create"><div class="w-fit pl-3.5 pr-5 py-3 my-3 rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white font-semibold duration-500">+ Tambah Instruktur</div></a>
    </div>

    {{-- If Instructors collection is not exist, show this --}}
    @if ($instructors->isEmpty())
        <p class="font-league text-center lg:text-xl my-20 lg:my-14">(Anda belum mempunyai instruktur)</p>

    {{-- If instructors collection exist, show this instead --}}
    @else
        {{-- Instructors List --}}
        <div class="w-full flex lg:grid flex-col lg:grid-cols-3 gap-4 lg:gap-6 mt-8 lg:mt-10 mb-7 lg:mb-14">
            {{-- Display every data in Instructors Collection --}}
            @foreach ($instructors as $myInstructor)
            <div class="flex flex-row gap-3 w-full rounded-xl bg-custom-white-hover drop-shadow-lg overflow-hidden">
                {{-- Show this if Instructors profile_picture exist --}}
                @if ($myInstructor['hash_for_profile_picture'])
                    <img src="{{ asset('storage/profile_pictures/' . $myInstructor->hash_for_profile_picture) }}" alt="Profile Pictures" class="object-cover object-center rounded-lg w-20 lg:w-24 flex-grow">

                {{-- Show this if Instructors profile_picture not exist --}}
                @else
                    <img src="{{ asset('img/blank-profile.webp') }}" alt="Profile Pictures" class="object-cover object-center rounded-lg w-20 lg:w-24 flex-grow">
                @endif

                <div class="flex flex-row justify-between w-full gap-2">
                    <div class="flex flex-col gap-7 pt-2 pb-3">
                        <div class="flex flex-col gap-1">
                            {{-- Instructor's Fullname --}}
                            <h2 class="font-encode tracking-tight font-semibold text-xl lg:text-2xl">{{ $myInstructor['fullname'] }}</h2>
                            {{-- Teaching Status --}}
                            <i class="font-league font-medium text-base/tight lg:text-lg text-custom-grey">Sedang mengajar {{ $myInstructor->enrollments->count() }} Siswa</i>
                        </div>

                        {{-- If instructor has a validated certificate make the switch clickable --}}
                        @if ($myInstructor->instructorCertificate->isNotEmpty() && $myInstructor->instructorCertificate->first()->certificateStatus === 'Sudah Divalidasi')
                            {{-- Deactivate Switch --}}
                            @if ($myInstructor['availability'] === 1)
                            <div class="flex flex-row gap-2.5 mb-1">
                                <button type="button" class="relative flex items-center deactivate-instructor" data-id="{{ $myInstructor['id'] }}">
                                    <div class="flex-shrink-0 w-12 h-4 bg-custom-green rounded-full"></div>
                                    <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg right-0"></div>
                                </button>
                                <p class="text-sm/snug lg:text-base/tight">Aktif</p>
                            </div>

                            {{-- Activate Switch --}}
                            @else
                            <div class="flex flex-row gap-2.5 mb-1">
                                <button type="button" class="relative flex items-center activate-instructor" data-id="{{ $myInstructor['id'] }}">
                                    <div class="flex-shrink-0 w-12 h-4 bg-custom-disabled-light/50 rounded-full"></div>
                                    <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg left-0"></div>
                                </button>
                                <p class="text-sm/snug lg:text-base/tight">Nonaktif</p>
                            </div>
                            @endif

                        {{-- If instructor has no validated certificate make the switch unclickable --}}
                        @else
                            <div class="flex flex-row gap-2.5 mb-1">
                                <button type="button" class="relative flex items-center cantActivateInstructorButton" data-name="{{ $myInstructor['fullname'] }}">
                                    <div class="flex-shrink-0 w-12 h-4 bg-custom-disabled-light/50 rounded-full"></div>
                                    <div class="flex-shrink-0 absolute w-7 h-7 bg-custom-white-hover rounded-full drop-shadow-lg left-0"></div>
                                </button>
                                <p class="text-sm/snug lg:text-base/tight">Nonaktif</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-rows-1rounded-lg">
                        {{-- If Instructor has no active student, make the delete button clickable --}}
                        @if ($myInstructor->enrollments()->count() === 0)
                            {{-- Delete --}}
                            <button class="bg-custom-destructive hover:bg-[#EC2013] duration-300 flex flex-col justify-center p-3 overflow-hidden deleteInstructorButton" data-id="{{ $myInstructor['id'] }}" data-name="{{ $myInstructor['fullname'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></button>

                        {{-- If Instructor has an active student, make the delete button unclickable --}}
                        @else
                            {{-- Unclickable Delete --}}
                            <div class="bg-custom-destructive flex flex-col justify-center p-3 overflow-hidden opacity-40 cantDeleteInstructorButton" data-name="{{ $myInstructor['fullname'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="none" stroke="#F7F7F7" stroke-linecap="round" stroke-width="2" d="M9.17 4a3.001 3.001 0 0 1 5.66 0m5.67 2h-17m15.333 2.5l-.46 6.9c-.177 2.654-.265 3.981-1.13 4.79c-.865.81-2.196.81-4.856.81h-.774c-2.66 0-3.991 0-4.856-.81c-.865-.809-.954-2.136-1.13-4.79l-.46-6.9M9.5 11l.5 5m4.5-5l-.5 5"/></svg></div>
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
                {{-- Modals Header --}}
                <h2 class="font-league text-[27px]/none pt-1 lg:text-3xl font-semibold text-custom-dark ">Hapus Instruktur?</h2>
                <button type="button" id="XDeleteInstructorDialogBox"><svg class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
            </div>

            {{-- Delete Confirmation Message --}}
            <div class="px-5 mt-2">
                <p class="font-league text-lg/snug lg:text-xl/tight text-custom-dark mb-1 lg:mb-12">Anda yakin ingin menghapus <strong id="instructorNameToDelete"></strong> ?</p>
            </div>

            {{-- Action Button Groups --}}
            <div class="flex flex-row justify-end gap-4 px-5 mt-4">                
                <button type="button" id="closeDeleteInstructorDialogBox" class="w-fit rounded text-left p-3 text-custom-dark font-semibold hover:bg-custom-dark-hover/20">Batal</button>
                <button type="submit" id="yesDeleteInstructor" class="w-fit rounded text-left p-3 bg-custom-destructive hover:bg-[#EC2013] text-custom-white font-semibold">Ya, Hapus Instruktur</button>
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
        // Activate and Deactivate Instructors
        $(document).on('click', '.deactivate-instructor, .activate-instructor', function() {
            var button = $(this); // Which button is being clicked
            var instructorId = button.data('id'); // Which instructors is it
            var actionUrl = button.hasClass('deactivate-instructor') ? '/admin-deactivate-instructor' : '/admin-activate-instructor'; // if deactivate button is clicked, redirect to admin-deactivate-instructor route, else, redirect to admin-activate-instructor
            var newAvailability = button.hasClass('deactivate-instructor') ? 0 : 1; // Bring the new value, 1 to activate, 0 to deactivate

            // AJAX Function
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: instructorId,
                    availability: newAvailability
                },

                // If availability change success, do this
                success: function(response) {
                    // Do this when availability change successful
                    if (response.success) {
                        // Update the active switch to deactivate switch
                        if (newAvailability === 0) {
                            button.removeClass('deactivate-instructor').addClass('activate-instructor');
                            button.find('.w-7').removeClass('right-0').addClass('left-0');
                            button.find('.w-12').removeClass('bg-custom-green').addClass('bg-custom-disabled-light/50');
                            button.next('p').text('Nonaktif');
                        } 
                        
                        // Update the deactivate switch to activate switch
                        else {
                            button.removeClass('activate-instructor').addClass('deactivate-instructor');
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
                    toastr.error('Terjadi Kesalahan. Silahkan Coba Lagi');
                }
            });
        });

        let instructorId;
        // Delete Course Function
        $('.deleteInstructorButton').on('click', function() {
            instructorId = $(this).data('id');
            const instructorName = $(this).data('name');
            $('#instructorNameToDelete').text(instructorName);
            $('#deleteInstructorForm').attr('action', `/admin-delete-instructor/${instructorId}`);
            $('#deleteInstructorOverlay').removeClass('hidden');
            $('#deleteInstructorOverlay').addClass('flex');
        });

        // Close Modals
        $('#XDeleteInstructorDialogBox, #closeDeleteInstructorDialogBox').on('click', function() {
            $('#deleteInstructorOverlay').addClass('hidden');
            $('#deleteInstructorOverlay').removeClass('flex');
        });

        // Handle the form submission
        $('#yesDeleteInstructor').on('click', function (e) {
            e.preventDefault();
            $('#deleteInstructorForm').submit();
        });

        // Error Toastr Message to Show When Users force to click the delete button when it cant be deleted
        $('.cantDeleteInstructorButton').on('click', function() {
            const instructorName = $(this).data('name');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning('Instruktur ' + instructorName + ' masih mengajar Siswa!');
        });

        // Error Toastr Message to Show When Users force to activate the Instructor button when it cant be activated
        $('.cantActivateInstructorButton').on('click', function() {
            const instructorName = $(this).data('name');

            toastr.options.timeOut = 4000;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.warning('Sertifikat Instruktur ' + instructorName + ' belum tervalidasi oleh Admin Sistem. Silahkan Coba Lagi Nanti!');
        });
    </script>
@endsection