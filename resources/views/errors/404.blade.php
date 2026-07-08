@extends('layouts.app')

@section('content')

    <x-section>
        <div class="text-center py-5">
            <h1 class="display-4 mb-3">Page not found</h1>
            <p class="text-measure mx-auto mb-4">
                The page you're looking for may have moved or no longer exists. Here are some places to try instead.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-primary">Return home</a>
                <a href="{{ route('services.index') }}" class="btn btn-outline-primary">Our services</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary">Contact us</a>
            </div>
        </div>
    </x-section>

@endsection
