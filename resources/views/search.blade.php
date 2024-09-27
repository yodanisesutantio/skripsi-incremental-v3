@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <div class="mt-3 mb-6 lg:mt-20 lg:mb-16 lg:px-40 flex flex-col gap-3 lg:items-center h-fit">
        <form action="{{ route('search.results') }}" method="GET" id="searchForm" class="w-full h-fit mx-auto font-league">
            <label for="search" class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl mt-5 lg:mt-10">Pencarian</label>
            <div class="relative mt-3 lg:mt-5">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="#646464" stroke-width="1.5"><circle cx="11.5" cy="11.5" r="9.5"/><path stroke-linecap="round" d="M18.5 18.5L22 22"/></g></svg>
                </div>
                <input type="search" name="searchQuery" id="search" class="block w-full p-4 ps-12 text-base/tight placeholder:text-base/tight lg:text-xl/snug lg:placeholder:text-xl/snug text-custom-grey border border-custom-grey rounded-lg bg-custom-white-hover focus:ring-custom-dark" placeholder="Coba 'Manual' atau 'Surabaya'" required />
            </div>
        </form>

        {{-- The Query History --}}
        @if (!$userSearchHistory->isEmpty())
            <div class="flex lg:grid flex-col lg:grid-cols-2 gap-3 lg:gap-4 w-full">
                @foreach ($userSearchHistory as $history)
                    {{-- Search History --}}
                    <div class="historyWrapper flex flex-row justify-between items-center lg:hover:bg-custom-disabled-dark/20 rounded-lg cursor-pointer duration-300">
                        <p class="queryHistory p-3 lg:p-4 line-clamp-1 whitespace-nowrap text-custom-dark text-base/tight lg:text-xl/tight font-league font-normal w-full" data-query="{{ $history['searchQuery'] }}">{{ $history['searchQuery'] }}</p>

                        {{-- Delete History Button --}}
                        <button type="button" class="deleteHistory" data-id="{{ $history->id }}"><svg class="cursor-pointer mr-3 lg:mr-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256"><path fill="#040B0D" d="M205.66 194.34a8 8 0 0 1-11.32 11.32L128 139.31l-66.34 66.35a8 8 0 0 1-11.32-11.32L116.69 128L50.34 61.66a8 8 0 0 1 11.32-11.32L128 116.69l66.34-66.35a8 8 0 0 1 11.32 11.32L139.31 128Z"/></svg></button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        // Handle click on the query history to submit the search form
        $('.queryHistory').on('click', function() {
            // Get the search query from the data attribute
            var searchQuery = $(this).data('query');
            
            // Set the value of the search input
            $('#search').val(searchQuery);
            
            // Submit the search form
            $('#searchForm').submit();
        });

        // Handle click on the delete history button
        $('.historyWrapper').on('click', '.deleteHistory', function(event) {
            event.preventDefault(); // Prevent default action

            var id = $(this).data('id'); // Get the ID of the search history item

            $.ajax({
                url: '/search-history/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Remove the item from the DOM
                    $('button[data-id="' + id + '"]').closest('.historyWrapper').remove();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message); // Show error message
                }
            });
        });
    </script>
@endsection