@extends('layouts.relative')

@section('content')
    {{-- Desktop View Forms Header --}}
    <div class="sticky z-40 top-0 pt-8 pb-4 bg-custom-white flex flex-col gap-5 lg:hidden" id="form-header">
        <div class="flex flex-col gap-1 px-6">
            <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Ubah Jadwal</h1>
            <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ajukan perubahan jadwal untuk <strong class="font-semibold">Pertemuan {{ $schedule->meeting_number }}</strong></p>
        </div>
    </div>

    {{-- Mobile View Forms Header --}}
    <div class="lg:grid lg:grid-cols-3 lg:pl-16 lg:pr-48">
        <div class="pt-8 pb-4 bg-custom-white flex-col gap-5 hidden lg:flex" id="form-header">
            <div class="flex flex-col gap-1 px-6">
                <h1 class="text-2xl/tight lg:text-4xl text-custom-dark font-encode tracking-tight font-semibold">Ubah Jadwal</h1>
                <p class="text-custom-grey text-lg/tight lg:text-2xl/tight font-league">Ajukan perubahan jadwal untuk <strong class="font-semibold">Pertemuan {{ $schedule->meeting_number }}</strong></p>
            </div>
        </div>

        <div class="lg:col-span-2 lg:px-24">
            <form action="{{ url('/admin-course/new-schedule/' . $schedule->id) }}" method="post" class="px-6 pb-24 lg:pt-5 lg:pb-0">
                @csrf

                <div class="flex flex-col mt-4 gap-5 lg:gap-7">
                    {{-- Form Sub Headers --}}
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Jadwal Kursus</h2>

                    {{-- Select Date --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_date" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Tanggal Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Input Number Column --}}
                        <input type="date" name="course_date" id="course_date" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_date') border-2 border-custom-destructive @enderror" value="{{ \Carbon\Carbon::parse($schedule['start_time'])->format('Y-m-d') }}">
                        {{-- Error in Validation Message --}}
                        @error('course_date')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Select Time --}}
                    <div class="flex flex-col gap-1">
                        <label for="course_time" class="font-semibold font-league text-lg lg:text-xl text-custom-grey">Pilih Jam Kursus<span class="text-custom-destructive">*</span></label>
                        {{-- Dropdown --}}
                        <select name="course_time" id="course_time" class="px-3 py-4 font-league font-medium text-lg bg-custom-white-hover text-custom-secondary placeholder:#48484833 rounded-lg @error('course_time') border-2 border-custom-destructive @enderror">
                            <option disabled>-- Pilih Jam Kursus --</option>
                            @php
                                $openTime = \Carbon\Carbon::parse(auth()->user()->open_hours_for_admin);
                                $closeTime = \Carbon\Carbon::parse(auth()->user()->close_hours_for_admin);
                                $courseDuration = $schedule->course['course_duration']; // Assuming this is in minutes

                                // Get start and end time from schedule
                                $startTime = \Carbon\Carbon::parse($schedule['start_time']);
                                $endTime = \Carbon\Carbon::parse($schedule['end_time']);

                                while ($openTime->lessThan($closeTime)) {
                                    // Calculate the end time for the current open time
                                    $endOptionTime = $openTime->copy()->addMinutes($courseDuration);

                                    // Check if the end time exceeds the close time
                                    if ($endOptionTime->greaterThan($closeTime)) {
                                        break; // Exit the loop if it exceeds
                                    }

                                    // Check if the time falls within the lunch break
                                    if ($openTime->between('11:30', '13:00', true) || $endOptionTime->between('11:30', '13:00', true)) {
                                        // Skip this time slot
                                        $openTime->addMinutes($courseDuration); // Move to the next time slot
                                        continue;
                                    }

                                    // Format time for display
                                    $formattedTime = $openTime->format('H:i') . ' - ' . $openTime->copy()->addMinutes($courseDuration)->format('H:i');
                                    
                                    // Check if the generated time matches the schedule's start and end time
                                    $isSelected = $openTime->equalTo($startTime) && $endOptionTime->equalTo($endTime) ? 'selected' : '';

                                    echo "<option value=\"{$formattedTime}\" {$isSelected}>{$formattedTime}</option>";

                                    // Add course duration to the current time
                                    $openTime->addMinutes($courseDuration);
                                }
                            @endphp
                        </select>
                        {{-- Error in Validation Message --}}
                        @error('course_time')
                            <span class="text-custom-destructive">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Form Sub Header --}}
                    <h2 class="text-xl lg:text-2xl/snug text-custom-dark font-encode tracking-tight font-semibold">Pilih Instruktur</h2>
                </div>

                {{-- Button Groups for Desktop View --}}
                <div class="lg:flex flex-row w-full lg:mt-5 py-4 lg:py-5 items-center justify-between bg-custom-white hidden">
                    <a href="{{ url('/admin-course-progress/' . $schedule->enrollment->student_real_name . '/' . $schedule->enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover cancelLink">Batal</a>
                    <button type="submit" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sticky Button Groups for Mobile --}}
    <div class="flex flex-row fixed w-full z-20 bottom-0 px-6 py-4 lg:py-5 items-center justify-between bg-custom-white lg:hidden">
        <a href="{{ url('/admin-course-progress/' . $schedule->enrollment->student_real_name . '/' . $schedule->enrollment['id']) }}" class="text-custom-dark font-league font-medium px-1 pt-2 pb-1 text-lg/none underline hover:text-custom-green-hover">Batal</a>
        <button type="submit" id="mobileSubmitButton" class="px-12 py-3 rounded-lg lg:rounded-lg bg-custom-green hover:bg-custom-green-hover text-center lg:text-lg text-custom-white-hover font-semibold lg:order-2 duration-500">Ajukan</button>
    </div>

    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>

    </script>
@endsection