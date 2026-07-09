@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container content-measure">
            <h1>Access restricted</h1>
            <p>You do not have permission to view this page.</p>
            <a class="btn btn-primary" href="{{ url('/') }}">Return home</a>
            <a class="btn btn-outline-primary" href="{{ url('/contact') }}">Contact Us</a>
        </div>
    </section>
@endsection
