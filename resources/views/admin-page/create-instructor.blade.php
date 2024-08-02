@extends('layouts.relative')

@section('content')
    {{-- Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Tambah Instruktur Baru</h1>
            <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Masukkan informasi instruktur baru anda</p>
        </div>
    </div>

    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-3xl lg:text-4xl/snug tracking-tight text-custom-dark font-encode font-semibold">Tambah Instruktur Baru</h1>
                <p class="text-custom-grey text-lg/tight font-league lg:text-xl">Masukkan informasi instruktur baru anda</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="/admin-manage-instructor/create" method="post" enctype="multipart/form-data" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                {{-- Form Sub Headers --}}
                <div class="mb-4 lg:mt-4">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Unggah Sertifikat Instruktur</h2>
                </div>

                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input certificatePath --}}
                    <div class="flex flex-col gap-2">
                        <label for="certificatePath" class="cursor-pointer rounded-lg">
                            <div class="relative flex flex-col items-center justify-center w-full rounded-lg h-60 bg-cover bg-center bg-custom-disabled-light/60 hover:bg-custom-disabled-light border-2 border-custom-grey border-dashed overflow-hidden duration-300" id="certificatePath_wrapper">
                                <div class="absolute top-0 left-0 w-full h-full hover:bg-custom-dark/30 duration-300 hidden" id="certificatePath_overlay"></div>
                                <div class="flex flex-col items-center justify-center px-8 pt-5 pb-6" id="uploadInfo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"><path fill="#646464" d="M18 8a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/><path fill="#646464" fill-rule="evenodd" d="M11.943 1.25h.114c2.309 0 4.118 0 5.53.19c1.444.194 2.584.6 3.479 1.494c.895.895 1.3 2.035 1.494 3.48c.19 1.411.19 3.22.19 5.529v.088c0 1.909 0 3.471-.104 4.743c-.104 1.28-.317 2.347-.795 3.235c-.21.391-.47.742-.785 1.057c-.895.895-2.035 1.3-3.48 1.494c-1.411.19-3.22.19-5.529.19h-.114c-2.309 0-4.118 0-5.53-.19c-1.444-.194-2.584-.6-3.479-1.494c-.793-.793-1.203-1.78-1.42-3.006c-.215-1.203-.254-2.7-.262-4.558c-.002-.473-.002-.973-.002-1.501v-.058c0-2.309 0-4.118.19-5.53c.194-1.444.6-2.584 1.494-3.479c.895-.895 2.035-1.3 3.48-1.494c1.411-.19 3.22-.19 5.529-.19m-5.33 1.676c-1.278.172-2.049.5-2.618 1.069c-.57.57-.897 1.34-1.069 2.619c-.174 1.3-.176 3.008-.176 5.386v.844l1.001-.876a2.3 2.3 0 0 1 3.141.104l4.29 4.29a2 2 0 0 0 2.564.222l.298-.21a3 3 0 0 1 3.732.225l2.83 2.547c.286-.598.455-1.384.545-2.493c.098-1.205.099-2.707.099-4.653c0-2.378-.002-4.086-.176-5.386c-.172-1.279-.5-2.05-1.069-2.62c-.57-.569-1.34-.896-2.619-1.068c-1.3-.174-3.008-.176-5.386-.176s-4.086.002-5.386.176" clip-rule="evenodd"/></svg>
                                    <p class="mt-4 mb-2 text-base text-center text-custom-grey"><span class="font-semibold">Tekan untuk memilih foto yang akan diupload</span> atau seret foto anda ke area ini</p>
                                    <p class="text-sm text-custom-grey text-center">Format yang didukung .jpg, .png, atau .webp (MAX. 2 MB)</p>
                                </div>
                            </div>
                        </label>
                        <input id="certificatePath" name="certificatePath" type="file" class="hidden">
                        @error('certificatePath')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>        
    
                    {{-- Input startDateCertificate --}}
                    <div class="flex flex-col gap-2">
                        <label for="startCertificateDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Awal Berlaku<span class="text-custom-destructive">*</span></label>
                        <input type="date" name="startCertificateDate" id="startCertificateDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('startCertificateDate') border-2 border-custom-destructive @enderror" value="{{ old('startCertificateDate') }}">
                        @error('startCertificateDate')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Input endDateCertificate --}}
                    <div class="flex flex-col gap-2">
                        <label for="endCertificateDate" class="font-semibold font-league text-xl text-custom-grey">Tanggal Akhir Berlaku<span class="text-custom-destructive">*</span></label>
                        <input type="date" name="endCertificateDate" id="endCertificateDate" class="p-4 font-league font-medium text-lg text-custom-secondary placeholder:#48484833 rounded-lg @error('endCertificateDate') border-2 border-custom-destructive @enderror" value="{{ old('endCertificateDate') }}">
                        @error('endCertificateDate')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Form Sub Headers --}}
                <div class="mb-4 mt-8">
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode font-semibold">Data Akun Instruktur</h2>
                </div>

                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Input Profile Picture --}}
                    <div class="flex flex-col gap-2">
                        <label for="hash_for_profile_picture" class="font-semibold font-league text-xl text-custom-grey">Gambar Profil (Optional)</label>
                        <label for="hash_for_profile_picture" class="relative w-fit">
                            <div class="p-2 w-fit rounded-full bg-custom-disabled-dark/90 absolute bottom-0 right-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path fill="#EBF0F2" d="m11.4 18.161l7.396-7.396a10.289 10.289 0 0 1-3.326-2.234a10.29 10.29 0 0 1-2.235-3.327L5.839 12.6c-.577.577-.866.866-1.114 1.184a6.556 6.556 0 0 0-.749 1.211c-.173.364-.302.752-.56 1.526l-1.362 4.083a1.06 1.06 0 0 0 1.342 1.342l4.083-1.362c.775-.258 1.162-.387 1.526-.56c.43-.205.836-.456 1.211-.749c.318-.248.607-.537 1.184-1.114m9.448-9.448a3.932 3.932 0 0 0-5.561-5.561l-.887.887l.038.111a8.754 8.754 0 0 0 2.092 3.32a8.754 8.754 0 0 0 3.431 2.13z"/></svg>
                            </div>
                            <div class="w-28 lg:w-32 h-28 lg:h-32 rounded-full bg-cover bg-center cursor-pointer overflow-hidden" style="background-image: url('{{ asset('img/blank-profile.webp') }}')" id="profilePicture">
                                <div class="flex items-center justify-center w-full h-full hover:bg-custom-dark/50 duration-300">
                                </div>
                            </div>
                        </label>
                        <input type="file" name="hash_for_profile_picture" id="hash_for_profile_picture" class="hidden">
                        @error('hash_for_profile_picture')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
    
                    {{-- Input Full Name --}}
                    <div class="flex flex-col gap-2">
                        <label for="fullname" class="font-semibold font-league text-xl text-custom-grey">Nama Instruktur Kursus<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="fullname" id="fullname" placeholder="Nama Lengkap" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('fullname') border-2 border-custom-destructive @enderror" value="{{ old('fullname') }}">
                        @error('fullname')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Username --}}
                    <div class="flex flex-col gap-2">
                        <label for="username" class="font-semibold font-league text-xl text-custom-grey">Username<span class="text-custom-destructive">*</span></label>
                        <input type="text" name="username" id="username" placeholder="user_name_123" class="p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('username') border-2 border-custom-destructive @enderror" value="{{ old('username') }}">
                        @error('username')
                            @if ($message === 'The username has already been taken.')
                                <span class="text-custom-destructive">{{ $message }}</span>    
                            @else
                                <span class="text-custom-destructive">{{ $message }}</span>
                            @endif
                        @enderror
                    </div>
                    {{-- Input Age --}}
                    <div class="flex flex-col gap-2">
                        <label for="age" class="font-semibold font-league text-xl text-custom-grey">Usia Instruktur (opsional)</label>
                        <input type="number" name="age" id="age" min="18" max="99" placeholder="Usia minimal adalah 18 tahun" class="w-full p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('age') border-2 border-custom-destructive @enderror" value="{{ old('age') }}">
                        @error('age')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Description --}}
                    <div class="flex flex-col gap-2">
                        <label for="description" class="font-semibold font-league text-xl text-custom-grey">Deskripsi (opsional)</label>
                        <textarea name="description" id="description" rows="5" placeholder="Buat personal anda menarik" class="px-4 py-3.5 h-36 font-league font-medium text-lg/snug text-custom-secondary placeholder:#48484833 resize-none rounded-lg @error('description') border-2 border-custom-destructive @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Phone Number --}}
                    <div class="flex flex-col gap-2">
                        <label for="phone_number" class="font-semibold font-league text-xl text-custom-grey">Nomor Whatsapp Aktif<span class="text-custom-destructive">*</span></label>
                        <input type="tel" name="phone_number" id="phone_number" placeholder="081818181818" class="w-full p-4 font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('phone_number') border-2 border-custom-destructive @enderror" value="{{ old('phone_number') }}" oninput="deleteAnyString(this)">
                        @error('phone_number')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- Input Password --}}
                    <div class="flex flex-col gap-2">
                        <label for="password" class="font-semibold font-league text-xl text-custom-grey">Masukkan Password Baru<span class="text-custom-destructive">*</span></label>
                        <div class="relative flex justify-end items-center">
                            <input type="password" name="password" id="password" placeholder="Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                            <div class="eyeIcon absolute mr-3" onclick="showHidePass()">
                                <svg id="showPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#495D6477" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>

                                <svg id="hidePass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="flex flex-col gap-2">
                        <label for="password_confirmation" class="font-semibold font-league text-xl text-custom-grey">Ketik Ulang Password Baru<span class="text-custom-destructive">*</span></label>
                        <div class="relative flex justify-end items-center">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ketik Ulang Password Baru" class="relative py-4 pl-4 pr-10 w-full font-league font-medium text-lg/[0] text-custom-secondary placeholder:#48484833 rounded-lg @error('password') border-2 border-custom-destructive @enderror">
                            <div class="eyeIcon absolute mr-3" onclick="showHideConfirmPass()">
                                <svg id="showConfirmPass" class="cursor-pointer" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" d="M9.75 12a2.25 2.25 0 1 1 4.5 0a2.25 2.25 0 0 1-4.5 0"/><path fill="#495D6477" fill-rule="evenodd" d="M2 12c0 1.64.425 2.191 1.275 3.296C4.972 17.5 7.818 20 12 20c4.182 0 7.028-2.5 8.725-4.704C21.575 14.192 22 13.639 22 12c0-1.64-.425-2.191-1.275-3.296C19.028 6.5 16.182 4 12 4C7.818 4 4.972 6.5 3.275 8.704C2.425 9.81 2 10.361 2 12m10-3.75a3.75 3.75 0 1 0 0 7.5a3.75 3.75 0 0 0 0-7.5" clip-rule="evenodd"/></svg>

                                <svg id="hideConfirmPass" class="cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24"><path fill="#495D6477" fill-rule="evenodd" d="M1.606 6.08a1 1 0 0 1 1.313.526L2 7l.92-.394v-.001c0-.001 0 0 0 0l.003.009l.021.045c.02.042.051.108.094.194c.086.172.219.424.4.729a13.37 13.37 0 0 0 1.67 2.237a11.966 11.966 0 0 0 .59.592C7.18 11.8 9.251 13 12 13a8.706 8.706 0 0 0 3.22-.602c1.227-.483 2.254-1.21 3.096-1.998a13.053 13.053 0 0 0 2.733-3.725l.027-.058l.005-.011a1 1 0 0 1 1.838.788L22 7l.92.394l-.003.005l-.004.008l-.011.026l-.04.087a14.045 14.045 0 0 1-.741 1.348a15.368 15.368 0 0 1-1.711 2.256l.797.797a1 1 0 0 1-1.414 1.415l-.84-.84a11.81 11.81 0 0 1-1.897 1.256l.782 1.202a1 1 0 1 1-1.676 1.091l-.986-1.514c-.679.208-1.404.355-2.176.424V16.5a1 1 0 0 1-2 0v-1.544c-.775-.07-1.5-.217-2.177-.425l-.985 1.514a1 1 0 0 1-1.676-1.09l.782-1.203c-.7-.37-1.332-.8-1.897-1.257l-.84.84a1 1 0 0 1-1.414-1.414l.797-.797a15.406 15.406 0 0 1-1.87-2.519a13.457 13.457 0 0 1-.591-1.107a5.418 5.418 0 0 1-.033-.072l-.01-.021l-.002-.007l-.001-.002v-.001C1.08 7.395 1.08 7.394 2 7l-.919.395a1 1 0 0 1 .525-1.314" clip-rule="evenodd"/></svg>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="/admin-manage-instructor" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Tambah</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="/admin-manage-instructor" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Tambah</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('form[action="/admin-manage-instructor/create"]').submit();
        });

        // Tel Input Script
        const phoneInputField = document.getElementById('phone_number');        
        const intlTelInput = window.intlTelInput(phoneInputField, {
            initialCountry: "ID", 
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js"
        });
        phoneInputField.addEventListener('keypress', function(event) {
            let value = input.value.replace(/\D/g, '');
            if (isNaN(event.key)) {
                event.preventDefault(); // Prevent non-numerical input
            }
        });
        function deleteAnyString(input) {
            let value = input.value.replace(/\D/g, '');
            input.value = value;
        }

        // Add Shadow to Form Header
        $(window).on('scroll', function () {
            const scrolled = $(this).scrollTop();
            if (scrolled > 15) {
                $('#form-header').addClass('shadow-lg');
            } else {
                $('#form-header').removeClass('shadow-lg');
            }
        });

        // Show and Hide Password Input
        function showHidePass() {
            const $showPass = $('#showPass');
            const $hidePass = $('#hidePass');
            const $passwordInput = $('#password');

            if ($passwordInput.attr('type') === "password") {
                $showPass.css('display', 'block');
                $hidePass.css('display', 'none');
            } else {
                $showPass.css('display', 'none');
                $hidePass.css('display', 'block');
            }
            
            $passwordInput.attr('type', $passwordInput.attr('type') === "password" ? "text" : "password");
        }

        // Show and Hide Password Confirmation Input
        function showHideConfirmPass() {
            const $showConfirmPass = $('#showConfirmPass');
            const $hideConfirmPass = $('#hideConfirmPass');
            const $confirmPasswordInput = $('#password_confirmation');

            if ($confirmPasswordInput.attr('type') === "password") {
                $showConfirmPass.css('display', 'block');
                $hideConfirmPass.css('display', 'none');
            } else {
                $showConfirmPass.css('display', 'none');
                $hideConfirmPass.css('display', 'block');
            }
            
            $confirmPasswordInput.attr('type', $confirmPasswordInput.attr('type') === "password" ? "text" : "password");
        }

        // Assist the user to avoid adding space in their username
        $("#username").on("keydown input", function(event) {
            if (event.type === "keydown" && event.keyCode === 32) {
                event.preventDefault(); // Prevent space on keydown
            } else if (event.type === "input") {
                $(this).val($(this).val().replace(/\s/g, "")); // Remove spaces on input
            }
        });

        // Preview the uploaded profile picture
        $('#hash_for_profile_picture').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#profilePicture').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                }
                reader.readAsDataURL(file); // Read the file as a data URL
            }
        });

        // Preview the Uploaded Thumbnail
        $('#certificatePath').on('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#certificatePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#certificatePath_overlay').removeClass('hidden');
                $('#certificatePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });

        const dropArea = $('#certificatePath_wrapper');
        // Prevent default browser behavior for drag/drop events
        dropArea.on({
            dragover: function(e) {
                e.preventDefault();
                $(this).removeClass('bg-custom-disabled-light/60'); // Optional: Add hover styling
                $(this).addClass('bg-custom-disabled-light'); // Optional: Add hover styling
            },
            dragleave: function(e) {
                e.preventDefault();
                $(this).addClass('bg-custom-disabled-light/60'); // Optional: Add hover styling
                $(this).removeClass('bg-custom-disabled-light'); // Optional: Remove hover styling
            },
            drop: function(e) {
                e.preventDefault();
                $(this).addClass('bg-custom-disabled-light/60'); // Optional: Add hover styling
                $(this).removeClass('bg-custom-disabled-light'); // Optional: Remove hover styling

                const file = e.originalEvent.dataTransfer.files[0];

                if (file) {
                    // Process the dropped file (e.g., display preview, upload)
                    handleDroppedFile(file);
                }
            }
        });

        function handleDroppedFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#certificatePath_wrapper').css('background-image', 'url(' + e.target.result + ')'); // Update the background image
                $('#certificatePath_overlay').removeClass('hidden');
                $('#certificatePath_wrapper').removeClass('border-2 border-custom-grey border-dashed');
                $('#uploadInfo').addClass('hidden'); //Hide the uploadInfo
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        }
    </script>
@endsection