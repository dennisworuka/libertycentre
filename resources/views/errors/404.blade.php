@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container content-measure">
            <h1>Page not found</h1>
            <p>The page may have moved, or the address may be incorrect.</p>
            <a class="btn btn-primary" href="{{ url('/') }}">Return home</a>
            <a class="btn btn-outline-primary" href="{{ url('/contact') }}">Contact Us</a>
        </div>
    </section>
@endsection
