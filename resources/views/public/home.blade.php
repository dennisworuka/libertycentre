@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                <p class="text-uppercase fw-bold mb-2" style="color: var(--lc-secondary-text);">Project scaffold</p>
                <h1 class="display-5 mb-3">Liberty Centre Limited</h1>
                <p class="lead mb-4" style="max-width: 70ch;">This fresh Laravel 12 and Filament 3 foundation is ready for the phased CMS and public website build.</p>
                <a class="btn btn-primary" href="{{ url('/admin') }}">Open admin panel</a>
            </div>
        </div>
    </section>
@endsection
