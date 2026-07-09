@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container content-measure">
            <h1>Something went wrong</h1>
            <p>Please try again later. If the problem continues, contact Liberty Centre.</p>
            <a class="btn btn-primary" href="{{ url('/') }}">Return home</a>
            <a class="btn btn-outline-primary" href="{{ url('/contact') }}">Contact Us</a>
        </div>
    </section>
@endsection
