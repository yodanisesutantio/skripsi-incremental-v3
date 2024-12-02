@extends('layouts.relative')

@section('content')
    {{-- Mobile View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Pilih Jadwal</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Tentukan jadwal kursus mu</p>
        </div>
    </div>


    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        {{-- Desktop View Forms Header --}}
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Pilih Jadwal</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Tentukan jadwal kursus mu</p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            {{-- New Schedule Form --}}
            <form action="{{ url('/user-course/schedule/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" method="post" id="proposeScheduleForm" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                <div class="flex flex-col mt-0 lg:mt-4 gap-5 lg:gap-7">
                    {{-- Form Sub Headers --}}
                    <h2 class="hidden lg:block text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pilih Tanggal Mulai dan Sesi Kursus</h2>

                    {{-- Select Date --}}
                    <div class="flex flex-col gap-1">
                        <label for="date-picker" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Tanggal Mulai Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Date Interface --}}
                        <div id="date-picker" class="px-2 pb-4 pt-2 lg:px-0 lg:pb-6 lg:pt-3 font-league font-normal text-base text-custom-dark rounded-lg">
                            {{-- Calendar Header --}}
                            <div class="flex justify-between items-center mb-4 lg:mb-7">
                                {{-- Prev Month --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" id="prevMonth" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 5l-6 7l6 7"/></svg>

                                {{-- Current Month --}}
                                <h2 id="currentMonth" class="text-lg/snug lg:text-xl/snug font-league font-semibold mt-0.5"></h2>

                                {{-- Next Month --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="cursor-pointer" id="nextMonth" width="30" height="30" viewBox="0 0 24 24"><path fill="none" stroke="#040B0D" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5l6 7l-6 7"/></svg>
                            </div>

                            {{-- Days Header --}}
                            <div class="grid grid-cols-7 lg:gap-3 justify-between items-center pb-1 lg:pb-2 border-b-[1px] border-custom-dark">
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Min</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Sen</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Sel</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Rab</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Kam</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Jum</h2>
                                <h2 class="font-league font-semibold text-base lg:text-lg text-center">Sab</h2>
                            </div>

                            {{-- Dates --}}
                            <div class="grid grid-cols-7 lg:gap-3 mt-2" id="calendarGrid">
                                {{-- Dates Are Generated Dynamically Here --}}
                            </div>
                        </div>

                        <p class="text-custom-destructive text-base/tight lg:text-lg/tight font-league">*Hari yang Anda pilih akan menjadi jadwal mingguan. Untuk mengubah jadwal di pertemuan tertentu, hubungi Admin Kursus.</p>
                    </div>

                    {{-- Select Time --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_time" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Jam Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdown --}}
                        <select name="course_time" id="course_time" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_time') border-2 border-custom-destructive @enderror">
                            <option disabled selected>-- Pilih Jam Kursus --</option>
                            @foreach ($availableSlots as $slot)
                                <option value="{{ $slot['start'] }} - {{ $slot['end'] }}">{{ $slot['start'] }} - {{ $slot['end'] }}</option>
                            @endforeach
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('course_time')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Kembali</a>
                    <button type="submit" class="px-8 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/user-course-progress/' . $enrollment->student_real_name . '/' . $enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover back-button">Kembali</a>
        <button type="submit" id="mobileSubmitButton" class="px-8 py-3 rounded-lg lg:rounded-lg bg-custom-green text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500 submit-button">Simpan Jadwal</button>
    </div>

    {{-- Swiper CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        const datepicker = {
            currentDate: new Date(),
            selectedDate: null,
            render() {
                const currentMonth = this.currentDate.getMonth();
                const currentYear = this.currentDate.getFullYear();

                // Update the header
                document.getElementById("currentMonth").textContent = 
                    `${this.currentDate.toLocaleString('id', { month: 'long' })} ${currentYear}`;

                // Generate the calendar grid
                this.generateCalendar(currentYear, currentMonth);
            },

            generateCalendar(year, month) {
                const grid = document.getElementById("calendarGrid");
                grid.innerHTML = ""; // Clear previous dates

                // First day of the month and total days in the month
                const today = new Date(); // Get today's date
                today.setHours(0, 0, 0, 0);
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Fill blank spaces before the first day
                for (let i = 0; i < firstDay; i++) {
                    const blankCell = document.createElement("div");
                    grid.appendChild(blankCell);
                }

                // Add actual dates
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateCell = document.createElement("button");
                    dateCell.className = "font-league font-normal text-base lg:text-lg text-center p-2 rounded-xl";

                    // Create the date text
                    const dateText = document.createElement("span");
                    dateText.textContent = day;

                    // Create the underline div
                    const underlineDiv = document.createElement("div");
                    underlineDiv.className = "w-full h-0.5 border-b-2 opacity-0";
                    underlineDiv.style.transition = "opacity 0.3s ease";

                    // Current date for comparison
                    const currentDate = new Date(year, month, day);

                    // Check if the date is before or is today
                    const isBeforeToday = currentDate < today;

                    if (isBeforeToday) {
                        // Make unselectable dates visually different
                        dateCell.classList.add("opacity-40", "cursor-not-allowed");

                        dateCell.addEventListener("click", (e) => {
                            e.preventDefault(); // Prevent the default action (form submission)
                        });
                    } else if (
                        currentDate.getDate() === today.getDate() &&
                        currentDate.getMonth() === today.getMonth() &&
                        currentDate.getFullYear() === today.getFullYear()
                    ) {
                        // Make today's date unclickable but visible
                        dateCell.classList.remove("opacity-40", "font-normal");
                        dateCell.classList.add("cursor-not-allowed", "font-bold");
                        underlineDiv.classList.add("opacity-100"); // Show underline for today

                        dateCell.addEventListener("click", (e) => {
                            e.preventDefault(); // Prevent the default action (form submission)
                        });
                    }                    
                    else {
                        // Add hover effects and click only for selectable dates
                        dateCell.classList.add("hover:bg-custom-dark/15");

                        // Add click event for date selection
                        dateCell.addEventListener("click", () => {
                            this.selectedDate = currentDate;
                            this.render(); // Re-render to update styles
                        });
                    }

                    // Highlight selected date
                    const isSelected =
                        this.selectedDate &&
                        this.selectedDate.getDate() === day &&
                        this.selectedDate.getMonth() === month &&
                        this.selectedDate.getFullYear() === year;

                    if (isSelected) {
                        dateCell.classList.add("bg-custom-green", "text-custom-white");
                        dateCell.classList.remove("hover:bg-custom-dark/15");
                    }

                    // Append text and underline to the date cell
                    dateCell.appendChild(dateText);
                    dateCell.appendChild(underlineDiv);
                    grid.appendChild(dateCell);
                }
            },
                changeMonth(offset) {
                    this.currentDate.setMonth(this.currentDate.getMonth() + offset);
                this.render();
            },
        }

        // Initialize datepicker
        datepicker.render();

        // Event listeners for navigation
        document.getElementById("prevMonth").addEventListener("click", () => {
            datepicker.changeMonth(-1);
        });

        document.getElementById("nextMonth").addEventListener("click", () => {
            datepicker.changeMonth(1);
        });

        // Mobile Submit Button Function
        $('#mobileSubmitButton').click(function(event) {
            event.preventDefault();
            $('#proposeScheduleForm').submit();
        });

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