@extends('layouts.app')

@section('content')

    <x-section>
        <div class="text-center py-5">
            <h1 class="display-4 mb-3">Access denied</h1>
            <p class="text-measure mx-auto mb-4">
                You don't have permission to view that page.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary">Return home</a>
        </div>
    </x-section>

@endsection
