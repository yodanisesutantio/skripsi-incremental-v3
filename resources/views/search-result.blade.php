@extends('layouts.main')

@include('partials.navbar')

@section('content')
    <h1 class="text-custom-dark font-encode tracking-tight font-semibold text-2xl/tight lg:text-4xl my-5 lg:mt-10 mb-8">Hasil Pencarian untuk "{{ $query }}"</h1>

    @include('partials.footer')
@endsection