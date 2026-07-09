@extends('layouts.app')

@section('content')
    <section class="section-band bg-white">
        <div class="container content-measure">
            <h1>Downloads</h1>
            @forelse($downloadsByCategory as $category => $downloads)
                <section class="content-block">
                    <h2>{{ $category }}</h2>
                    @foreach($downloads as $download)
                        <article class="download-row">
                            <h3>{{ $download->title }}</h3>
                            <p>{{ $download->description }}</p>
                            <a href="{{ asset($download->file_path) }}">Download {{ $download->title }}</a>
                        </article>
                    @endforeach
                </section>
            @empty
                <p class="empty-state">Downloads will appear here.</p>
            @endforelse
        </div>
    </section>
@endsection
